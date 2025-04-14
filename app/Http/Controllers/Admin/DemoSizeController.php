<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoSize;
use Illuminate\Http\Request;

class DemoSizeController extends Controller
{
    public function index()
    {
        $sizes = DemoSize::all();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DemoSize  $demoSize
     * @return \Illuminate\Http\Response
     */
    public function edit(DemoSize $demoSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemoSize  $demoSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemoSize $demoSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemoSize  $demoSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemoSize $demoSize)
    {
        //
    }
}
