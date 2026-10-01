<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'property_interest' => 'nullable|string|max:255',
            'source' => 'nullable|string|in:contact_form,property_inquiry,landowner,brochure_download',
            'message' => 'required|string|max:5000',
        ]);

        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'General Inquiry',
            'property_interest' => $validated['property_interest'] ?? null,
            'source' => $validated['source'] ?? 'contact_form',
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting Al-Noor Properties BD. Our executive relationship manager will connect with you promptly.',
            'data' => $inquiry
        ], 201);
    }
}
