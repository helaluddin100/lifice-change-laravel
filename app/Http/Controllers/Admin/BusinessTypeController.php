<?php

namespace App\Http\Controllers\Admin;

use App\Models\BusinessType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BusinessTypeController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $business_types = BusinessType::with('user')->get();
        return view('admin.business.index', compact('business_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.business.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $slug = Str::slug($validatedData['name']);

        $count = BusinessType::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $status = $request->has('status') ? 1 : 0;

        // Create a new Business instance
        $business = new BusinessType();
        $business->name = $validatedData['name'];
        $business->description = $validatedData['description'];
        $business->status = $status;
        $business->creator = Auth::user()->id;
        $business->slug = $slug;
        $business->save();

        // Redirect back with success message
        return redirect()->route('admin.business.index')->with('success', 'Business type created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessType  $businessType
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessType $businessType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessType  $businessType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business = BusinessType::find($id);
        return view('admin.business.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessType  $businessType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessType $business)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $status = $request->has('status') ? 1 : 0;

        $business->name = $validatedData['name'];
        $business->description = $validatedData['description'];
        $business->status = $status;
        $business->save();

        return redirect()->route('admin.business.index')->with('success', 'Business type updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessType  $businessType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessType $business)
    {
        $business->delete();

        return redirect()->route('admin.business.index')->with('success', 'Business type deleted successfully!');
    }
}
