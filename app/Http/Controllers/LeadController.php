<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'nullable|string|max:50',
            'courseSlug'  => 'nullable|string|max:255',
            'course_slug' => 'nullable|string|max:255',
            'message'     => 'nullable|string|max:5000',
        ]);

        // Support both camelCase and snake_case from frontend
        $courseSlug = $validated['courseSlug'] ?? $validated['course_slug'] ?? null;

        $lead = $this->persistAndNotify([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'course_slug' => $courseSlug,
            'message'     => $validated['message'] ?? null,
        ]);

        return response()->json([
            'id'         => $lead->id,
            'name'       => $lead->name,
            'email'      => $lead->email,
            'phone'      => $lead->phone,
            'courseSlug' => $lead->course_slug,
            'message'    => $lead->message,
            'createdAt'  => $lead->created_at ? $lead->created_at->toISOString() : now()->toISOString(),
        ], 201);
    }

    /**
     * Create a Lead and fire the email notification. Shared by the JSON API
     * (LeadController@store) and the server-rendered web forms so both paths
     * behave identically. Never throws on email failure — logs and continues.
     *
     * @param  array{name:string,email:string,phone:?string,course_slug:?string,message:?string}  $data
     */
    public function persistAndNotify(array $data): Lead
    {
        $lead = Lead::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'] ?? null,
            'course_slug' => $data['course_slug'] ?? null,
            'message'     => $data['message'] ?? null,
        ]);

        $this->notifyForLead($lead);

        return $lead;
    }

    /**
     * Detect the lead source and fire the email notification for an existing
     * Lead. Shared by the JSON API and the server-rendered web forms. Never
     * throws on email failure — logs and continues.
     */
    public function notifyForLead(Lead $lead): void
    {
        // Determine source
        $message = $lead->message ?? '';
        if (str_contains($message, 'Scholarship Application')) {
            $source = 'scholarship';
        } elseif (str_contains($message, 'Chat lead')) {
            $source = 'chat';
        } elseif ($lead->course_slug) {
            $source = 'lead_popup';
        } else {
            $source = 'enquiry';
        }

        // Fire-and-forget email notification
        try {
            $this->sendLeadNotification($lead, $source);
        } catch (\Throwable $e) {
            // Log but don't fail the request
            Log::warning('Lead email notification failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * POST /api/healthz/email-probe  (admin only via CheckAdminPassword middleware)
     *
     * Sends a real Resend probe so deliverability can be confirmed without
     * submitting a real lead. Returns ok:true on Resend acceptance.
     * Fails closed: returns 503 when RESEND_API_KEY is absent.
     */
    public function emailProbe(): JsonResponse
    {
        $resendApiKey = (string) config('services.resend.key', '');
        if (!$resendApiKey) {
            return response()->json([
                'ok'    => false,
                'error' => 'RESEND_API_KEY is not configured — email is disabled',
            ], 503);
        }

        $probeLead = new Lead([
            'name'        => 'Email Probe (health check)',
            'email'       => 'probe@corporate-academy.internal',
            'phone'       => null,
            'course_slug' => null,
            'message'     => 'This is an automated deliverability probe. If you received this, lead email notifications are working correctly.',
        ]);

        try {
            $this->sendLeadNotification($probeLead, 'enquiry');
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 502);
        }

        $fromAddress  = (string) config('services.notify.from');
        $sandboxInUse = str_contains($fromAddress, 'resend.dev');

        return response()->json([
            'ok'             => true,
            'sandboxWarning' => $sandboxInUse
                ? 'Sandbox sender in use — verify your domain in Resend for reliable production delivery'
                : null,
        ]);
    }

    private function sendLeadNotification(Lead $lead, string $source): void
    {
        $resendApiKey = (string) config('services.resend.key', '');
        if (!$resendApiKey) {
            return;
        }

        $sourceLabelMap = [
            'enquiry'     => 'Enquiry Form',
            'lead_popup'  => 'Course Lead Popup',
            'chat'        => 'Chatbot Lead (Aria)',
            'scholarship' => 'Scholarship Application',
        ];
        $sourceLabel = $sourceLabelMap[$source] ?? 'Form Submission';
        $subject = "[Corporate Academy] New {$sourceLabel} — {$lead->name}";

        $notifyTo    = (string) config('services.notify.email');
        $fromAddress = (string) config('services.notify.from');
        $replyTo     = (string) config('services.notify.reply_to');

        // Warn when the sandbox sender is still in use
        if (str_contains($fromAddress, 'onboarding@resend.dev')) {
            Log::warning(
                '[mailer] Sandbox sender in use. Emails may not reach recipients other than the Resend account owner. ' .
                'Verify your domain in Resend and set NOTIFY_FROM to a <name>@yourdomain address.'
            );
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$resendApiKey}",
            'Content-Type'  => 'application/json',
        ])->post('https://api.resend.com/emails', [
            'from'     => $fromAddress,
            'to'       => [$notifyTo],
            'reply_to' => $replyTo,
            'subject'  => $subject,
            'html'     => $this->buildEmailHtml($lead, $sourceLabel),
            'text'     => $this->buildEmailText($lead, $sourceLabel),
        ]);

        if (!$response->successful()) {
            throw new \RuntimeException('Resend API error ' . $response->status() . ': ' . $response->body());
        }
    }

    private function buildEmailHtml(Lead $lead, string $sourceLabel): string
    {
        $now = now()->setTimezone('Asia/Kolkata')->format('d M Y, H:i') . ' IST';

        $phoneRow   = $lead->phone      ? "<div class=\"row\"><span class=\"label\">Phone</span><span class=\"value\">{$lead->phone}</span></div>"           : '';
        $courseRow  = $lead->course_slug ? "<div class=\"row\"><span class=\"label\">Course</span><span class=\"value\">{$lead->course_slug}</span></div>"    : '';
        $messageRow = $lead->message    ? "<div class=\"row\"><span class=\"label\">Message</span><span class=\"value\">{$lead->message}</span></div>"        : '';

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body{font-family:Arial,sans-serif;background:#f4f6f9;margin:0;padding:20px}
    .card{background:#fff;border-radius:10px;max-width:560px;margin:0 auto;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08)}
    .header{background:linear-gradient(135deg,#060e24,#1e3a8a);padding:24px 28px;color:#fff}
    .header h1{margin:0;font-size:18px;font-weight:700}
    .header p{margin:4px 0 0;font-size:13px;opacity:.85}
    .body{padding:24px 28px}
    .row{display:flex;padding:10px 0;border-bottom:1px solid #f0f0f0}
    .row:last-child{border-bottom:none}
    .label{font-size:12px;font-weight:700;text-transform:uppercase;color:#888;width:130px;flex-shrink:0;padding-top:1px}
    .value{font-size:14px;color:#222;flex:1;word-break:break-word}
    .badge{display:inline-block;background:#eff6ff;color:#1d4ed8;border-radius:6px;padding:2px 10px;font-size:12px;font-weight:600;margin-bottom:16px}
    .footer{background:#f9fafb;padding:14px 28px;font-size:12px;color:#aaa;text-align:center}
  </style>
</head>
<body>
  <div class="card">
    <div class="header">
      <h1>New Form Submission</h1>
      <p>Corporate Academy — {$sourceLabel}</p>
    </div>
    <div class="body">
      <span class="badge">{$sourceLabel}</span>
      <div class="row"><span class="label">Name</span><span class="value">{$lead->name}</span></div>
      <div class="row"><span class="label">Email</span><span class="value">{$lead->email}</span></div>
      {$phoneRow}{$courseRow}{$messageRow}
    </div>
    <div class="footer">Sent automatically by Corporate Academy &bull; {$now}</div>
  </div>
</body>
</html>
HTML;
    }

    private function buildEmailText(Lead $lead, string $sourceLabel): string
    {
        $now   = now()->setTimezone('Asia/Kolkata')->format('d M Y, H:i') . ' IST';
        $lines = [
            "New Form Submission — Corporate Academy",
            "Source: {$sourceLabel}",
            "",
            "Name:    {$lead->name}",
            "Email:   {$lead->email}",
        ];

        if ($lead->phone)       $lines[] = "Phone:   {$lead->phone}";
        if ($lead->course_slug) $lines[] = "Course:  {$lead->course_slug}";
        if ($lead->message)     $lines[] = "Message: {$lead->message}";

        $lines[] = "";
        $lines[] = "Sent automatically by Corporate Academy — {$now}";

        return implode("\n", $lines);
    }
}
