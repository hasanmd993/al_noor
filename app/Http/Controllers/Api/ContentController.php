<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    public function sliders(): JsonResponse
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }

    public function blogs(): JsonResponse
    {
        $blogs = BlogPost::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $blogs
        ]);
    }

    public function blogDetail(string|int $id): JsonResponse
    {
        $blog = BlogPost::where('id', $id)
            ->where('is_published', true)
            ->firstOrFail();

        $blog->increment('views');

        $recent = BlogPost::where('id', '!=', $blog->id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $blog,
            'recent' => $recent
        ]);
    }

    public function testimonials(): JsonResponse
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    public function team(): JsonResponse
    {
        $team = TeamMember::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $team
        ]);
    }

    public function settings(): JsonResponse
    {
        $settings = SiteSetting::all()->pluck('value', 'key');

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }
}
