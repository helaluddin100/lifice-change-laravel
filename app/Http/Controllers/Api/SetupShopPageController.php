<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\SetupShopPage;
use Illuminate\Http\Request;

class SetupShopPageController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $setupShopPage = SetupShopPage::where('user_id', $userId)->get();
        return response()->json([
            'status' => 200,
            'data' => $setupShopPage,
        ]);
    }


    public function getSetupShopPage($id)
    {
        $setupShopPages = SetupShopPage::where('shop_id', $id)
            ->where('status', 1) // Corrected this line
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'status' => 200,
            'data' => $setupShopPages,
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'about_us' => 'nullable|string',
            'privacy_policy' => 'nullable|string',
            'terms_con' => 'nullable|string',
            'return_can' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
        ], [
            'user_id.exists' => 'The selected user does not exist.',
            'shop_id.exists' => 'The selected shop does not exist.',
        ]);

        $setupShopPage = SetupShopPage::updateOrCreate(
            ['user_id' => $request->user_id, 'shop_id' => $request->shop_id],
            $validatedData
        );

        return response()->json([
            'status' => 200,
            'message' => $setupShopPage->wasRecentlyCreated
                ? 'Setup Shop Page created successfully!'
                : 'Setup Shop Page updated successfully!',
            'data' => $setupShopPage,
        ]);
    }


    public function show(SetupShopPage $SetupShopPage)
    {
        //
    }
}