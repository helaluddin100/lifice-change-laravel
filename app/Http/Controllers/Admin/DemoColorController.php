<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoColor;
use Illuminate\Http\Request;

class DemoColorController extends Controller
{
    public function index()
    {
        $colors = DemoColor::all();
        return view('admin.color.index', compact('colors'));
    }
    public function create()
    {
        return view('admin.color.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'color' => 'required|string|max:255',
                'status' => 'nullable|boolean',
            ]);
            DemoColor::create([
                'business_type_id' => $validated['business_type_id'],
                'color' => $validated['color'],
                'status' => $validated['status'] ?? true,
            ]);

            return redirect()->route('admin.color.index')->with('success', 'Color created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemoColor  $demoColor
     * @return \Illuminate\Http\Response
     */
    public function show(DemoColor $demoColor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DemoColor  $demoColor
     * @return \Illuminate\Http\Response
     */
    public function edit(DemoColor $demoColor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemoColor  $demoColor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemoColor $demoColor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemoColor  $demoColor
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemoColor $demoColor)
    {
        //
    }
}
