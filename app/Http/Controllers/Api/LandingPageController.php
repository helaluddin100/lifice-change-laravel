<?php


namespace App\Http\Controllers\Api;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'facebook_pixel' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'delivery_charge' => 'nullable|numeric|min:0',
            'domain' => 'nullable|string|unique:landing_pages,domain',
            'country_id' => 'nullable|exists:countries,id',
            'category_id' => 'nullable|exists:categories,id',
            'template_id' => 'nullable|exists:templates,id',
            'product_id' => 'nullable|exists:products,id',
            'seo_settings' => 'nullable|json',
            'brand_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload for brand_logo
        $brandLogoPath = null;
        if ($request->hasFile('brand_logo')) {
            $brandLogoPath = $request->file('brand_logo')->store('brand_logos', 'public');
        }

        // Store landing page
        $landingPage = LandingPage::create([
            'user_id' => $request->user_id,
            'template_id' => $request->template_id,
            'category_id' => $request->category_id,
            'product_id' => $request->product_id,
            'country_id' => $request->country_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'phone' => $request->phone,
            'email' => $request->email,
            'facebook_pixel' => $request->facebook_pixel,
            'color' => $request->color ?? "#851dd7",
            'delivery_charge' => $request->delivery_charge ?? 0.00,
            'seo_settings' => $request->seo_settings ?? json_encode([]),
            'brand_logo' => $brandLogoPath,
            'domain' => $request->domain,
            'is_published' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Landing Page Created Successfully!',
            'landing_page' => $landingPage
        ], 201);
    }
}
