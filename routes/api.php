<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- Sneat Vue Admin API ---
Route::prefix('admin')->group(function () {
    Route::post('/media/upload', [AdminController::class, 'uploadMedia']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::get('/me', [AdminController::class, 'me']);
    Route::get('/dashboard-stats', [AdminController::class, 'dashboardStats']);

    // Properties
    Route::get('/properties', [AdminController::class, 'propertiesIndex']);
    Route::post('/properties', [AdminController::class, 'propertyStore']);
    Route::put('/properties/{id}', [AdminController::class, 'propertyUpdate']);
    Route::delete('/properties/{id}', [AdminController::class, 'propertyDestroy']);

    // Inquiries
    Route::get('/inquiries', [AdminController::class, 'inquiriesIndex']);
    Route::put('/inquiries/{id}', [AdminController::class, 'inquiryUpdate']);
    Route::delete('/inquiries/{id}', [AdminController::class, 'inquiryDestroy']);

    // Categories
    Route::get('/categories', [AdminController::class, 'categoriesIndex']);
    Route::post('/categories', [AdminController::class, 'categoryStore']);
    Route::put('/categories/{id}', [AdminController::class, 'categoryUpdate']);
    Route::delete('/categories/{id}', [AdminController::class, 'categoryDestroy']);

    // Locations
    Route::get('/locations', [AdminController::class, 'locationsIndex']);
    Route::post('/locations', [AdminController::class, 'locationStore']);
    Route::put('/locations/{id}', [AdminController::class, 'locationUpdate']);
    Route::delete('/locations/{id}', [AdminController::class, 'locationDestroy']);

    // Blogs
    Route::get('/blogs', [AdminController::class, 'blogsIndex']);
    Route::post('/blogs', [AdminController::class, 'blogStore']);
    Route::put('/blogs/{id}', [AdminController::class, 'blogUpdate']);
    Route::delete('/blogs/{id}', [AdminController::class, 'blogDestroy']);

    // Testimonials
    Route::get('/testimonials', [AdminController::class, 'testimonialsIndex']);
    Route::post('/testimonials', [AdminController::class, 'testimonialStore']);
    Route::put('/testimonials/{id}', [AdminController::class, 'testimonialUpdate']);
    Route::delete('/testimonials/{id}', [AdminController::class, 'testimonialDestroy']);

    // Sliders
    Route::get('/sliders', [AdminController::class, 'slidersIndex']);
    Route::post('/sliders', [AdminController::class, 'sliderStore']);
    Route::put('/sliders/{id}', [AdminController::class, 'sliderUpdate']);
    Route::delete('/sliders/{id}', [AdminController::class, 'sliderDestroy']);
});

// --- Public Client Website APIs ---
Route::prefix('v1')->group(function () {
    Route::get('/properties', [PropertyController::class, 'index']);
    Route::get('/properties/featured', [PropertyController::class, 'featured']);
    Route::get('/properties/{id}', [PropertyController::class, 'show']);

    Route::get('/locations', [LocationController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);

    Route::get('/sliders', [ContentController::class, 'sliders']);
    Route::get('/blogs', [ContentController::class, 'blogs']);
    Route::get('/blogs/{id}', [ContentController::class, 'blogDetail']);
    Route::get('/testimonials', [ContentController::class, 'testimonials']);
    Route::get('/team', [ContentController::class, 'team']);
    Route::get('/settings', [ContentController::class, 'settings']);

    Route::post('/inquiries', [InquiryController::class, 'store']);
});

Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/featured', [PropertyController::class, 'featured']);
Route::get('/properties/{id}', [PropertyController::class, 'show']);
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/sliders', [ContentController::class, 'sliders']);
Route::get('/blogs', [ContentController::class, 'blogs']);
Route::get('/blogs/{id}', [ContentController::class, 'blogDetail']);
Route::get('/testimonials', [ContentController::class, 'testimonials']);
Route::get('/team', [ContentController::class, 'team']);
Route::get('/settings', [ContentController::class, 'settings']);
Route::post('/inquiries', [InquiryController::class, 'store']);
