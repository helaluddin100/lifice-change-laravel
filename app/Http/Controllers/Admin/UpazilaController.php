<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\upazila;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Facades\Log;
use League\Config\Exception\ValidationException;

class UpazilaController extends Controller
{

    public function index()
    {
        $upazilas = Upazila::with('country')->get();
        return view('admin.upazila.index', compact('upazilas'));
    }

    public function create()
    {
        $countryes = Country::all();
        $divisions = Division::all();
        $districts = District::all();
        return view('admin.upazila.create', compact('countryes', 'districts', 'divisions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string',
            'division' => 'required|string',
            'district' => 'required|string',
        ]);
        $status = $request->has('status') ? 1 : 0;
        // Create a new country instance
        $upazila = new upazila();
        $upazila->name = $validatedData['name'];
        $upazila->country_id = $validatedData['country'];
        $upazila->division_id = $validatedData['division'];
        $upazila->district_id = $validatedData['district'];
        $upazila->status = $status;
        $upazila->save();

        // Redirect back with success message
        return redirect()->route('admin.upazila.index')->with('success', 'Upazila created successfully!');
    }

    public function edit($id)
    {
        $upazila = upazila::find($id);
        $countryes = Country::all();
        $divisions = Division::all();
        $districts = District::all();
        return view('admin.upazila.edit', compact('upazila', 'countryes', 'divisions', 'districts'));
    }

    public function update(Request $request, upazila $upazila)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string',
            'division' => 'required|string',
            'district' => 'required|string',

        ]);

        $status = $request->has('status') ? 1 : 0;

        $upazila->name = $validatedData['name'];
        $upazila->country_id = $validatedData['country'];
        $upazila->division_id = $validatedData['division'];
        $upazila->district_id = $validatedData['district'];
        $upazila->status = $status;
        $upazila->save();

        return redirect()->route('admin.upazila.index')->with('success', 'upazila updated successfully!');
    }

    public function destroy(upazila $upazila)
    {
        $upazila->delete();

        return redirect()->route('admin.upazila.index')->with('success', 'upazila deleted successfully!');
    }
}
