<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerBenefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CustomerBenefitController extends Controller
{
    public function index($shop_id)
    {
        $customer_benefits = CustomerBenefit::with(['user', 'shop'])
            ->where('shop_id', $shop_id)
            ->where('status', true)
            ->get();

        return response()->json($customer_benefits, 200);
    }

    // Create a new slider
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'short_description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the user already has 3 sliders for the shop
        $custo_benefit_count = CustomerBenefit::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->count();

        if ($custo_benefit_count >= 5) {
            return response()->json([
                'error' => 'You can only create a maximum of 5 Customer Benefit for this shop.'
            ], 400);
        }

        // Upload the image
        $imagePath = $request->file('image')->store('benefits', 'public');

        // Create the new slider
        $custo_benefit = CustomerBenefit::create([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id,
            'image' => $imagePath,
            'name' => $request->name,
            'short_description' => $request->short_description,
            'status' => true,
        ]);

        return response()->json([
            'message' => 'Customer Benefit added successfully',
            'custo_benefit' => $custo_benefit->load('user', 'shop'),
        ], 201);
    }



    // Update a slider
    // public function update(Request $request, $id)
    // {
    //     $custo_benefit = CustomerBenefit::find($id);
    //     if (!$custo_benefit) {
    //         return response()->json(['error' => 'Customer Benefit not found'], 404);
    //     }

    //     // Validate the incoming request data
    //     $validator = Validator::make($request->all(), [
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'name' => 'required',
    //         'short_description' => 'required',
    //         'status' => 'boolean',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     // Check if a new image is being uploaded
    //     if ($request->hasFile('image')) {
    //         // Delete the old image from storage if it exists
    //         if ($custo_benefit->image && Storage::disk('public')->exists($custo_benefit->image)) {
    //             Storage::disk('public')->delete($custo_benefit->image);
    //         }

    //         $custo_benefit->image = $request->file('image')->store('sliders', 'public');
    //     }

    //     $custo_benefit->name = $request->name ?? $custo_benefit->name;
    //     $custo_benefit->short_description = $request->short_description ?? $custo_benefit->short_description;
    //     $custo_benefit->status = $request->status ?? $custo_benefit->status;

    //     $custo_benefit->save();

    //     // Return a response with the updated slider
    //     return response()->json(['message' => 'Customer Benefit updated successfully', 'custo_benefit' => $custo_benefit], 200);
    // }
    public function update(Request $request, $id)
    {
        $custo_benefit = CustomerBenefit::find($id);
        if (!$custo_benefit) {
            return response()->json(['error' => 'Customer Benefit not found'], 404);
        }

        // Updated validation rule for image
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'short_description' => 'required',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if a new image is being uploaded
        if ($request->hasFile('image')) {
            // Delete the old image from storage if it exists
            if ($custo_benefit->image && Storage::disk('public')->exists($custo_benefit->image)) {
                Storage::disk('public')->delete($custo_benefit->image);
            }

            $custo_benefit->image = $request->file('image')->store('benefits', 'public');
        }

        $custo_benefit->name = $request->name ?? $custo_benefit->name;
        $custo_benefit->short_description = $request->short_description ?? $custo_benefit->short_description;
        $custo_benefit->status = $request->status ?? $custo_benefit->status;

        $custo_benefit->save();

        return response()->json(['message' => 'Customer Benefit updated successfully', 'custo_benefit' => $custo_benefit], 200);
    }



    // Delete a slider
    public function destroy($id)
    {
        $custo_benefit = CustomerBenefit::find($id);
        if (!$custo_benefit) {
            return response()->json(['error' => 'Slider not found'], 404);
        }

        // Delete image from storage
        Storage::disk('public')->delete($custo_benefit->image);

        $custo_benefit->delete();
        return response()->json(['message' => 'Customer Benefit deleted successfully'], 200);
    }
}