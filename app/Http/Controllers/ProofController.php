<?php

namespace App\Http\Controllers;

use App\Models\Proof;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProofController extends Controller
{
    public function index(): JsonResponse
    {
        $proofs = Proof::orderBy('created_at', 'desc')->get();
        return response()->json($proofs);
    }

    public function store(Request $request): JsonResponse
    {
        $imageData = $request->input('imageData') ?? $request->input('image_data');
        $caption   = $request->input('caption', '');
        $proofDate = $request->input('proofDate') ?? $request->input('proof_date');

        if (!is_string($imageData) || !str_starts_with($imageData, 'data:image/')) {
            return response()->json(['error' => 'imageData must be a base64 data URL.'], 400);
        }
        if (!is_string($proofDate) || !trim($proofDate)) {
            return response()->json(['error' => 'proofDate is required.'], 400);
        }
        if (strlen($imageData) > 5_000_000) {
            return response()->json(['error' => 'Image too large (max ~3.5 MB).'], 400);
        }

        $proof = Proof::create([
            'image_data' => $imageData,
            'caption'    => is_string($caption) ? $caption : '',
            'proof_date' => trim($proofDate),
        ]);

        return response()->json($proof, 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $proof = Proof::find($id);
        if (!$proof) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        $proof->delete();
        return response()->json(null, 204);
    }
}
