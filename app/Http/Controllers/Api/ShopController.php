<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Models\Shop;
use App\Models\Country;
use App\Models\DemoProduct;
use App\Models\VisitorData;
use Illuminate\Support\Str;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function viewshopByDomain($shop_url)
    {
        $shop = Shop::where('shop_domain', $shop_url)->with('template')->first();
        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        return response()->json([
            'shop' => $shop,
            'template' => $shop->template ? $shop->template : null,
        ]);
    }








    public function showShopWithTemplate($shop_url)
    {
        $shop = Shop::where('shop_url', $shop_url)->with('template')->first(); // Eager load the template

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        return response()->json([
            'shop' => $shop,
            'template' => $shop->template ? $shop->template : null,
        ]);
    }







    public function countries()
    {
        $countries = Country::where('status', 1)->get();
        return response()->json($countries);
    }

    public function districts($id)
    {
        $country = Country::with('districts')->findOrFail($id);
        return response()->json($country->districts);
    }

    public function businessTypes()
    {
        $businessTypes = BusinessType::where('status', 1)->get();
        return response()->json($businessTypes);
    }


    public function getUserShops($userId)
    {
        $shops = Shop::where('user_id', $userId)
            ->withCount('visitorData')
            ->get();

        return response()->json(
            $shops
        );
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    // public function store(Request $request)
    // {
    //     try {
    //         // Validate the request data
    //         $validatedData = $request->validate([
    //             'name' => 'required|string',
    //             'shop_type' => 'required|string', // it's means business type
    //             'email' => 'required|email',
    //             'address' => 'required|string',
    //             'country' => 'required|string',
    //             'number' => 'required|numeric',
    //             'details' => 'required|string',
    //             'user_id' => 'required', // Assuming user_id is provided in the request
    //         ]);
    //         $shop_url = Str::slug($validatedData['name']);

    //         $count = Shop::where('shop_url', $shop_url)->count();
    //         if ($count > 0) {
    //             $shop_url = $shop_url . '-' . ($count + 1);
    //         }
    //         $userId = $request->input('user_id');


    //         $shop = new Shop($validatedData);
    //         $shop->user_id = $userId;
    //         $shop->shop_url = $shop_url;
    //         $shop->template_type = 1;
    //         $shop->vat_tax = 0;
    //         $shop->save();

    //         // Log the success message
    //         Log::info('Shop created successfully', ['id' => $shop->id]);

    //         // Return a success response
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Shop created successfully',
    //         ]);
    //     } catch (ValidationException $e) {
    //         // Return validation errors
    //         return response()->json(['status' => 422, 'errors' => $e->errors()]);
    //     } catch (\Throwable $e) {
    //         // Log and return an error response
    //         Log::error('Error creating Shop', ['error' => $e->getMessage()]);
    //         return response()->json(['status' => 500, 'error' => $e->getMessage()]);
    //     }
    // }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'shop_type' => 'required|string', // business type
                'email' => 'required|email',
                'address' => 'required|string',
                'country' => 'required|string',
                'number' => 'required|numeric',
                'details' => 'required|string',
                'user_id' => 'required',
            ]);

            $shop_url = Str::slug($validatedData['name']);
            $count = Shop::where('shop_url', $shop_url)->count();
            if ($count > 0) {
                $shop_url = $shop_url . '-' . ($count + 1);
            }

            $userId = $request->input('user_id');
            $shopType = $validatedData['shop_type']; // Get the business_type from the request

            // Create the shop
            $shop = new Shop($validatedData);
            $shop->user_id = $userId;
            $shop->shop_url = $shop_url;
            $shop->template_type = 1;
            $shop->vat_tax = 0;
            $shop->stock_management = 1; // Default value
            $shop->show_product_sold_count = 1; // Default value
            $shop->default_delivery_charge = 120; // Default value
            $shop->slider = 1; // Default value
            $shop->today_sell = 1; // Default value
            $shop->top_selling = 1; // Default value
            $shop->top_category = 1; // Default value

            $shop->save();

            // Clone demo data based on the selected business type
            $this->cloneDemoData($shopType, $userId, $shop->id); // Pass the business type and shop id to clone demo data

            // Log the success message
            Log::info('Shop created successfully', ['id' => $shop->id]);

            // Return a success response
            return response()->json([
                'status' => 200,
                'message' => 'Shop created successfully',
            ]);
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json(['status' => 422, 'errors' => $e->errors()]);
        } catch (\Throwable $e) {
            // Log and return an error response
            Log::error('Error creating Shop', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    private function cloneDemoData($shopType, $userId, $shopId)
    {
        DB::beginTransaction();  // Start a transaction

        try {
            // Clone Categories
            $categoryMap = $this->cloneCategories($shopType, $userId, $shopId);

            // Clone Colors
            $colorMap = $this->cloneColors($shopType, $userId, $shopId);

            // Clone Sizes
            $sizeMap = $this->cloneSizes($shopType, $userId, $shopId);

            // Clone Products
            $this->cloneProducts($shopType, $userId, $shopId, $categoryMap, $colorMap, $sizeMap);

            // Add Top Selling Products (Shuffling and limiting to 8)
            $this->addTopSellingProducts($userId, $shopId);
            $this->addTodaySellingProducts($userId, $shopId);

            // Commit the transaction if everything is successful
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            Log::error('Error cloning demo data:', ['error' => $e->getMessage()]);
        }
    }

    private function addTodaySellingProducts($userId, $shopId)
    {
        // Get all products for the shop
        $products = DB::table('products')
            ->where('shop_id', $shopId)
            ->get();

        // Shuffle the products
        $shuffledProducts = $products->shuffle();

        // Get the top 8 products (limit to 8)
        $todaySellingProducts = $shuffledProducts->take(8);

        // Insert the top selling products into the 'today_sell_products' table
        foreach ($todaySellingProducts as $product) {
            DB::table('today_sell_products')->insert([
                'user_id' => $userId,
                'shop_id' => $shopId,
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function addTopSellingProducts($userId, $shopId)
    {
        // Get all products for the shop
        $products = DB::table('products')
            ->where('shop_id', $shopId)
            ->get();

        // Shuffle the products
        $shuffledProducts = $products->shuffle();

        // Get the top 8 products (limit to 8)
        $topSellingProducts = $shuffledProducts->take(8);

        // Insert the top selling products into the 'top_selling_products' table
        foreach ($topSellingProducts as $product) {
            DB::table('top_selling_products')->insert([
                'user_id' => $userId,
                'shop_id' => $shopId,
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }


    private function cloneCategories($shopType, $userId, $shopId)
    {
        $categoryMap = [];
        $demoCategories = DB::table('demo_categories')->where('business_type_id', $shopType)->get();

        // Counter for top categories
        $topCategoryCount = 0;

        foreach ($demoCategories as $category) {
            // Clone category
            $newCategoryId = DB::table('categories')->insertGetId([
                'name' => $category->name,
                'image' => $category->image,
                'description' => $category->description,
                'user_id' => $userId,
                'status' => true,
            ]);
            $categoryMap[$category->id] = $newCategoryId;

            // Add to top_categories if we haven't reached 7 categories
            if ($topCategoryCount < 7) {
                DB::table('top_categories')->insert([
                    'user_id' => $userId,
                    'shop_id' => $shopId,
                    'category_id' => $newCategoryId,
                    'position' => $topCategoryCount + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $topCategoryCount++;
            }
        }
        return $categoryMap;
    }


    private function cloneColors($shopType, $userId, $shopId)
    {
        $colorMap = [];
        $demoColors = DB::table('demo_colors')->where('business_type_id', $shopType)->get();
        foreach ($demoColors as $color) {
            $newColorId = DB::table('colors')->insertGetId([
                'color' => $color->color,
                'shop_id' => $shopId,
                'user_id' => $userId,
                'status' => true,
            ]);
            $colorMap[$color->id] = $newColorId;
        }
        return $colorMap;
    }

    private function cloneSizes($shopType, $userId, $shopId)
    {
        $sizeMap = [];
        $demoSizes = DB::table('demo_sizes')->where('business_type_id', $shopType)->get();
        foreach ($demoSizes as $size) {
            $newSizeId = DB::table('sizes')->insertGetId([
                'size' => $size->size,
                'shop_id' => $shopId,
                'user_id' => $userId,
                'status' => true,
            ]);
            $sizeMap[$size->id] = $newSizeId;
        }
        return $sizeMap;
    }

    private function cloneProducts($shopType, $userId, $shopId, $categoryMap, $colorMap, $sizeMap)
    {
        $demoProducts = DB::table('demo_products')->where('business_type_id', $shopType)->get();
        foreach ($demoProducts as $product) {
            // Map product colors and sizes with new IDs
            $productColors = $this->mapProductColors($product->product_colors, $colorMap);
            $productSizes = $this->mapProductSizes($product->product_sizes, $sizeMap);

            // Insert the product into the 'products' table
            $newCategoryId = isset($categoryMap[$product->category_id]) ? $categoryMap[$product->category_id] : null;
            $insertData = [
                'user_id' => $userId,
                'shop_id' => $shopId,
                'name' => $product->name,
                'slug' => $product->slug,
                'category_id' => $newCategoryId,
                'current_price' => $product->current_price,
                'old_price' => $product->old_price,
                'buy_price' => $product->buy_price,
                'product_code' => $product->product_code,
                'quantity' => $product->quantity,
                'warranty' => $product->warranty,
                'sold_count' => $product->sold_count,
                'has_details' => $product->has_details,
                'product_details' => $product->product_details,
                'product_colors' => json_encode($productColors),
                'product_sizes' => json_encode($productSizes),
                'has_variant' => $product->has_variant,
                'variant_name' => $product->variant_name,
                'product_variant' => $product->product_variant,
                'has_delivery_charge' => $product->has_delivery_charge,
                'delivery_charge' => $product->delivery_charge,
                'video' => $product->video,
                'description' => $product->description,
                'meta_title' => $product->meta_title,
                'meta_description' => $product->meta_description,
                'meta_keywords' => $product->meta_keywords,
                'product_info_list' => $product->product_info_list,
                'status' => true,
            ];

            $newProductId = DB::table('products')->insertGetId($insertData);  // Get the new product ID

            // Clone product images by linking demo_product_id to new product_id
            $this->cloneProductImages($product, $newProductId);
        }
    }

    private function mapProductColors($productColors, $colorMap)
    {
        $mappedColors = [];
        if (isset($productColors)) {
            foreach (json_decode($productColors) as $color) {
                if (isset($colorMap[$color->color])) {
                    $mappedColors[] = [
                        'color' => $colorMap[$color->color],
                        'price' => $color->price,
                        'quantity' => $color->quantity,
                    ];
                }
            }
        }
        return $mappedColors;
    }

    private function mapProductSizes($productSizes, $sizeMap)
    {
        $mappedSizes = [];
        if (isset($productSizes)) {
            foreach (json_decode($productSizes) as $size) {
                if (isset($sizeMap[$size->size])) {
                    $mappedSizes[] = [
                        'size' => $sizeMap[$size->size],
                        'price' => $size->price,
                        'quantity' => $size->quantity,
                    ];
                }
            }
        }
        return $mappedSizes;
    }

    private function cloneProductImages($product, $newProductId)
    {
        $demoImages = DemoProduct::find($product->id)->demoimages; // Using the relationship to get demo product images
        if ($demoImages) {
            foreach ($demoImages as $image) {
                $imagePath = $image->image_path;
                $newImageName = time() . '-' . uniqid() . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);
                $newImagePath = 'product_images/' . $newImageName;

                $oldImagePath = public_path($imagePath);
                $newImageFullPath = public_path($newImagePath);

                if (file_exists($oldImagePath)) {
                    copy($oldImagePath, $newImageFullPath);
                }

                DB::table('product_images')->insert([
                    'product_id' => $newProductId,
                    'image_path' => $newImagePath,
                ]);
            }
        }
    }






    public function edit($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        return response()->json(['shop' => $shop]);
    }


    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'name' => 'nullable|string',
                'shop_type' => 'nullable|string',
                'email' => 'nullable|email',
                'address' => 'nullable|string',
                'country' => 'nullable|string',
                'number' => 'nullable|numeric',
                'details' => 'nullable|string',
                'user_id' => 'nullable',
                'vat_tax' => 'nullable|string',
                'payment_message' => 'nullable|string',
                'stock_management' => 'nullable|boolean',
                'show_product_sold_count' => 'nullable|boolean',

                'color' => 'nullable|string',
                'image' => 'nullable|max:5120',
                'default_delivery_charge' => 'nullable|numeric',
                'specific_delivery_charges' => 'nullable',
                'delivery_charge_note' => 'nullable',

                'shop_domain' => 'nullable',
                'subdomain_id' => 'nullable',
                'shop_subdomain_name' => 'nullable',
                'shop_domain_name' => 'nullable',

                'live_chat_whatsapp' => 'nullable',
                'whatsapp_chat' => 'nullable',

                'gtm_id' => 'nullable',
                'facebook_pixel_id' => 'nullable',
                'facebook_pixel_access_token' => 'nullable',
                'facebook_pixel_event' => 'nullable',

                // Social links
                'facebook' => 'nullable',
                'instagram' => 'nullable',
                'linkedin' => 'nullable',
                'youtube' => 'nullable',
                'tiktok' => 'nullable',
                'telegram' => 'nullable',
                'whatsapp' => 'nullable',
                'discord' => 'nullable',

                // ✅ Add boolean fields for settings
                'slider' => 'nullable|boolean',
                'today_sell' => 'nullable|boolean',
                'new_arrival' => 'nullable|boolean',
                'new_arrival_banner' => 'nullable|boolean',
                'offer_product' => 'nullable|boolean',
                'hot_deal' => 'nullable|boolean',
                'flash_deal' => 'nullable|boolean',
                'top_rated' => 'nullable|boolean',
                'top_selling' => 'nullable|boolean',
                'related_product' => 'nullable|boolean',
                'top_category' => 'nullable|boolean',
                'customer_benefit' => 'nullable|boolean',
                'template_type' => 'nullable|numeric',
            ]);

            // Filter out null or empty fields
            $filteredData = array_filter($validatedData, function ($value) {
                return $value !== null && $value !== '';
            });

            // Log the filtered data to debug
            Log::info('Filtered data', $filteredData);

            $shop = Shop::findOrFail($id);

            // ✅ Merge the filtered data with boolean settings
            $shop->update($validatedData);

            // Handle logo upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if ($image->isValid()) {
                    if (File::exists($shop->logo)) {
                        File::delete($shop->logo);
                    }
                    $imageName = uniqid() . '-' . $image->getClientOriginalName();
                    $image->move(public_path('image/shop/'), $imageName);
                    $shop->logo = 'image/shop/' . $imageName;
                } else {
                    return response()->json(['status' => 400, 'error' => 'Invalid image file']);
                }
            }

            $shop->save();

            Log::info('Shop updated successfully', ['id' => $shop->id]);
            return response()->json([
                'status' => 200,
                'message' => 'Shop updated successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 422, 'errors' => $e->errors()]);
        } catch (\Throwable $e) {
            Log::error('Error updating shop', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json(['message' => 'Shop not found'], 404);
        }

        // Delete the logo file if it exists
        if ($shop->logo && Storage::exists($shop->logo)) {
            Storage::delete($shop->logo);
        }

        $shop->delete();

        return response()->json(['message' => 'Shop and logo deleted successfully'], 200);
    }
}
