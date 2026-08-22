<?php

namespace App\Http\Controllers;

use App\Models\VideoStory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoStoryController extends Controller
{
    public function index(): JsonResponse
    {
        $stories = VideoStory::orderBy('sort_order')->orderBy('created_at')->get();
        return response()->json($stories);
    }

    public function store(Request $request): JsonResponse
    {
        $videoData = $request->input('videoData') ?? $request->input('video_data');
        $label     = $request->input('label');
        $sortOrder = $request->input('sortOrder') ?? $request->input('sort_order', 0);

        if (!is_string($videoData) || !$videoData) {
            return response()->json(['error' => 'Invalid input'], 400);
        }
        if (!is_string($label) || !$label) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $story = VideoStory::create([
            'video_data' => $videoData,
            'label'      => $label,
            'sort_order' => is_numeric($sortOrder) ? (int) $sortOrder : 0,
        ]);

        return response()->json($story, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $story = VideoStory::find($id);
        if (!$story) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $updates = [];

        $label = $request->input('label');
        if (is_string($label) && $label) {
            $updates['label'] = $label;
        }

        $sortOrder = $request->input('sortOrder') ?? $request->input('sort_order');
        if (is_numeric($sortOrder)) {
            $updates['sort_order'] = (int) $sortOrder;
        }

        if (empty($updates)) {
            return response()->json(['error' => 'Nothing to update'], 400);
        }

        $story->update($updates);
        return response()->json($story);
    }

    public function destroy(int $id): JsonResponse
    {
        $story = VideoStory::find($id);
        if (!$story) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $story->delete();
        return response()->json(null, 204);
    }
}
