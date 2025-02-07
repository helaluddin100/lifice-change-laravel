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
            'about_us' => 'nullable',
            'privacy_policy' => 'nullable',
            'terms_con' => 'nullable',
            'return_can' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        // Check if a setup shop page already exists for this user and shop
        $setupShopPage = SetupShopPage::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->first();

        if ($setupShopPage) {
            // Update existing record
            $setupShopPage->update($validatedData);
            return response()->json([
                'status' => 200,
                'message' => 'Setup Shop Page updated successfully!',
                'data' => $setupShopPage,
            ]);
        } else {
            // Create new record
            $setupShopPage = SetupShopPage::create($validatedData);
            return response()->json([
                'status' => 200,
                'message' => 'Setup Shop Page created successfully!',
                'data' => $setupShopPage,
            ]);
        }
    }


    public function show(SetupShopPage $SetupShopPage)
    {
        //
    }
}
