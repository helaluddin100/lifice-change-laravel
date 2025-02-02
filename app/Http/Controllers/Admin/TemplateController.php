<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

    public function index()
    {
        $templates = Template::all();

        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('templates'), $imageName);
            $imagePath = 'templates/' . $imageName;
        }
        $status = $request->has('status') ? 1 : 0;

        Template::create([
            'name' => $validated['name'],
            'image' => $imagePath,
            'description' => $validated['description'],
            'status' => $status,
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Template created successfully.');
    }



    // Show the edit form for a template
    public function edit($id)
    {
        $template = Template::findOrFail($id);

        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $oldImagePath = public_path($template->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('templates'), $imageName);
            $imagePath = 'templates/' . $imageName;
        } else {
            $imagePath = $template->image;
        }

        $status = $request->has('status') ? 1 : 0;

        $template->update([
            'name' => $validated['name'],
            'image' => $imagePath,
            'description' => $validated['description'],
            'status' => $status,
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Template updated successfully.');
    }


    public function destroy($id)
    {
        $template = Template::findOrFail($id);

        $imagePath = public_path($template->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $template->delete();

        return redirect()->route('admin.templates.index')->with('success', 'Template deleted successfully.');
    }

}
