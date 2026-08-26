<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Course::query();

        if ($request->filled('category')) {
            $query->where('category_slug', $request->input('category'));
        }

        if ($request->has('featured')) {
            $featured = filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($featured !== null) {
                $query->where('featured', $featured);
            }
        }

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('summary', 'like', $term)
                  ->orWhere('category_name', 'like', $term)
                  ->orWhere('skills', 'like', $term); // JSON column stored as text; LIKE works on both SQLite and MySQL
            });
        }

        $courses = $query->orderBy('id')->get();
        return response()->json($courses);
    }

    public function show(string $slug): JsonResponse
    {
        $course = Course::where('slug', $slug)->first();

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 410);
        }

        return response()->json($course);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'slug'           => 'required|string|unique:courses,slug',
            'title'          => 'required|string',
            'category_slug'  => 'required|string',
            'category_name'  => 'required|string',
            'level'          => 'required|string',
            'summary'        => 'required|string',
            'description'    => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'mode'           => 'required|string',
            'price'          => 'required|integer|min:0',
            'rating'         => 'sometimes|numeric|min:0|max:5',
            'total_rating'   => 'sometimes|integer|min:0',
            'enrolled'       => 'sometimes|integer|min:0',
            'featured'       => 'sometimes|boolean',
            'skills'         => 'sometimes|array',
            'image_url'      => 'sometimes|string',
            'curriculum'     => 'sometimes|array',
            'faq'            => 'sometimes|array',
        ]);

        $course = Course::create($validated);
        return response()->json($course, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['error' => 'Course not found.'], 404);
        }

        $validated = $request->validate([
            'slug'           => 'sometimes|string|unique:courses,slug,' . $id,
            'title'          => 'sometimes|string',
            'category_slug'  => 'sometimes|string',
            'category_name'  => 'sometimes|string',
            'level'          => 'sometimes|string',
            'summary'        => 'sometimes|string',
            'description'    => 'sometimes|string',
            'duration_hours' => 'sometimes|integer|min:1',
            'mode'           => 'sometimes|string',
            'price'          => 'sometimes|integer|min:0',
            'rating'         => 'sometimes|numeric|min:0|max:5',
            'total_rating'   => 'sometimes|integer|min:0',
            'enrolled'       => 'sometimes|integer|min:0',
            'featured'       => 'sometimes|boolean',
            'skills'         => 'sometimes|array',
            'image_url'      => 'sometimes|string',
            'curriculum'     => 'sometimes|array',
            'faq'            => 'sometimes|array',
        ]);

        $course->update($validated);
        return response()->json($course);
    }

    public function destroy(int $id): JsonResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['error' => 'Course not found.'], 404);
        }

        $course->delete();
        return response()->json(null, 204);
    }
}
