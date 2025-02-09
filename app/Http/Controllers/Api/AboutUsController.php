<?php
namespace App\Http\Controllers\Api;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{

    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $abouts = AboutUs::where('user_id', $userId)->get();

        return response()->json([
            'status' => 200,
            'abouts' => $abouts, // Fixing key
        ]);
    }

    public function getAboutsByUser($id)
    {
        $aboutUs = AboutUs::where('user_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'abouts' => $aboutUs, // <-- Fixing the key
        ]);
    }
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        $request->validate([
            'about_us' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'status' => 'required|boolean',
        ]);

        $about = new AboutUs();
        $about->about_us = $request->about_us;
        $about->user_id = $request->user_id;
        $about->shop_id = $request->shop_id;
        $about->status = $request->status;
        $about->save();

        return response()->json([
            'status' => 200,
            'message' => 'about created successfully!',
            'about' => $about,
        ]);
    }



    public function show(AboutUs $aboutUs)
    {
        //
    }

    public function edit($id)
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json(['message' => 'About Us not found'], 404);
        }

        return response()->json([
            'aboutUs' => $aboutUs,
        ]);
    }
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'about_us' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        // Find the existing AboutUs entry
        $aboutUs = AboutUs::findOrFail($id);
        $aboutUs->about_us = $request->about_us;
        $aboutUs->status = $request->status;
        $aboutUs->save();

        return response()->json([
            'status' => 200,
            'message' => 'About Us updated successfully!',
            'aboutUs' => $aboutUs,
        ]);
    }


    public function destroy(AboutUs $aboutUs)
    {
        //
    }
}
