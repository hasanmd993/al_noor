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
use Illuminate\Support\Facades\Hash;

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
        return response()->json([
            'success' => true,
            'user' => $request->user() ?? User::first()
        ]);
    }

    // --- Dashboard Analytics ---
    public function dashboardStats(): JsonResponse
    {
        $totalProps = Property::count();
        $ongoingProps = Property::where('status', 'ongoing')->count();
        $completedProps = Property::where('status', 'completed')->count();
        $upcomingProps = Property::where('status', 'upcoming')->count();

        $totalInquiries = Inquiry::count();
        $newInquiries = Inquiry::where('is_read', false)->count();
        $jvInquiries = Inquiry::where('source', 'landowner')->count();
        $vipInquiries = Inquiry::where('source', 'property_inquiry')->count();

        $recentInquiries = Inquiry::latest()->take(6)->get();
        $recentProps = Property::with(['category', 'location'])->latest()->take(5)->get();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_properties' => $totalProps,
                'ongoing_properties' => $ongoingProps,
                'completed_properties' => $completedProps,
                'upcoming_properties' => $upcomingProps,
                'total_inquiries' => $totalInquiries,
                'new_inquiries' => $newInquiries,
                'jv_inquiries' => $jvInquiries,
                'vip_inquiries' => $vipInquiries,
                'categories_count' => Category::count(),
                'locations_count' => Location::count(),
                'blogs_count' => BlogPost::count(),
                'testimonials_count' => Testimonial::count(),
            ],
            'recent_inquiries' => $recentInquiries,
            'recent_properties' => $recentProps,
        ]);
    }

    // --- Properties CRUD ---
    public function propertiesIndex(): JsonResponse
    {
        $properties = Property::with(['category', 'location', 'units', 'images'])->latest()->get();
        return response()->json(['success' => true, 'data' => $properties]);
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
            'price_from' => 'nullable|numeric',
            'land_area' => 'nullable|numeric',
            'total_floors' => 'nullable|integer',
            'apartments_per_floor' => 'nullable|integer',
            'total_units' => 'nullable|integer',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'handover_date' => 'nullable|date',
            'featured_image' => 'nullable|string',
            'brochure_pdf' => 'nullable|string',
            'video_url' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
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
            'price_from' => 'nullable|numeric',
            'land_area' => 'nullable|numeric',
            'total_floors' => 'nullable|integer',
            'apartments_per_floor' => 'nullable|integer',
            'total_units' => 'nullable|integer',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'handover_date' => 'nullable|date',
            'featured_image' => 'nullable|string',
            'brochure_pdf' => 'nullable|string',
            'video_url' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $property->update($validated);

        return response()->json(['success' => true, 'message' => 'Property updated successfully.', 'data' => $property]);
    }

    public function propertyDestroy($id): JsonResponse
    {
        $property = Property::findOrFail($id);
        $property->delete();
        return response()->json(['success' => true, 'message' => 'Property deleted successfully.']);
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
        $inquiry->update($request->only(['is_read', 'status']));
        return response()->json(['success' => true, 'message' => 'Inquiry updated.', 'data' => $inquiry]);
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
            'brochure_pdf' => 'nullable|string',
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
            'brochure_pdf' => 'nullable|string',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]));
        return response()->json(['success' => true, 'message' => 'Article updated.', 'data' => $blog]);
    }

    public function blogDestroy($id): JsonResponse
    {
        BlogPost::findOrFail($id)->delete();
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
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,avif,svg,pdf,doc,docx|max:51200',
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
}
