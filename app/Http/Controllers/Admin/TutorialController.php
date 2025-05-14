<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::all();

        return view('admin.tutorial.index', compact('tutorials'));
    }

    public function create()
    {
        return view('admin.tutorial.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'link' => 'required|url',
                'image' => 'nullable|image',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('tutorial'), $imageName);
                $imagePath = 'tutorial/' . $imageName;
            }

            $status = $request->has('status') ? 1 : 0;

            Tutorial::create([
                'name' => $validated['name'],
                'link' => $validated['link'],
                'image' => $imagePath,
                'status' => $status,
            ]);

            return redirect()->route('admin.tutorial.index')->with('success', 'Tutorial created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tutorial = Tutorial::findOrFail($id);

        return view('admin.tutorial.edit', compact('tutorial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tutorial = Tutorial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp ',
            'link' => 'required|url',
        ]);

        if ($request->hasFile('image')) {
            $oldImagePath = public_path($tutorial->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('tutorial'), $imageName);
            $imagePath = 'tutorial/' . $imageName;
        } else {
            $imagePath = $tutorial->image;
        }

        $status = $request->has('status') ? 1 : 0;

        $tutorial->update([
            'name' => $validated['name'],
            'link' => $validated['link'],
            'image' => $imagePath,
            'status' => $status,
        ]);

        return redirect()->route('admin.tutorial.index')->with('success', 'Tutorial updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tutorial = Tutorial::findOrFail($id);

        $imagePath = public_path($tutorial->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $tutorial->delete();

        return redirect()->route('admin.tutorial.index')->with('success', 'Tutorial deleted successfully.');
    }
}
