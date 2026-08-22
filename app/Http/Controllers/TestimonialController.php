<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Testimonial::where('visible', true);

        if ($request->filled('source') && $request->input('source') !== 'all') {
            $query->where('source', $request->input('source'));
        }

        $testimonials = $query->orderBy('id')->get();
        return response()->json($testimonials);
    }

    public function adminIndex(): JsonResponse
    {
        $testimonials = Testimonial::orderBy('id')->get();
        return response()->json($testimonials);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'       => 'required|string',
            'role'       => 'required|string',
            'company'    => 'required|string',
            'quote'      => 'required|string',
            'rating'     => 'sometimes|numeric|min:0|max:5',
            'avatar_url' => 'sometimes|string',
            'source'     => 'sometimes|string',
            'visible'    => 'sometimes|boolean',
        ]);

        $testimonial = Testimonial::create($validated);
        return response()->json($testimonial, 201);
    }

    public function updateVisibility(Request $request, int $id): JsonResponse
    {
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        $visible = $request->input('visible');
        $testimonial->visible = (bool) $visible;
        $testimonial->save();

        return response()->json($testimonial);
    }

    public function destroy(int $id): JsonResponse
    {
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        $testimonial->delete();
        return response()->json(null, 204);
    }
}
