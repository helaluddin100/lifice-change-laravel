<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Models\Shop;
use App\Models\Country;
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
                'user_id' => 'required', // Assuming user_id is provided in the request
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
            // Clone Categories and create a map for the category ids
            $categoryMap = []; // Initialize category map
            $demoCategories = DB::table('demo_categories')
                ->where('business_type_id', $shopType)
                ->get();

            foreach ($demoCategories as $category) {
                Log::debug('Inserting Category:', ['category' => $category]);  // Debug log

                // Insert the category into the 'categories' table
                $newCategoryId = DB::table('categories')->insertGetId([
                    'name' => $category->name,
                    'image' => $category->image, // Assuming image is stored in demo_categories
                    'description' => $category->description, // Nullable field
                    'user_id' => $userId,  // Associating with the user who created the shop
                    'status' => true,  // Default status
                ]);

                // Map original category ID to the new category ID
                $categoryMap[$category->id] = $newCategoryId;
            }

            // Create color map to maintain original IDs
            $colorMap = [];
            $demoColors = DB::table('demo_colors')
                ->where('business_type_id', $shopType)
                ->get();

            foreach ($demoColors as $color) {
                Log::debug('Inserting Color:', ['color' => $color]);  // Debug log
                // Insert the color into the 'colors' table and map the original ID to the new ID
                $newColorId = DB::table('colors')->insertGetId([
                    'color' => $color->color,
                    'shop_id' => $shopId,
                    'user_id' => $userId,
                    'status' => true,  // Default status
                ]);

                // Map original color ID to new ID
                $colorMap[$color->id] = $newColorId;
            }

            // Create size map to maintain original IDs
            $sizeMap = [];
            $demoSizes = DB::table('demo_sizes')
                ->where('business_type_id', $shopType)
                ->get();

            foreach ($demoSizes as $size) {
                Log::debug('Inserting Size:', ['size' => $size]);  // Debug log
                // Insert the size into the 'sizes' table and map the original ID to the new ID
                $newSizeId = DB::table('sizes')->insertGetId([
                    'size' => $size->size,
                    'shop_id' => $shopId,
                    'user_id' => $userId,
                    'status' => true,  // Default status
                ]);

                // Map original size ID to new ID
                $sizeMap[$size->id] = $newSizeId;
            }

            // Clone Products and update product_colors and product_sizes JSON with new IDs
            $demoProducts = DB::table('demo_products')
                ->where('business_type_id', $shopType)
                ->get();

            foreach ($demoProducts as $product) {
                Log::debug('Inserting Product:', ['product' => $product]);  // Debug log

                // Map product colors and sizes with new IDs and proper structure
                $productColors = [];
                if (isset($product->product_colors)) {
                    foreach (json_decode($product->product_colors) as $color) {
                        // Handle color if it's a stdClass object and replace with new ID
                        if (isset($colorMap[$color->color])) {
                            // Construct color objects with price and quantity
                            $productColors[] = [
                                'color' => $colorMap[$color->color],
                                'price' => $color->price,
                                'quantity' => $color->quantity,
                            ];
                        }
                    }
                }

                $productSizes = [];
                if (isset($product->product_sizes)) {
                    foreach (json_decode($product->product_sizes) as $size) {
                        // Handle size if it's a stdClass object and replace with new ID
                        if (isset($sizeMap[$size->size])) {
                            // Construct size objects with price and quantity
                            $productSizes[] = [
                                'size' => $sizeMap[$size->size],
                                'price' => $size->price,
                                'quantity' => $size->quantity,
                            ];
                        }
                    }
                }

                // Get the new category ID from the map and insert the product
                $newCategoryId = isset($categoryMap[$product->category_id]) ? $categoryMap[$product->category_id] : null;

                // Insert the product into the 'products' table
                $insertData = [
                    'user_id' => $userId,
                    'shop_id' => $shopId,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category_id' => $newCategoryId,  // Use the new category ID
                    'current_price' => $product->current_price,
                    'old_price' => $product->old_price,
                    'buy_price' => $product->buy_price,
                    'product_code' => $product->product_code,
                    'quantity' => $product->quantity,
                    'warranty' => $product->warranty,
                    'sold_count' => $product->sold_count,
                    'has_details' => $product->has_details,
                    'product_details' => $product->product_details,
                    'product_colors' => json_encode($productColors), // Updated colors with new IDs and additional data
                    'product_sizes' => json_encode($productSizes),   // Updated sizes with new IDs and additional data
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

                // Log the final data before insertion
                Log::debug('Inserting final Product Data:', ['product_data' => $insertData]);

                // Insert the product
                DB::table('products')->insert($insertData);
            }

            // Commit the transaction if everything is successful
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            Log::error('Error cloning demo data:', ['error' => $e->getMessage()]);
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
