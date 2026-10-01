<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Property::with(['category', 'location', 'images', 'units'])
            ->where('is_published', true);

        if ($request->filled('featured')) {
            $query->where('is_featured', filter_var($request->featured, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('min_price')) {
            $query->where('price_from', '>=', (float)$request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_from', '<=', (float)$request->max_price);
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('address', 'like', $searchTerm)
                  ->orWhere('short_description', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price_from', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_from', 'desc');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
                break;
        }

        $properties = $query->get();

        return response()->json([
            'success' => true,
            'count' => $properties->count(),
            'data' => $properties
        ]);
    }

    public function show(string|int $id): JsonResponse
    {
        $property = Property::with([
            'category',
            'location',
            'images' => fn($q) => $q->orderBy('sort_order', 'asc'),
            'units' => fn($q) => $q->orderBy('sort_order', 'asc'),
            'constructionUpdates' => fn($q) => $q->orderBy('update_date', 'desc')
        ])
        ->where('id', $id)
        ->firstOrFail();

        // Related properties
        $related = Property::with(['location', 'category'])
            ->where('id', '!=', $property->id)
            ->where('is_published', true)
            ->where(function($q) use ($property) {
                $q->where('location_id', $property->location_id)
                  ->orWhere('category_id', $property->category_id);
            })
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $property,
            'related' => $related
        ]);
    }

    public function featured(): JsonResponse
    {
        $properties = Property::with(['category', 'location', 'images', 'units'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('sort_order', 'asc')
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $properties
        ]);
    }
}
