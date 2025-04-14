<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        try {
            $validated = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'status' => 'nullable|boolean',
            ]);
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('demo_category', $imageName, 'public');
            }
            DemoCategory::create([
                'business_type_id' => $validated['business_type_id'],
                'name' => $validated['name'],
                'image' => $imagePath,
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'] ?? true,
            ]);

            return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function edit(DemoCategory $category)
    {
        return view('admin.category.edit', compact('category'));
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
        try {
            $validated = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'status' => 'nullable|boolean',
            ]);

            $data = [
                'business_type_id' => $validated['business_type_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'] ?? false,
            ];

            // Handle image
            if ($request->hasFile('image')) {
                if ($demoCategory->image && Storage::disk('public')->exists($demoCategory->image)) {
                    Storage::disk('public')->delete($demoCategory->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('demo_category', $imageName, 'public');

                $data['image'] = $imagePath;
            }

            $demoCategory->update($data);

            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function destroy(DemoCategory $demoCategory)
    {
        try {
            if ($demoCategory->image && Storage::disk('public')->exists($demoCategory->image)) {
                Storage::disk('public')->delete($demoCategory->image);
            }

            $demoCategory->delete();

            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

}
