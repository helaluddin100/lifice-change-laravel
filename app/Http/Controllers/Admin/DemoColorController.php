<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoColor;
use Illuminate\Http\Request;

class DemoColorController extends Controller
{
    public function index()
    {
        $colors = DemoColor::orderBy('id', 'desc')->get();
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


    public function show(DemoColor $demoColor)
    {
        //
    }


    public function edit(DemoColor $color)
    {
        return view('admin.color.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'business_type_id' => 'required|exists:business_types,id',
                'color' => 'required|string|max:255',
                'status' => 'nullable|boolean',
            ]);
            $color = DemoColor::findOrFail($id);
            $color->color = $validatedData['color'];
            $color->business_type_id = $validatedData['business_type_id'];
            $color->status = $request->has('status') ? 1 : 0;

            $color->save();
            return redirect()->route('admin.color.index')->with('success', 'Color updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $color = DemoColor::findOrFail($id);
        $color->delete();

        // Redirect with success message
        return redirect()->route('admin.color.index')->with('success', 'Color deleted successfully.');
    }
}
