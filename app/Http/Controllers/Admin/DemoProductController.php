<?php

namespace App\Http\Controllers\Admin;

use App\Models\DemoSize;
use App\Models\DemoColor;
use App\Models\DemoProduct;
use Illuminate\Support\Str;
use App\Models\BusinessType;
use App\Models\DemoCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class DemoProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DemoProduct::all();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $businessTypes = BusinessType::all();  // Fetching business types
        return view('admin.product.create', compact('businessTypes'));
    }


    /**
     * Get categories, colors, and sizes based on business type.
     *
     * @param int $business_type_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptions($business_type_id)
    {
        $businessType = BusinessType::find($business_type_id);
        if (!$businessType) {
            return response()->json(['error' => 'Business Type not found'], 404);
        }

        // Get the related categories, colors, and sizes for the selected business type
        $categories = $businessType->categories;
        $colors = $businessType->colors;
        $sizes = $businessType->sizes;

        return response()->json([
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'business_type' => 'required|exists:business_types,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            // 'item_name' => 'nullable|string|max:255',
            'current_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'buy_price' => 'nullable|numeric',
            'quantity' => 'required|integer',
            'warranty' => 'nullable|string|max:255',
            'sold_count' => 'nullable|integer',


            'product_colors' => 'sometimes|required|array',
            'product_colors.*.color' => 'nullable|string|max:255',
            'product_colors.*.price' => 'nullable|numeric',
            'product_colors.*.quantity' => 'nullable|numeric',

            'product_sizes' => 'sometimes|required|array',
            'product_sizes.*.size' => 'nullable|string|max:255',
            'product_sizes.*.price' => 'nullable|numeric',
            'product_sizes.*.quantity' => 'nullable|numeric',



            'product_details' => 'nullable|array',
            'product_details.*.detail_type' => 'nullable|string|max:255',
            'product_details.*.detail_description' => 'nullable|string',
            'product_variant' => 'nullable|array',
            'product_variant.*.option' => 'nullable|string|max:255',
            'product_variant.*.cost' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif,webp|max:6000',
            'video' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'required',
            'has_variant' => 'nullable',
            'has_details' => 'nullable',
            'variant_name' => 'nullable|string|max:255',
            'description' => 'required',
        ]);

        // Ensure 'status' and 'has_variant' are treated as booleans
        $status = filter_var($validated['status'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $has_variant = filter_var($validated['has_variant'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Generate the product slug
        $slug = Str::slug($validated['name']);

        $slugCount = DemoProduct::where('slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }


        do {
            $randomNumber = rand(100000, 999999);
            $existingProduct = DemoProduct::where('product_code', $randomNumber)->first();
        } while ($existingProduct);
        // Create the product
        $product = DemoProduct::create([
            'business_types' => $validated['business_type'],
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'current_price' => $validated['current_price'],
            'old_price' => $validated['old_price'] ?? null,
            'buy_price' => $validated['buy_price'] ?? null,
            'product_code' => $randomNumber,
            'quantity' => $validated['quantity'],
            'warranty' => $validated['warranty'] ?? null,
            'product_details' => !empty($validated['product_details']) ? $validated['product_details'] : null,
            'product_variant' => !empty($validated['product_variant']) ? $validated['product_variant'] : null,
            'product_colors' => !empty($validated['product_colors']) ? $validated['product_colors'] : null,
            'product_sizes' => !empty($validated['product_sizes']) ? $validated['product_sizes'] : null,
            'video' => $validated['video'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $status,
            'has_variant' => $has_variant,
            'has_details' => filter_var($validated['has_details'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'variant_name' => $validated['variant_name'] ?? null,
            'description' => $validated['description'],

            'sold_count' => $validated['sold_count'] ?? null,
        ]);


        // Handle image uploads and store in product_images table
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a unique image name
                $imageName = md5(uniqid()) . '.webp';

                // Open the uploaded image
                $img = Image::make($image);

                // Convert the image to WebP format and reduce file size
                $img->encode('webp', 80);

                // Save the image in the public directory
                $img->save(public_path('product_images/' . $imageName));

                // Store the image in the product_images table
                ProductImage::create([

                    'demo_product_id' => $product->id, // If you are storing data from 'demo_products'
                    'image_path' => 'product_images/' . $imageName
                ]);
            }
        }



        // Return response indicating the product was created successfully
        return redirect()->route('admin.product.index')->with('success', 'Demo Product created successfully!');
    }


    public function eidt($id)
    {
        $product = DemoProduct::find($id);
        if (!$product) {
            return redirect()->route('admin.product.index')->with('error', 'Product not found');
        }

        $businessTypes = BusinessType::all();
        $categories = DemoCategory::where('business_type_id', $product->business_types)->get();
        $colors = DemoColor::where('business_type_id', $product->business_types)->get();
        $sizes = DemoSize::where('business_type_id', $product->business_types)->get();

        return view('admin.product.edit', compact('product', 'businessTypes', 'categories', 'colors', 'sizes'));
    }
}
