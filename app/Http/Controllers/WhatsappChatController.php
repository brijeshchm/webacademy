<?php

namespace App\Http\Controllers;

use App\Models\WhatsappChat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WhatsappChatController extends Controller
{
    public function index(): JsonResponse
    {
        $chats = WhatsappChat::orderBy('created_at', 'desc')->get();
        return response()->json($chats);
    }

    public function store(Request $request): JsonResponse
    {
        $imageData = $request->input('imageData') ?? $request->input('image_data');
        $caption   = $request->input('caption', '');

        if (!is_string($imageData) || !str_starts_with($imageData, 'data:image/')) {
            return response()->json(['error' => 'imageData must be a base64 data URL.'], 400);
        }
        if (strlen($imageData) > 5_000_000) {
            return response()->json(['error' => 'Image too large (max ~3.5 MB).'], 400);
        }

        $chat = WhatsappChat::create([
            'image_data' => $imageData,
            'caption'    => is_string($caption) ? $caption : '',
        ]);

        return response()->json($chat, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $chat = WhatsappChat::find($id);
        if (!$chat) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        $caption = $request->input('caption');
        $chat->caption = is_string($caption) ? $caption : '';
        $chat->save();

        return response()->json($chat);
    }

    public function destroy(int $id): JsonResponse
    {
        $chat = WhatsappChat::find($id);
        if (!$chat) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        $chat->delete();
        return response()->json(null, 204);
    }
}
