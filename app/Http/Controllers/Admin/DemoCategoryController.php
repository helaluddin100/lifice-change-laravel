<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoCategory;
use Illuminate\Http\Request;

class DemoCategoryController extends Controller
{
    public function index()
    {
        $categories = DemoCategory::all();
        return view('admin.category.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'business_type_id' => 'required',
            'name' => 'required|string|max:255',
            'image' => 'required|image',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('demo_category'), $imageName);
            $imagePath = 'demo_category/' . $imageName;
        }

        // Status check
        $status = $request->has('status') ? 1 : 0;

        // Create and save the category
        $category = new DemoCategory();
        $category->name = $validatedData['name'];
        $category->image = $imagePath;
        $category->description = $validatedData['description'] ?? '';
        $category->status = $status;
        $category->business_type_id = $validatedData['business_type_id'];
        $category->save();

        // Redirect to the index page with success message
        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemoCategory  $demoCategory
     * @return \Illuminate\Http\Response
     */
    public function show(DemoCategory $demoCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DemoCategory  $demoCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(DemoCategory $demoCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemoCategory  $demoCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemoCategory $demoCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemoCategory  $demoCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemoCategory $demoCategory)
    {
        //
    }
}
