<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function index(): JsonResponse
    {
        $locations = Location::withCount(['properties' => function ($q) {
            $q->where('is_published', true);
        }])
        ->orderBy('name', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $locations
        ]);
    }
}
