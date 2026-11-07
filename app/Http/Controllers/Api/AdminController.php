<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\ConstructionUpdate;
use App\Models\Inquiry;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyUnit;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // --- Auth ---
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    // --- Dashboard Analytics ---
    public function dashboardStats(): JsonResponse
    {
        $stats = Cache::remember('admin_dashboard_stats', 30, function () {
            $propCounts = Property::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'ongoing' THEN 1 ELSE 0 END) as ongoing,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming
            ")->first();

            $inqCounts = Inquiry::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as new_inq,
                SUM(CASE WHEN source = 'landowner' THEN 1 ELSE 0 END) as jv,
                SUM(CASE WHEN source = 'property_inquiry' THEN 1 ELSE 0 END) as vip
            ")->first();

            return [
                'total_properties' => (int)($propCounts->total ?? 0),
                'ongoing_properties' => (int)($propCounts->ongoing ?? 0),
                'completed_properties' => (int)($propCounts->completed ?? 0),
                'upcoming_properties' => (int)($propCounts->upcoming ?? 0),
                'total_inquiries' => (int)($inqCounts->total ?? 0),
                'new_inquiries' => (int)($inqCounts->new_inq ?? 0),
                'jv_inquiries' => (int)($inqCounts->jv ?? 0),
                'vip_inquiries' => (int)($inqCounts->vip ?? 0),
                'categories_count' => Category::count(),
                'locations_count' => Location::count(),
                'blogs_count' => BlogPost::count(),
                'testimonials_count' => Testimonial::count(),
            ];
        });

        $recentInquiries = Inquiry::latest()->take(6)->get();
        $recentProps = Property::with(['category:id,name', 'location:id,name'])->latest()->take(5)->get();

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'recent_inquiries' => $recentInquiries,
            'recent_properties' => $recentProps,
        ]);
    }

    // --- Properties CRUD ---
    public function propertiesIndex(Request $request): JsonResponse
    {
        $perPage = min((int)$request->get('per_page', 20), 100);
        $paginator = Property::with(['category:id,name', 'location:id,name'])
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'data' => $paginator->items()
        ]);
    }

    public function propertyShow($id): JsonResponse
    {
        $property = Property::with([
            'category',
            'location',
            'images' => fn($q) => $q->orderBy('sort_order', 'asc'),
            'units' => fn($q) => $q->orderBy('sort_order', 'asc'),
            'constructionUpdates' => fn($q) => $q->orderBy('update_date', 'desc')
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $property
        ]);
    }

    public function propertyStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'address' => 'required|string|max:255',
            'status' => 'required|in:ongoing,completed,upcoming,handed_over',
            'type' => 'required|in:residential,commercial,mixed',
            'price_label' => 'nullable|string|max:255',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|gte:price_from',
            'land_area' => 'nullable|numeric',
            'land_unit' => 'nullable|string|max:50',
            'total_floors' => 'nullable|integer',
            'apartments_per_floor' => 'nullable|integer',
            'total_units' => 'nullable|integer',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'launch_date' => 'nullable|date',
            'expected_completion' => 'nullable|date',
            'handover_date' => 'nullable|date',
            'featured_image' => 'nullable|string',
            'brochure_pdf' => 'nullable|string',
            'video_url' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'nearby_landmarks' => 'nullable|array',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_featured' => 'nullable|boolean',
            'is_special_offer' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $property = Property::create($validated);

        return response()->json(['success' => true, 'message' => 'Property created successfully.', 'data' => $property], 201);
    }

    public function propertyUpdate(Request $request, $id): JsonResponse
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'address' => 'required|string|max:255',
            'status' => 'required|in:ongoing,completed,upcoming,handed_over',
            'type' => 'required|in:residential,commercial,mixed',
            'price_label' => 'nullable|string|max:255',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|gte:price_from',
            'land_area' => 'nullable|numeric',
            'land_unit' => 'nullable|string|max:50',
            'total_floors' => 'nullable|integer',
            'apartments_per_floor' => 'nullable|integer',
            'total_units' => 'nullable|integer',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'launch_date' => 'nullable|date',
            'expected_completion' => 'nullable|date',
            'handover_date' => 'nullable|date',
            'featured_image' => 'nullable|string',
            'brochure_pdf' => 'nullable|string',
            'video_url' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'nearby_landmarks' => 'nullable|array',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_featured' => 'nullable|boolean',
            'is_special_offer' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $property->update($validated);

        return response()->json(['success' => true, 'message' => 'Property updated successfully.', 'data' => $property]);
    }

    public function propertyDestroy($id): JsonResponse
    {
        $property = Property::with('images')->findOrFail($id);

        $filesToDelete = [];
        $checkAndAdd = function (?string $path) use (&$filesToDelete) {
            if (!$path) return;
            $clean = ltrim($path, '/');
            if (Str::startsWith($clean, 'storage/')) {
                $clean = Str::after($clean, 'storage/');
            }
            if ($clean && Storage::disk('public')->exists($clean)) {
                $filesToDelete[] = $clean;
            }
        };

        $checkAndAdd($property->featured_image);
        $checkAndAdd($property->brochure_pdf);
        foreach ($property->images as $img) {
            $checkAndAdd($img->image_path);
        }

        if (!empty($filesToDelete)) {
            Storage::disk('public')->delete($filesToDelete);
        }

        $property->delete();
        return response()->json(['success' => true, 'message' => 'Property deleted successfully.']);
    }

    public function propertyImagesStore(Request $request, $id): JsonResponse
    {
        $property = Property::findOrFail($id);
        $validated = $request->validate([
            'image_path' => 'required|string',
            'caption' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);
        $image = $property->images()->create($validated);
        return response()->json(['success' => true, 'message' => 'Image added to gallery.', 'data' => $image], 201);
    }

    public function propertyImagesDestroy($propertyId, $imageId): JsonResponse
    {
        $image = PropertyImage::where('property_id', $propertyId)->findOrFail($imageId);
        if ($image->image_path && Str::startsWith($image->image_path, '/storage/')) {
            $clean = Str::after($image->image_path, '/storage/');
            if (Storage::disk('public')->exists($clean)) {
                Storage::disk('public')->delete($clean);
            }
        }
        $image->delete();
        return response()->json(['success' => true, 'message' => 'Image deleted from gallery.']);
    }

    public function propertyUnitsStore(Request $request, $id): JsonResponse
    {
        $property = Property::findOrFail($id);
        $validated = $request->validate([
            'unit_type' => 'required|string|max:100',
            'size_sqft' => 'required|numeric|min:1',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'balconies' => 'nullable|integer|min:0',
            'parking_spaces' => 'nullable|integer|min:0',
            'floor_plan_image' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $unit = $property->units()->create($validated);
        return response()->json(['success' => true, 'message' => 'Unit added successfully.', 'data' => $unit], 201);
    }

    public function propertyUnitsDestroy($propertyId, $unitId): JsonResponse
    {
        $unit = PropertyUnit::where('property_id', $propertyId)->findOrFail($unitId);
        $unit->delete();
        return response()->json(['success' => true, 'message' => 'Unit deleted.']);
    }

    // --- Inquiries CRUD ---
    public function inquiriesIndex(): JsonResponse
    {
        $inquiries = Inquiry::latest()->get();
        return response()->json(['success' => true, 'data' => $inquiries]);
    }

    public function inquiryUpdate(Request $request, $id): JsonResponse
    {
        $inquiry = Inquiry::findOrFail($id);

        $validated = $request->validate([
            'is_read' => 'nullable|boolean',
            'status' => 'nullable|string|in:new,contacted,scheduled,closed,rejected',
        ]);

        $inquiry->update($validated);

        return response()->json(['success' => true, 'message' => 'Inquiry updated successfully.', 'data' => $inquiry]);
    }

    public function inquiryDestroy($id): JsonResponse
    {
        Inquiry::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Inquiry deleted.']);
    }

    // --- Categories CRUD ---
    public function categoriesIndex(): JsonResponse
    {
        $categories = Category::withCount('properties')->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function categoryStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $cat = Category::create($validated);
        return response()->json(['success' => true, 'message' => 'Category created.', 'data' => $cat], 201);
    }

    public function categoryUpdate(Request $request, $id): JsonResponse
    {
        $cat = Category::findOrFail($id);
        $cat->update($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]));
        return response()->json(['success' => true, 'message' => 'Category updated.', 'data' => $cat]);
    }

    public function categoryDestroy($id): JsonResponse
    {
        Category::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted.']);
    }

    // --- Locations CRUD ---
    public function locationsIndex(): JsonResponse
    {
        $locations = Location::withCount('properties')->get();
        return response()->json(['success' => true, 'data' => $locations]);
    }

    public function locationStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);
        $loc = Location::create($validated);
        return response()->json(['success' => true, 'message' => 'Location created.', 'data' => $loc], 201);
    }

    public function locationUpdate(Request $request, $id): JsonResponse
    {
        $loc = Location::findOrFail($id);
        $loc->update($request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]));
        return response()->json(['success' => true, 'message' => 'Location updated.', 'data' => $loc]);
    }

    public function locationDestroy($id): JsonResponse
    {
        Location::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Location deleted.']);
    }

    // --- Blogs CRUD ---
    public function blogsIndex(): JsonResponse
    {
        $blogs = BlogPost::latest()->get();
        return response()->json(['success' => true, 'data' => $blogs]);
    }

    public function blogStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'featured_image' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);
        $blog = BlogPost::create($validated);
        return response()->json(['success' => true, 'message' => 'Article published.', 'data' => $blog], 201);
    }

    public function blogUpdate(Request $request, $id): JsonResponse
    {
        $blog = BlogPost::findOrFail($id);
        $blog->update($request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'featured_image' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]));
        return response()->json(['success' => true, 'message' => 'Article updated.', 'data' => $blog]);
    }

    public function blogDestroy($id): JsonResponse
    {
        $blog = BlogPost::findOrFail($id);
        if ($blog->featured_image && Str::startsWith($blog->featured_image, '/storage/')) {
            $clean = Str::after($blog->featured_image, '/storage/');
            if (Storage::disk('public')->exists($clean)) {
                Storage::disk('public')->delete($clean);
            }
        }
        $blog->delete();
        return response()->json(['success' => true, 'message' => 'Article deleted.']);
    }

    // --- Testimonials CRUD ---
    public function testimonialsIndex(): JsonResponse
    {
        $testimonials = Testimonial::orderBy('sort_order', 'asc')->get();
        return response()->json(['success' => true, 'data' => $testimonials]);
    }

    public function testimonialStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_designation' => 'nullable|string|max:255',
            'project_name' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'client_photo' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $item = Testimonial::create($validated);
        return response()->json(['success' => true, 'message' => 'Testimonial added.', 'data' => $item], 201);
    }

    public function testimonialUpdate(Request $request, $id): JsonResponse
    {
        $item = Testimonial::findOrFail($id);
        $item->update($request->validate([
            'client_name' => 'required|string|max:255',
            'client_designation' => 'nullable|string|max:255',
            'project_name' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'client_photo' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]));
        return response()->json(['success' => true, 'message' => 'Testimonial updated.', 'data' => $item]);
    }

    public function testimonialDestroy($id): JsonResponse
    {
        Testimonial::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Testimonial deleted.']);
    }

    // --- Sliders CRUD ---
    public function slidersIndex(): JsonResponse
    {
        $sliders = Slider::orderBy('sort_order', 'asc')->get();
        return response()->json(['success' => true, 'data' => $sliders]);
    }

    public function sliderStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|string',
            'cta_text' => 'nullable|string',
            'cta_link' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $slider = Slider::create($validated);
        return response()->json(['success' => true, 'message' => 'Slider banner added.', 'data' => $slider], 201);
    }

    public function sliderUpdate(Request $request, $id): JsonResponse
    {
        $slider = Slider::findOrFail($id);
        $slider->update($request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|string',
            'cta_text' => 'nullable|string',
            'cta_link' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]));
        return response()->json(['success' => true, 'message' => 'Slider banner updated.', 'data' => $slider]);
    }

    public function sliderDestroy($id): JsonResponse
    {
        Slider::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Slider deleted.']);
    }

            public function uploadMedia(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,avif,pdf,doc,docx|max:51200',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $isPdf = in_array($extension, ['pdf', 'doc', 'docx']);

        if ($isPdf) {
            $filename = 'brochure_' . time() . '_' . Str::random(8) . '.' . $extension;
            $destinationPath = storage_path('app/public/brochures');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            return response()->json([
                'success' => true,
                'message' => 'Brochure PDF document uploaded successfully.',
                'url' => '/storage/brochures/' . $filename,
                'filename' => $filename,
            ]);
        }

        $filename = 'media_' . time() . '_' . Str::random(8) . '.webp';
        $destinationPath = storage_path('app/public/media');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $fullPath = $destinationPath . '/' . $filename;

        try {
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($file->getRealPath());
            
            if ($image->width() > 2400) {
                $image->scaleDown(width: 2400);
            }
            
            $encoded = $image->encode(new \Intervention\Image\Encoders\WebpEncoder(quality: 85));
            $encoded->save($fullPath);
            
            $url = '/storage/media/' . $filename;
            return response()->json([
                'success' => true,
                'message' => 'Image optimized and uploaded as WebP successfully.',
                'url' => $url,
                'filename' => $filename,
            ]);
        } catch (\Throwable $e) {
            $file->storeAs('public/media', $filename);
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully.',
                'url' => '/storage/media/' . $filename,
                'filename' => $filename,
            ]);
        }
    }

    // --- Corporate Settings ---
    public function settingsUpdate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'brochure_url' => 'nullable|string|max:500',
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::setValue($key, $value, 'corporate');
        }

        Cache::forget('site_settings_kv');

        return response()->json([
            'success' => true,
            'message' => 'Corporate settings updated successfully.',
            'data' => SiteSetting::all()->pluck('value', 'key'),
        ]);
    }
}
