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
        // Clone Products (Assuming 'demo_products' table contains 'shop_id' and 'user_id' columns)
        // $demoProducts = DB::table('demo_products')
        //     ->where('business_type_id', $shopType)
        //     ->get();

        // foreach ($demoProducts as $product) {
        //     DB::table('products')->insert([
        //         'name' => $product->name,
        //         'category_id' => $product->category_id,
        //         'price' => $product->price,
        //         'size_id' => $product->size_id,
        //         'color_id' => $product->color_id,
        //         'shop_id' => $shopId,  // Associating with the created shop
        //         'user_id' => $userId,  // Associating with the user who created the shop
        //         'business_type_id' => $shopType,
        //         'status' => true,  // Assuming status is required
        //     ]);
        // }

        // Clone Categories
        $demoCategories = DB::table('demo_categories')
            ->where('business_type_id', $shopType)
            ->get();

        foreach ($demoCategories as $category) {
            DB::table('categories')->insert([
                'name' => $category->name,
                'image' => $category->image, // Assuming image is stored in demo_categories
                'description' => $category->description, // Nullable field
                'user_id' => $userId,  // Associating with the user who created the shop
                'status' => true,  // Default status
            ]);
        }

        // Clone Sizes
        $demoSizes = DB::table('demo_sizes')
            ->where('business_type_id', $shopType)
            ->get();

        foreach ($demoSizes as $size) {
            DB::table('sizes')->insert([
                'size' => $size->size,
                'shop_id' => $shopId,  // Associating with the created shop
                'user_id' => $userId,  // Associating with the user who created the shop
                'status' => true,  // Default status
            ]);
        }

        // Clone Colors
        $demoColors = DB::table('demo_colors')
            ->where('business_type_id', $shopType)
            ->get();

        foreach ($demoColors as $color) {
            DB::table('colors')->insert([
                'color' => $color->color,
                'shop_id' => $shopId,  // Associating with the created shop
                'user_id' => $userId,  // Associating with the user who created the shop
                'status' => true,  // Default status
            ]);
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
