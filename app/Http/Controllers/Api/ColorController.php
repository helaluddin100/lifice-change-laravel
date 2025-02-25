<?php

namespace App\Http\Controllers\Api;

use App\Models\Color;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        $colors = Color::where('user_id', $userId)->get()->map(function ($color) use ($userId) {
            $color->product_count = Product::where('user_id', $userId)
                ->whereRaw("JSON_CONTAINS(product_colors, ?)", [json_encode([['color' => (string)$color->id]])])
                ->count();
            return $color;
        });

        return response()->json([
            'status' => 200,
            'colors' => $colors,
        ]);
    }






    public function getColorByShop($id)
    {
        $colors = Color::where('shop_id', $id)
            ->where('status', 1) // Corrected this line
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 200,
            'colors' => $colors,
        ]);
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
        $request->validate([
            'color' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        $color = new Color();
        $color->color = $request->color;
        $color->user_id = $request->user_id;
        $color->shop_id = $request->shop_id;
        $color->status = $request->status;
        $color->save();

        return response()->json([
            'status' => 200,
            'message' => 'Color created successfully!',
            'color' => $color,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::find($id);

        if (!$color) {
            return response()->json(['error' => 'color not found'], 404);
        }

        return response()->json(['color' => $color]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        $request->validate([
            'color' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $color = Color::findOrFail($id);
        $color->color = $request->color;
        $color->status = $request->status;
        $color->save();

        return response()->json([
            'status' => 200,
            'message' => 'Color updated successfully!',
            'color' => $color,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();
            return response()->json([
                'status' => 200,
                'message' => 'color deleted successfully',
            ]);
        } catch (\Throwable $e) {
            // Log and handle errors
            return response()->json(['status' => 500, 'error' => 'An error occurred. Please try again later.'], 500);
        }
    }
}
