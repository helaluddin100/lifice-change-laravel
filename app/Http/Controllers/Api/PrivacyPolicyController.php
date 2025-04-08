<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{

    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $privacy = PrivacyPolicy::where('user_id', $userId)->get();

        return response()->json([
            'status' => 200,
            'privacy' => $privacy, // Fixing key
        ]);
    }

    public function getPrivacyByUser($id)
    {
        $privacy = PrivacyPolicy::where('user_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'privacy' => $privacy, // <-- Fixing the key
        ]);
    }
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        $request->validate([
            'privacy_policy' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        $privacy = new PrivacyPolicy();
        $privacy->privacy_policy = $request->privacy_policy;
        $privacy->user_id = $request->user_id;
        $privacy->shop_id = $request->shop_id;
        $privacy->status = $request->status;
        $privacy->save();

        return response()->json([
            'status' => 200,
            'message' => 'Privacy Policy created successfully!',
            'privacy' => $privacy,
        ]);
    }



    public function edit($id)
    {
        $privacies = PrivacyPolicy::find($id);

        if (!$privacies) {
            return response()->json(['message' => 'Privacy Policy not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'privacy' => $privacies,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'privacy_policy' => 'nullable',
            'status' => 'required|boolean',
        ]);

        $privacy = PrivacyPolicy::find($id);
        if (!$privacy) {
            return response()->json([
                'status' => 404,
                'message' => 'About Us not found.',
            ], 404);
        }

        $privacy->privacy_policy = $request->privacy_policy;
        $privacy->status = $request->status;
        $privacy->save();


        return response()->json([
            'status' => 200,
            'message' => 'Privacy Policy updated successfully!',
            'privacy' => $privacy,
        ]);
    }

    public function destroy($id)
    {
        $privacy = PrivacyPolicy::find($id);

        if (!$privacy) {
            return response()->json(['message' => 'Privacy Policy entry not found'], 404);
        }

        $privacy->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Privacy Policy deleted successfully!',
        ]);
    }
}
