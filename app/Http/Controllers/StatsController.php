<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    public function index(): JsonResponse
    {
        $totalCourses = Course::count();

        return response()->json([
            'careersTransformed' => 65000,
            'expertTrainers'     => 800,
            'workshopsPerMonth'  => 250,
            'countries'          => 100,
            'totalCourses'       => $totalCourses,
            'averageRating'      => 4.8,
        ]);
    }
}
