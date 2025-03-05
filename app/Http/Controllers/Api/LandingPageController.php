<?php


namespace App\Http\Controllers\Api;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function store(Request $request)
    {
        // Validation Rules
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'country_id' => 'required|exists:countries,id',
            'template_id' => 'sometimes|nullable|exists:templates,id',
            'category_id' => 'sometimes|nullable|exists:categories,id',
            'product_id' => 'sometimes|nullable|exists:products,id',
            'delivery_charge' => 'nullable|numeric|min:0',
            'seo_settings' => 'nullable|json',
            'brand_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'domain' => 'nullable|string|unique:landing_pages,domain',
            'facebook_pixel' => 'nullable|string',
            'color' => 'required|string',
            'is_published' => 'sometimes|boolean'
        ]);

        // Validation Failed
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate Unique Slug
        $slug = $request->slug ?? Str::slug($request->title) . '-' . uniqid();
        while (LandingPage::where('slug', $slug)->exists()) {
            $slug = Str::slug($request->title) . '-' . uniqid();
        }

        // Handle Image Upload
        $brandLogoPath = null;
        if ($request->hasFile('brand_logo')) {
            $brandLogoPath = $request->file('brand_logo')->store('brand_logos', 'public');
        }

        // Create Landing Page
        $landingPage = LandingPage::create([
            'user_id' => $request->user_id,
            'template_id' => $request->template_id,
            'category_id' => $request->category_id,
            'product_id' => $request->product_id,
            'title' => $request->title,
            'facebook_pixel' => $request->facebook_pixel,
            'color' => $request->color,
            'slug' => $slug,
            'phone' => $request->phone,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'delivery_charge' => $request->delivery_charge,
            'seo_settings' => $request->seo_settings,
            'brand_logo' => $brandLogoPath,
            'domain' => $request->domain,
            'is_published' => $request->is_published ?? false,
        ]);

        return response()->json([
            'message' => 'Landing Page Created Successfully',
            'data' => $landingPage
        ], 201);
    }


    public function show($id)
    {
        $landingPage = LandingPage::findOrFail($id);
        return response()->json($landingPage);
    }
}
