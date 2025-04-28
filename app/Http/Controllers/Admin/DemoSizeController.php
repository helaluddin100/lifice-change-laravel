<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoSize;
use Illuminate\Http\Request;

class DemoSizeController extends Controller
{
    public function index()
    {
        $sizes = DemoSize::orderBy('id', 'desc')->get();
        return view('admin.size.index', compact('sizes'));
    }
    public function create()
    {
        return view('admin.size.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'size' => 'required|string|max:255',
                'status' => 'nullable|boolean',
            ]);
            DemoSize::create([
                'business_type_id' => $validated['business_type_id'],
                'size' => $validated['size'],
                'status' => $validated['status'] ?? true,
            ]);

            return redirect()->route('admin.size.index')->with('success', 'Size created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemoSize  $demoSize
     * @return \Illuminate\Http\Response
     */
    public function show(DemoSize $demoSize)
    {
        //
    }
    public function edit(DemoSize $size)
    {
        return view('admin.size.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'size' => 'required|string|max:255',
                'status' => 'nullable|boolean',
            ]);
            $size = DemoSize::findOrFail($id);
            $size->size = $validatedData['size'];
            $size->business_type_id = $validatedData['business_type_id'];
            $size->status = $request->has('status') ? 1 : 0;
            $size->save();
            return redirect()->route('admin.size.index')->with('success', 'Size updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $size = Demosize::findOrFail($id);
        $size->delete();

        // Redirect with success message
        return redirect()->route('admin.size.index')->with('success', 'Size deleted successfully.');
    }
}
