<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers = Courier::all();
        return view("admin.courier.index", compact("couriers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.courier.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg ",
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/couriers');
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0777, true);
            }
            $imagePath = $imagePath . '/' . $imageName;

            $imageSubmitPath = 'images/couriers/' . $imageName;
            // Resize and convert image to webp
            Image::make($image)->encode('webp', 90)->save($imagePath . '.webp');
            $imageSubmitPath = 'images/couriers/' . $imageName . '.webp';
        }
        $status = $request->has('status') ? 1 : 0;

        $courier = Courier::create([
            "name" => $request->name,
            "image" => $imageSubmitPath,
            "status" => $status,
        ]);

        $courier->save();

        return redirect()->route("admin.courier.index")->with("success", "Courier created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function show(Courier $courier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view("admin.courier.edit", compact("courier"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $imageSubmitPath = $courier->image; // keep old image by default

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/couriers');

            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0777, true);
            }

            $imagePath = $imagePath . '/' . $imageName;
            $imageSubmitPath = 'images/couriers/' . $imageName . '.webp';

            // Save image in webp format
            Image::make($image)->encode('webp', 90)->save($imagePath . '.webp');
        }

        $courier->name = $request->name;
        $courier->status = $request->has('status') ? 1 : 0;
        $courier->image = $imageSubmitPath;
        $courier->save();

        return redirect()->route("admin.courier.index")->with("success", "Courier updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);

        // Delete courier image file if it exists
        if ($courier->image && file_exists(public_path($courier->image))) {
            unlink(public_path($courier->image));
        }

        $courier->delete();

        return redirect()->route('admin.courier.index')->with('success', 'Courier deleted successfully');
    }
}
