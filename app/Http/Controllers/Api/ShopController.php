<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function businessTypes()
    {
        $businessTypes = BusinessType::where('status', 1)->get();
        return response()->json($businessTypes);
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
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
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
