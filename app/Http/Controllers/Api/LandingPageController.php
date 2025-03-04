<?php


namespace App\Http\Controllers\Api;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LandingPageController extends Controller
{
    public function store(Request $request)
    {
        // Validation Rules
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'country_id' => 'required|exists:countries,id',

            'template_id' => 'required|exists:templates,id',
            'category_id' => 'nullable|exists:categories,id',
            'slug' => 'nullable|string|unique:landing_pages,slug',

            'delivery_charge' => 'nullable|numeric|min:0',
            'settings' => 'nullable|json',
            'seo_settings' => 'nullable|json',
            'hero_setting' => 'nullable|json',
            'social_media' => 'nullable|json',
            'partner' => 'nullable|json',
            'testimonial' => 'nullable|json',
            'feature' => 'nullable|json',
            'feature_details' => 'nullable|json',
            'feature_details_b' => 'nullable|json',
            'faq' => 'nullable|json',
            'brand_logo' => 'nullable|string',
            'video_settings' => 'nullable|json',
            'domain' => 'nullable|string|unique:landing_pages,domain',
            'published' => 'nullable|boolean',
        ]);

        // Validation Failed
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate Slug if not provided
        $slug = $request->slug ?? Str::slug($request->title) . '-' . uniqid();

        // Create Landing Page
        $landingPage = LandingPage::create([
            'user_id' => $request->user_id,
            'template_id' => $request->template_id,
            'category_id' => $request->category_id,
            'product_id' => $request->product_id,
            'title' => $request->title,
            'slug' => $slug,
            'phone' => $request->phone,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'delivery_charge' => $request->delivery_charge ?? 0.00,
            'settings' => json_decode($request->settings, true),
            'seo_settings' => json_decode($request->seo_settings, true),
            'hero_setting' => json_decode($request->hero_setting, true),
            'social_media' => json_decode($request->social_media, true),
            'partner' => json_decode($request->partner, true),
            'testimonial' => json_decode($request->testimonial, true),
            'feature' => json_decode($request->feature, true),
            'feature_details' => json_decode($request->feature_details, true),
            'feature_details_b' => json_decode($request->feature_details_b, true),
            'faq' => json_decode($request->faq, true),
            'brand_logo' => $request->brand_logo,
            'video_settings' => json_decode($request->video_settings, true),
            'domain' => $request->domain,
            'published' => $request->published ?? false,
        ]);

        return response()->json([
            'message' => 'Landing Page Created Successfully',
            'data' => $landingPage
        ], 201);
    }
}
