<?php

namespace App\Http\Controllers\Api;

use App\Models\Size;

use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{


    public function search(Request $request)
    {
        $shop = $request->query('shop_id');
        $query = $request->query('query');

        // Validate the query
        if (!$query) {
            return response()->json(['message' => 'Search query is required'], 400);
        }

        // Ensure that shop_id exists
        if (!$shop) {
            return response()->json(['message' => 'Shop ID is required'], 400);
        }

        $products = Product::where('shop_id', $shop)
            ->where('name', 'like', '%' . $query . '%')
            ->with(['images', 'category'])
            ->get();

        // Return the products
        return response()->json($products);
    }




    public function getProductsByCategory($category)
    {
        $products = Product::where('category_id', $category)
            ->where('status', 1)
            ->with(['images', 'category']) // make sure 'category' is loaded
            ->get();

        return response()->json($products);
    }





    public function relatedProducts($category_id, $exclude_product_id)
    {
        $relatedProducts = Product::where('category_id', $category_id)
            ->where('id', '!=', $exclude_product_id)
            ->where('status', 1)
            ->with('images', 'category')
            ->take(6)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $relatedProducts
        ]);
    }



    public function productDetails($slug)
    {
        $product = Product::with(['images', 'category'])->where('slug', $slug)->first();

        if ($product) {
            // Decode the product_colors JSON data
            $productColors = $product->product_colors ?? [];
            $colors = [];

            // Loop through each color in the product_colors
            if (!empty($productColors)) {
                foreach ($productColors as $colorData) {
                    // Find the color by ID
                    $colorRecord = Color::find($colorData['color']); // Assuming 'color' is the ID

                    // If the color exists, add it to the $colors array
                    if ($colorRecord) {
                        $colors[] = [
                            'color_name' => $colorRecord->color,  // Color name from the Color table
                            'price' => $colorData['price'],       // Price from the JSON data
                        ];
                    }
                }
            }

            // Decode the product_sizes JSON data
            $productSizes = $product->product_sizes ?? [];
            $sizes = [];

            // Loop through each size in the product_sizes
            if (!empty($productSizes)) {
                foreach ($productSizes as $sizeData) {
                    // Fetch size name from the sizes table using the size ID
                    $sizeRecord = Size::find($sizeData['size']); // Assuming 'size' is the ID

                    if ($sizeRecord) {
                        $sizes[] = [
                            'size_id' => $sizeData['size'],   // Store size ID for reference
                            'size_name' => $sizeRecord->size, // Fetch actual size name
                            'price' => $sizeData['price'],    // Price from the JSON data
                        ];
                    }
                }
            }



            // Add colors and sizes to the $product object
            $product->colors = $colors;
            $product->sizes = $sizes;

            $reviewsCount = $product->reviews()
                ->whereNull('parent_id')
                ->where('status', 1)
                ->count();


            // Get Paginated Reviews with Replies
            $reviews = $product->reviews()
                ->whereNull('parent_id') // Main reviews only
                ->where('status', 1)
                ->with('replies') // Load Replies for Each Review
                ->orderBy('created_at', 'desc')
                ->paginate(5); // ✅ Pagination Enabled (5 reviews per page)


            // Calculate average rating from all reviews
            $averageRating = $product->reviews()
                ->whereNull('parent_id') // Main reviews
                ->where('status', 1) // Approved reviews
                ->avg('rating'); // Get the average rating




            // Return the response with the product data
            return response()->json([
                'status' => 200,
                'data' => $product,
                'reviews_count' => $reviewsCount,
                'average_rating' => $averageRating,
                'reviews' => $reviews,
            ]);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }


    public function getProductsForUserAndShop(Request $request)
    {
        // Validate the inputs to ensure both user_id and shop_id exist
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',  // Validate user_id
            'shop_id' => 'required|integer|exists:shops,id',  // Validate shop_id
        ]);

        // Fetch products for the specified user_id and shop_id
        $products = Product::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->with('images') // Eager load images
            ->get();

        // Return the products as a JSON response
        return response()->json($products, 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $shop_id = $request->get('shop_id');
    //     if (!$shop_id) {
    //         return response()->json(['error' => 'Shop ID is required'], 400);
    //     }

    //     // Start querying the Product model with eager loading for images
    //     $query = Product::where('shop_id', $shop_id)
    //         ->where('status', 1)
    //         ->with(['images', 'category']);

    //     // Apply category filter if provided
    //     if ($request->has('categories') && !empty($request->categories)) {
    //         $query->whereIn('category_id', $request->categories);
    //     }

    //     // Apply size filter if provided
    //     if ($request->has('sizes') && !empty($request->sizes)) {
    //         $query->where(function ($query) use ($request) {
    //             foreach ($request->sizes as $size) {
    //                 $query->orWhereJsonContains('product_sizes', ['size' => $size]);
    //             }
    //         });
    //     }

    //     // Apply color filter if provided
    //     if ($request->has('color') && !empty($request->color)) {
    //         $query->where(function ($query) use ($request) {
    //             foreach ($request->color as $color) {
    //                 $query->orWhereJsonContains('product_colors', ['color' => $color]);
    //             }
    //         });
    //     }

    //     // Apply price range filter if provided
    //     if ($request->has('min_price') && $request->has('max_price')) {
    //         $minPrice = (float) $request->get('min_price');
    //         $maxPrice = (float) $request->get('max_price');
    //         $query->where(function ($query) use ($minPrice, $maxPrice) {
    //             $query->whereRaw('CAST(current_price AS DECIMAL(10, 2)) >= ?', [$minPrice])
    //                 ->whereRaw('CAST(current_price AS DECIMAL(10, 2)) <= ?', [$maxPrice]);
    //         });
    //     }

    //     // Apply sorting if provided
    //     if ($request->has('sort_by')) {
    //         $sortBy = $request->get('sort_by');
    //         if ($sortBy === 'price-low-to-high') {
    //             $query->orderByRaw('CAST(current_price AS DECIMAL(10, 2)) ASC');
    //         } elseif ($sortBy === 'price-high-to-low') {
    //             $query->orderByRaw('CAST(current_price AS DECIMAL(10, 2)) DESC');
    //         }
    //     }

    //     // Paginate results, 16 products per page (use the page query parameter for lazy loading)
    //     $page = $request->get('page', 1);

    //     // Get the total count of products
    //     $products = $query->paginate(16, ['*'], 'page', $page);

    //     return response()->json($products);
    // }



    public function index(Request $request)
    {
        $shop_id = $request->get('shop_id');
        if (!$shop_id) {
            return response()->json(['error' => 'Shop ID is required'], 400);
        }

        // Start querying the Product model with eager loading for images
        $query = Product::where('shop_id', $shop_id)
            ->where('status', 1)
            ->with(['images', 'category']);

        // Apply category filter if provided
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // Apply size filter if provided
        if ($request->has('sizes') && !empty($request->sizes)) {
            $query->where(function ($query) use ($request) {
                foreach ($request->sizes as $size) {
                    $query->orWhereJsonContains('product_sizes', ['size' => $size]);
                }
            });
        }

        // Apply color filter if provided
        if ($request->has('color') && !empty($request->color)) {
            $query->where(function ($query) use ($request) {
                foreach ($request->color as $color) {
                    $query->orWhereJsonContains('product_colors', ['color' => $color]);
                }
            });
        }

        // Apply price range filter if provided
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = (float) $request->get('min_price');
            $maxPrice = (float) $request->get('max_price');
            $query->where(function ($query) use ($minPrice, $maxPrice) {
                $query->whereRaw('CAST(current_price AS DECIMAL(10, 2)) >= ?', [$minPrice])
                    ->whereRaw('CAST(current_price AS DECIMAL(10, 2)) <= ?', [$maxPrice]);
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            $sortBy = $request->get('sort_by');
            if ($sortBy === 'price-low-to-high') {
                $query->orderByRaw('CAST(current_price AS DECIMAL(10, 2)) ASC');
            } elseif ($sortBy === 'price-high-to-low') {
                $query->orderByRaw('CAST(current_price AS DECIMAL(10, 2)) DESC');
            }
        }

        // Paginate results, 16 products per page (use the page query parameter for lazy loading)
        $page = $request->get('page', 1);

        // Get the total count of products and maximum price (considering both current_price and old_price)
        $products = $query->paginate(16, ['*'], 'page', $page);

        // Get the highest price for top_price from both current_price and old_price
        $topPrice = Product::where('shop_id', $shop_id)
            ->where('status', 1)
            ->max(DB::raw('GREATEST(CAST(current_price AS DECIMAL(10, 2)), CAST(old_price AS DECIMAL(10, 2)))')); // Get the maximum value of current_price and old_price

        // Format the topPrice to remove .00 if present
        $topPriceFormatted = number_format($topPrice, 0, '.', ''); // This removes .00

        $totalProducts = Product::where('shop_id', $shop_id)
            ->where('status', 1)
            ->count(); // Get the total number of products

        // Add the top_price to the response data
        $products->getCollection()->transform(function ($product) use ($topPriceFormatted) {
            return $product;
        });

        return response()->json([
            'products' => $products,
            'top_price' => $topPriceFormatted, // Send the formatted top price
            'total_products' => $totalProducts,
            'status' => 200,
        ]);
    }







    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
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
            // 'product_colors.*.quantity' => 'nullable|numeric',

            'product_sizes' => 'sometimes|required|array',
            'product_sizes.*.size' => 'nullable|string|max:255',
            'product_sizes.*.price' => 'nullable|numeric',
            // 'product_sizes.*.quantity' => 'nullable|numeric',



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
        $slugCount = Product::where('slug', $slug)->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }




        do {
            $randomNumber = rand(100000, 999999);
            $existingProduct = Product::where('product_code', $randomNumber)->first();
        } while ($existingProduct);
        // Create the product
        $product = Product::create([
            'user_id' => $validated['user_id'],
            'shop_id' => $validated['shop_id'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $slug . $randomNumber,
            'current_price' => $validated['current_price'],
            'old_price' => $validated['old_price'] ?? null,
            'buy_price' => $validated['buy_price'] ?? null,
            'product_code' => $randomNumber,
            'quantity' => $validated['quantity'],
            'warranty' => $validated['warranty'] ?? null,
            'product_details' => !empty($validated['product_details']) ? $validated['product_details'] : null, // ✅ Fix for empty array
            'product_variant' => !empty($validated['product_variant']) ? $validated['product_variant'] : null, // ✅ Fix for empty array
            'product_colors' => !empty($validated['product_colors']) ? $validated['product_colors'] : null, // ✅ Fix for empty array
            'product_sizes' => !empty($validated['product_sizes']) ? $validated['product_sizes'] : null, // ✅ Fix for empty array
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
                    'product_id' => $product->id,
                    'image_path' => 'product_images/' . $imageName
                ]);
            }
        }

        // Return response indicating the product was created successfully
        return response()->json([
            'status' => 200, // Add the status field
            'message' => 'Product created successfully',
            'data' => $product,
        ], 200);
    }




    public function getCategoriesByUser($id)
    {
        $categories = Category::where('user_id', $id)->get();
        return response()->json($categories);
    }





    public function show(Request $request)
    {
        $shop_id = $request->get('shop_id');
        if (!$shop_id) {
            return response()->json(['error' => 'Shop ID is required'], 400);
        }

        $query = Product::where('shop_id', $shop_id)->with('images');

        // যদি category দেওয়া থাকে, তাহলে ফিল্টার করা হবে
        if ($request->has('category') && !empty($request->category)) {
            $category = $request->get('category');
            $query->where('category_id', $category);
        }

        // যদি search term দেওয়া থাকে, তাহলে নাম বা প্রোডাক্ট কোড দিয়ে ফিল্টার করা হবে
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%$searchTerm%")
                    ->orWhere('product_code', 'LIKE', "%$searchTerm%");
            });
        }

        // লাস্ট এডিট অথবা ক্রিয়েট হওয়া প্রোডাক্ট প্রথমে দেখানোর জন্য
        $query->orderByDesc('updated_at')->orderByDesc('created_at');

        // পেজিনেশন, প্রতি পেজে কতটি প্রোডাক্ট দেখানো হবে
        $perPage = $request->get('per_page', 20);
        $products = $query->paginate($perPage);

        return response()->json($products);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'item_name' => 'nullable|string|max:255',
            'current_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'buy_price' => 'nullable|numeric',
            'quantity' => 'required|integer',
            'warranty' => 'nullable|string|max:255',
            'sold_count' => 'nullable|integer',

            'product_colors' => 'nullable|array',
            'product_colors.*.color' => 'required|string|max:255',
            'product_colors.*.price' => 'required|numeric',
            // 'product_colors.*.quantity' => 'required|numeric',

            'product_sizes' => 'nullable|array',
            'product_sizes.*.size' => 'required|string|max:255',
            'product_sizes.*.price' => 'required|numeric',
            // 'product_sizes.*.quantity' => 'required|numeric',


            'product_details' => 'nullable|array',
            'product_details.*.detail_type' => 'nullable|string|max:255',
            'product_details.*.detail_description' => 'nullable|string',
            'product_variant' => 'nullable|array',
            'product_variant.*.option' => 'nullable|string|max:255',
            'product_variant.*.cost' => 'nullable|numeric',
            'images' => 'nullable',
            'removed_images' => 'nullable|array',
            'removed_images.*' => 'nullable|integer',
            'video' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'nullable',
            'has_variant' => 'nullable',
            'has_details' => 'nullable',
            'variant_name' => 'nullable|string|max:255',
            'description' => 'nullable',
        ]);

        // Convert boolean values
        $status = filter_var($validated['status'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $has_variant = filter_var($validated['has_variant'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Find the product
        $product = Product::findOrFail($id);

        // Update product details
        $product->update([
            'user_id' => $validated['user_id'],
            'shop_id' => $validated['shop_id'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'] ?? null,
            'name' => $validated['name'],
            'item_name' => $validated['item_name'] ?? null,
            'current_price' => $validated['current_price'],
            'old_price' => $validated['old_price'] ?? null,
            'buy_price' => $validated['buy_price'] ?? null,
            'quantity' => $validated['quantity'],
            'warranty' => $validated['warranty'] ?? null,
            'product_details' => $validated['product_details'] ?? [],
            'product_variant' => $validated['product_variant'] ?? [],
            'product_colors' => $validated['product_colors'] ?? null,
            'product_sizes' => $validated['product_sizes'] ?? null,
            'video' => $validated['video'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $status,
            'has_variant' => $has_variant,
            'has_details' => filter_var($validated['has_details'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'variant_name' => $validated['variant_name'] ?? null,
            'description' => $validated['description'] ?? null,
            'sold_count' => $validated['sold_count'] ?? null,
        ]);

        // Step 1: Remove images
        if (!empty($validated['removed_images'])) {
            foreach ($validated['removed_images'] as $imageId) {
                // Ensure the image ID exists and belongs to the correct product
                $productImage = ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id) // Ensure image belongs to the current product
                    ->first();

                if ($productImage) {
                    $imagePath = public_path($productImage->image_path);

                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image from storage
                    }
                    $productImage->delete(); // Remove the record from the database
                } else {
                    // Image ID doesn't belong to the product or doesn't exist
                    return response()->json([
                        'status' => 400,
                        'message' => 'Invalid image ID or image does not belong to this product.',
                    ], 400);
                }
            }
        }

        // Step 2: Upload and store new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    // Generate a unique image name
                    $imageName = md5(uniqid()) . '.webp';

                    // Open the uploaded image
                    $img = Image::make($image);

                    // Convert the image to WebP format and reduce file size
                    $img->encode('webp', 80); // 80 is the quality level, adjust as needed

                    // Save the image in the public directory
                    $img->save(public_path('product_images/' . $imageName));

                    // Save new image in the database
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'product_images/' . $imageName
                    ]);
                }
            }
        }

        // Return response
        return response()->json(
            [
                'status' => 200,
                'message' => 'Product updated successfully',
                'data' => $product->load('images'), // Load images in response
            ],
            200
        );
    }






    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $images = ProductImage::where('product_id', $id)->get();

        foreach ($images as $image) {
            $imagePath = public_path($image->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }
        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product and associated images deleted successfully',
        ]);
    }
}
