<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientReview;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
class ClientReviewController extends Controller
{

    public function index()
    {
        $clientReviews = ClientReview::all();
        return view('admin.client-review.index', compact('clientReviews'));
    }
    public function create()
    {
        return view("admin.client-review.create");
    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "shop_name" => "required",
            "description" => "required",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/client-review');
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0777, true);
            }
            $imagePath = $imagePath . '/' . $imageName;

            $imageSubmitPath = 'images/client-review/' . $imageName;
            // Resize and convert image to webp
            Image::make($image)->encode('webp', 90)->save($imagePath . '.webp');
            $imageSubmitPath = 'images/client-review/' . $imageName . '.webp';
        }
        $status = $request->has('status') ? 1 : 0;

        $courier = ClientReview::create([
            "name" => $request->name,
            "shop_name" => $request->shop_name,
            "description" => $request->description,
            "image" => $imageSubmitPath,
            "status" => $status,
        ]);

        $courier->save();

        return redirect()->route("admin.client-review.index")->with("success", "Client Review created successfully");
    }


    public function edit($id)
    {
        // Corrected the find method by passing the id directly
        $clientReview = ClientReview::find($id);

        // Return the edit view with the clientReview data
        return view('admin.client-review.edit', compact('clientReview'));
    }

    public function update(Request $request, ClientReview $clientReview)
    {
        // Validate the request data
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "shop_name" => "required",
            "description" => "required",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048", // Make image optional
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $clientReview->name = $request->name;
        $clientReview->shop_name = $request->shop_name;
        $clientReview->description = $request->description;

        if ($request->hasFile('image')) {
            $oldImagePath = public_path($clientReview->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/client-review');
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0777, true);
            }
            $imageSubmitPath = 'images/client-review/' . $imageName . '.webp';
            Image::make($image)->encode('webp', 90)->save($imagePath . '/' . $imageName . '.webp');
            $clientReview->image = $imageSubmitPath;
        }
        $clientReview->status = $request->has('status') ? 1 : 0;
        $clientReview->save();
        return redirect()->route('admin.client-review.index')->with('success', 'Client Review updated successfully');
    }

    public function destroy($id)
    {
        $clientReview = ClientReview::find($id);
        if ($clientReview) {
            $oldImagePath = public_path($clientReview->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $clientReview->delete();
            return redirect()->route('admin.client-review.index')->with('success', 'Client Review deleted successfully');
        } else {
            return redirect()->route('admin.client-review.index')->with('error', 'Client Review not found');
        }
    }

}
