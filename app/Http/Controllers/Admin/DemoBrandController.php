<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoBrand;
use Illuminate\Http\Request;

class DemoBrandController extends Controller
{
    public function index()
    {
        $brands = DemoBrand::orderBy('id', 'desc')->get();
        return view('admin.brand.index', compact('brands'));
    }
    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'brand' => 'required|string|max:255',
                'status' => 'nullable|boolean',
            ]);
            DemoBrand::create([
                'business_type_id' => $validated['business_type_id'],
                'brand' => $validated['brand'],
                'status' => $validated['status'] ?? true,
            ]);

            return redirect()->route('admin.brand.index')->with('success', 'Brand created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function edit(DemoBrand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'brand' => 'required|string|max:255',
                'status' => 'nullable|boolean',
            ]);
            $brand = DemoBrand::findOrFail($id);
            $brand->brand = $validatedData['brand'];
            $brand->business_type_id = $validatedData['business_type_id'];
            $brand->status = $request->has('status') ? 1 : 0;
            $brand->save();
            return redirect()->route('admin.brand.index')->with('success', 'Brand updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $brand = DemoBrand::findOrFail($id);
        $brand->delete();

        // Redirect with success message
        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully.');
    }
}
