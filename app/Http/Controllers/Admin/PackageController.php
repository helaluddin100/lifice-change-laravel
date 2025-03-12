<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\Country;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('admin.package.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countrys = Country::all();
        return view('admin.package.create', compact('countrys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'country' => 'required',
            'name' => 'required|string|max:255',
            'product_limit' => 'required',
            'page_limit' => 'required',
            'email_marketing' => 'required',
            'card' => 'required',
            'price' => 'required|numeric',
            'package_time' => 'required',
            'offer_price' => 'nullable|numeric',
            'features' => 'required|array',
            'features.*' => 'string',
            'description' => 'required|string',
            'status' => 'required',
        ]);

        // Save the package
        $package = new Package();
        $package->country_id = $request->country;
        $package->name = $request->name;
        $package->package_time = $request->package_time;
        $package->product_limit = $request->product_limit;
        $package->page_limit = $request->page_limit;
        $package->email_marketing = $request->email_marketing;
        $package->card = $request->card;
        $package->price = $request->price;
        $package->offer_price = $request->offer_price;
        $package->features = $request->features; // Store features as array
        $package->description = $request->description;
        $package->status = $request->status == 'on' ? true : false; // Convert checkbox value to boolean

        // Save to the database
        $package->save();

        // Return success response
        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);
        $countrys = Country::all();
        return view('admin.package.edit', compact('package', 'countrys'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate request data
        $request->validate([
            'country' => 'required',
            'name' => 'required|string|max:255',
            'product_limit' => 'required',
            'page_limit' => 'required',
            'email_marketing' => 'required',
            'card' => 'required',
            'package_time' => 'required',
            'price' => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'features' => 'required|array',
            'features.*' => 'string', // Each feature must be a string
            'description' => 'required|string',
            'status' => 'required',
        ]);

        // Find the existing package by ID
        $package = Package::findOrFail($id);

        // Update the package with the new data
        $package->country_id = $request->country;
        $package->name = $request->name;
        $package->package_time = $request->package_time;
        $package->product_limit = $request->product_limit;
        $package->page_limit = $request->page_limit;
        $package->email_marketing = $request->email_marketing;
        $package->card = $request->card;
        $package->price = $request->price;
        $package->offer_price = $request->offer_price;
        $package->features = $request->features; // Store features as array
        $package->description = $request->description;
        $package->status = $request->status == 'on' ? true : false; // Convert checkbox value to boolean

        // Save the updated package
        $package->save();

        // Return success response
        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the package by ID
        $package = Package::findOrFail($id);

        // Delete the package
        $package->delete();

        // Return success response
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully!');
    }
}
