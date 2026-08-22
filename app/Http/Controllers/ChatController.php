<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    private const MAX_MESSAGES = 30;
    private const MAX_CONTENT_LENGTH = 2000;

    public function send(Request $request): JsonResponse
    {
        $messages = $request->input('messages');

        if (!is_array($messages) || count($messages) === 0) {
            return response()->json(['error' => 'At least one message is required.'], 400);
        }

        foreach ($messages as $message) {
            if (!isset($message['content']) || strlen($message['content']) > self::MAX_CONTENT_LENGTH) {
                return response()->json(['error' => 'Message content is too long.'], 400);
            }
        }

        $messages = array_slice($messages, -self::MAX_MESSAGES);
        $catalog  = $this->buildCatalogContext();

        try {
            $systemPrompt = $this->buildSystemPrompt($catalog);
            $apiMessages = [['role' => 'system', 'content' => $systemPrompt]];

            foreach ($messages as $m) {
                $role = isset($m['role']) && $m['role'] === 'assistant' ? 'assistant' : 'user';
                $apiMessages[] = ['role' => $role, 'content' => $m['content']];
            }

            $openaiBaseUrl = rtrim(env('OPENAI_BASE_URL', 'https://api.openai.com/v1'), '/');
            $openaiApiKey  = env('OPENAI_API_KEY', '');
            $model         = env('OPENAI_CHAT_MODEL', 'gpt-5.4-mini');

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$openaiApiKey}",
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post("{$openaiBaseUrl}/chat/completions", [
                'model'               => $model,
                'max_completion_tokens' => 512,
                'response_format'     => ['type' => 'json_object'],
                'messages'            => $apiMessages,
            ]);

            if (!$response->successful()) {
                \Illuminate\Support\Facades\Log::error('OpenAI chat error', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['error' => 'The assistant is temporarily unavailable. Please try again.'], 500);
            }

            $raw = $response->json('choices.0.message.content') ?? '{}';

            $parsed = [];
            try {
                $parsed = json_decode(trim($raw), true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                $parsed = ['reply' => trim($raw)];
            }

            $reply = trim($parsed['reply'] ?? '') ?: "I'm sorry, something went wrong. Please try again.";
            $suggestedReplies = [];
            if (isset($parsed['suggestedReplies']) && is_array($parsed['suggestedReplies'])) {
                $suggestedReplies = array_slice(
                    array_filter($parsed['suggestedReplies'], 'is_string'),
                    0, 4
                );
            }
            $showLeadForm = isset($parsed['showLeadForm']) && $parsed['showLeadForm'] === true;

            return response()->json([
                'reply'            => $reply,
                'suggestedReplies' => array_values($suggestedReplies),
                'showLeadForm'     => $showLeadForm,
            ]);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Chat completion failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'The assistant is temporarily unavailable. Please try again.'], 500);
        }
    }

    private function buildCatalogContext(): string
    {
        $categories = Category::orderBy('id')->get();
        $courses    = Course::orderBy('id')->get();

        $categoryLines = $categories->map(function ($c) {
            return "- {$c->name} ({$c->course_count} courses): {$c->tagline}";
        })->implode("\n");

        $courseLines = $courses->map(function ($c) {
            $skills = is_array($c->skills) ? implode(', ', $c->skills) : '';
            return "- {$c->title} [{$c->category_name}, {$c->level}] — {$c->duration_hours}h, {$c->mode}. Skills: {$skills}. {$c->summary}";
        })->implode("\n");

        return "CATEGORIES:\n{$categoryLines}\n\nCOURSES:\n{$courseLines}";
    }

    private function buildSystemPrompt(string $catalog): string
    {
        return <<<PROMPT
You are Aria, the AI course advisor for Corporate Academy — a premium professional training institute specialising in technology, business, and leadership certifications.

Your dual purpose is:
1. HELP visitors find the right course or programme by understanding their goals, role, and experience.
2. CONVERT visitors into leads by naturally collecting their name, email, and phone number so an advisor can follow up.

## Persona
- Warm, knowledgeable, concise. You sound like a friendly senior colleague, not a sales bot.
- Use short paragraphs. Never write walls of text.
- Address the visitor by name once you know it.

## Conversation flow
Follow this progression naturally (don't rigidly announce each step):

STAGE 1 — Understand the visitor:
- Ask what they are looking to achieve or what role they work in.
- Ask their current experience level if relevant.
- Ask what timeline they have in mind.

STAGE 2 — Recommend:
- Recommend 1–2 specific courses from the catalog that best match their answers.
- Mention the key outcome, duration, and mode of delivery.
- Offer to answer questions about the shortlisted course.

STAGE 3 — Capture lead (do this ONLY after at least 2 exchanges):
- Transition naturally: "To send you the full course brochure and connect you with an advisor for a personalised plan…"
- Ask for their full name, email, and phone in ONE message.
- When the visitor provides any contact detail (even partial), acknowledge it warmly.
- Once you have name + email (phone optional), confirm you will have an advisor reach out within 24 hours.
- Set showLeadForm to true in your JSON response to show an inline contact form.

## Rules
- Only recommend courses from the live catalog below.
- Keep replies to 2–5 sentences unless the visitor asks for details.
- Never mention prices, fees, or costs — if asked, say fees are shared by an advisor.
- Never make up durations or facts not in the catalog.
- Always reply in the same language as the visitor's most recent message.
- Never use emojis.

## Response format (CRITICAL — always output valid JSON, nothing else):
{
  "reply": "<your conversational reply here>",
  "suggestedReplies": ["<chip 1>", "<chip 2>", "<chip 3>"],
  "showLeadForm": false
}

- suggestedReplies: 2–4 short (3–6 word) contextual chips the visitor can tap. Make them relevant to the current stage. Examples: "Tell me more", "What is the price?", "I want to enrol", "Send me the brochure", "Show me other courses".
- showLeadForm: set to true only when you are asking for or have just received contact details.
- The entire response must be valid JSON. Do not add any text outside the JSON.

## Live course catalog
{$catalog}
PROMPT;
    }
}
