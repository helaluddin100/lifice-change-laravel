<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the user ID from the request
        $userId = $request->query('user_id');

        // Fetch categories for the specified user
        $sizes = Size::where('user_id', $userId)->get();

        return response()->json([
            'status' => 200,
            'sizes' => $sizes,
        ]);
    }


    public function getSizeByShop($id)
    {
        $sizes = Size::where('shop_id', $id)
            ->where('status', 1) // Corrected this line
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'status' => 200,
            'sizes' => $sizes,
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
            'size' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        $size = new Size();
        $size->size = $request->size;
        $size->user_id = $request->user_id;
        $size->shop_id = $request->shop_id;
        $size->status = $request->status;
        $size->save();

        return response()->json([
            'status' => 200,
            'message' => 'Size created successfully!',
            'size' => $size,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json(['error' => 'size not found'], 404);
        }

        return response()->json(['size' => $size]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'size' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $size = Size::findOrFail($id);
        $size->size = $request->size;
        $size->status = $request->status;
        $size->save();

        return response()->json([
            'status' => 200,
            'message' => 'Size updated successfully!',
            'size' => $size,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $size = Size::findOrFail($id);
            $size->delete();
            return response()->json([
                'status' => 200,
                'message' => 'size deleted successfully',
            ]);
        } catch (\Throwable $e) {
            // Log and handle errors
            return response()->json(['status' => 500, 'error' => 'An error occurred. Please try again later.'], 500);
        }
    }
}
