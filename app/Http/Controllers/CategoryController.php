<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        // Canonical ordering contract: categories by insertion id, matching
        // the original Express API (artifacts/api-server categories route).
        $categories = Category::orderBy('id')->get();
        return response()->json($categories);
    }

    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json($category);
    }
}
