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
     * Display a listing of the resource.
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
    public function edit(BusinessType $businessType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessType  $businessType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessType $businessType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessType  $businessType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessType $businessType)
    {
        //
    }
}
