<?php

namespace App\Http\Controllers\Admin;

use App\Models\DemoSize;
use App\Models\DemoColor;
use App\Models\DemoProduct;
use App\Models\DemoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessType;

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
        // Validate the incoming request data
        $request->validate([
            'business_type' => 'required|exists:business_types,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'current_price' => 'required|numeric',
            'old_price' => 'nullable|numeric|gt:current_price',
            'buy_price' => 'nullable|numeric',
            'product_code' => 'required|string|unique:demo_products,product_code',
            'quantity' => 'required|integer|min:0',
            'warranty' => 'nullable|string|max:255',
            'sold_count' => 'nullable|integer|min:0',
            'color' => 'nullable|array',
            'color_price' => 'nullable|array', // পরিবর্তিত: দামের জন্য আলাদা ইনপুট নাম
            'size' => 'nullable|array',
            'size_price' => 'nullable|array', // পরিবর্তিত: দামের জন্য আলাদা ইনপুট নাম
            'detail_type' => 'nullable|array',
            'detail_description' => 'nullable|array',
            'variant_name' => 'nullable|string|max:255',
            'variant_option' => 'nullable|array',
            'variant_cost' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
            'product_video' => 'nullable|url|max:255',
            'description' => 'nullable|string', // longText removed
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        // Process product colors and prices
        $productColors = [];
        if ($request->has('color') && is_array($request->color) && $request->has('color_price') && is_array($request->color_price)) {
            foreach ($request->color as $key => $colorId) {
                if (isset($request->color_price[$key])) {
                    $productColors[] = ['color_id' => $colorId, 'price' => $request->color_price[$key]];
                }
            }
        }

        // Process product sizes and prices
        $productSizes = [];
        if ($request->has('size') && is_array($request->size) && $request->has('size_price') && is_array($request->size_price)) {
            foreach ($request->size as $key => $sizeId) {
                if (isset($request->size_price[$key])) {
                    $productSizes[] = ['size_id' => $sizeId, 'price' => $request->size_price[$key]];
                }
            }
        }

        // Process product details
        $productDetails = [];
        if ($request->has('detail_type') && is_array($request->detail_type) && $request->has('detail_description') && is_array($request->detail_description)) {
            foreach ($request->detail_type as $key => $type) {
                if (isset($request->detail_description[$key])) {
                    $productDetails[] = ['type' => $type, 'description' => $request->detail_description[$key]];
                }
            }
        }

        // Process product variants
        $productVariant = [];
        if ($request->has('variant_option') && is_array($request->variant_option) && $request->has('variant_cost') && is_array($request->variant_cost)) {
            foreach ($request->variant_option as $key => $option) {
                if (isset($request->variant_cost[$key])) {
                    $productVariant[] = ['option' => $option, 'cost' => $request->variant_cost[$key]];
                }
            }
        }

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public'); // Store in storage/app/public/products
                $imagePaths[] = $path;
            }
        }

        // Create the DemoProduct
        $product = new DemoProduct();
        $product->business_types = $request->business_type;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->current_price = $request->current_price;
        $product->old_price = $request->old_price;
        $product->buy_price = $request->buy_price;
        $product->product_code = $request->product_code;
        $product->quantity = $request->quantity;
        $product->warranty = $request->warranty;
        $product->sold_count = $request->sold_count ?? 0;
        $product->has_details = !empty($productDetails);
        $product->product_details = !empty($productDetails) ? json_encode($productDetails) : null;
        $product->product_colors = !empty($productColors) ? json_encode($productColors) : null;
        $product->product_sizes = !empty($productSizes) ? json_encode($productSizes) : null;
        $product->has_variant = $request->has('variant_name') && !empty($request->variant_name);
        $product->variant_name = $request->variant_name;
        $product->product_variant = !empty($productVariant) ? json_encode($productVariant) : null;
        $product->images = !empty($imagePaths) ? json_encode($imagePaths) : null;
        $product->video = $request->product_video;
        $product->description = $request->description;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->status = $request->status ?? true;
        $product->save();

        // Redirect the user after successful creation
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }
}
