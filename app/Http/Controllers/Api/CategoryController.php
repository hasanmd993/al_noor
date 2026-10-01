<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::withCount(['properties' => function ($q) {
            $q->where('is_published', true);
        }])
        ->orderBy('name', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
