<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cancellation;

class CancellationController extends Controller
{

    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $cancellation = Cancellation::where('user_id', $userId)->get();

        return response()->json([
            'status' => 200,
            'cancellation' => $cancellation, // Fixing key
        ]);
    }

    public function getCancellationsByUser($id)
    {
        $cancellation = Cancellation::where('user_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'cancellation' => $cancellation, // <-- Fixing the key
        ]);
    }
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        $request->validate([
            'cancellation' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        $cancellation = new Cancellation();
        $cancellation->cancellation = $request->cancellation;
        $cancellation->user_id = $request->user_id;
        $cancellation->shop_id = $request->shop_id;
        $cancellation->status = $request->status;
        $cancellation->save();

        return response()->json([
            'status' => 200,
            'message' => '. Return and Cancellation Policy created successfully!',
            'cancellation' => $cancellation,
        ]);
    }



    public function edit($id)
    {
        $cancellation = Cancellation::find($id);

        if (!$cancellation) {
            return response()->json(['message' => '. Return and Cancellation Policy not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'cancellation' => $cancellation,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cancellation' => 'nullable',
            'status' => 'required|boolean',
        ]);
        $cancellation = Cancellation::find($id);
        if (!$cancellation) {
            return response()->json([
                'status' => 404,
                'message' => 'Cancellation not found.',
            ], 404);
        }
        $cancellation->cancellation = $request->cancellation;
        $cancellation->status = $request->status;
        $cancellation->save();

        return response()->json([
            'status' => 200,
            'message' => '. Return and Cancellation Policy updated successfully!',
            'cancellation' => $cancellation, // Use "about" instead of "aboutUs"
        ]);
    }

    public function destroy($id)
    {
        $cancellation = Cancellation::find($id);

        if (!$cancellation) {
            return response()->json(['message' => '. Return and Cancellation Policy entry not found'], 404);
        }

        $cancellation->delete();

        return response()->json([
            'status' => 200,
            'message' => '. Return and Cancellation Policy deleted successfully!',
        ]);
    }
}
