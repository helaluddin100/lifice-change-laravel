<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\BusinessType;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;
use Storage;
use Illuminate\Support\Facades\File;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $shops = Shop::where('user_id', $userId)->get();
        return response()->json($shops);
    }

    public function index()
    {
        //
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


    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'shop_type' => 'required|string', // Include shop_type in the validation rules
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


            $shop = new Shop($validatedData);
            $shop->user_id = $userId;
            $shop->shop_url = $shop_url;
            $shop->save();

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


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        return response()->json(['shop' => $shop]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
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

                // social link
                'facebook' => 'nullable',
                'instagram' => 'nullable',
                'linkedin' => 'nullable',
                'youtube' => 'nullable',
                'tiktok' => 'nullable',
                'telegram' => 'nullable',
                'whatsapp' => 'nullable',
                'discord' => 'nullable'

            ]);

            // Log the validated data to see what's being passed
            Log::info('Validated data', $validatedData);

            $shop = Shop::findOrFail($id);
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
            // Return validation errors
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
    public function destroy(Shop $shop)
    {
        //
    }
}