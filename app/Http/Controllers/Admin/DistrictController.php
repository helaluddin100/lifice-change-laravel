<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Division;
use Illuminate\Support\Facades\Log;
use League\Config\Exception\ValidationException;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::with('country')->get();
        return view('admin.district.index', compact('districts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countryes = Country::all();
        $divisions = Division::all();
        return view('admin.district.create', compact('countryes', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string',
            'division' => 'required|string',
        ]);



        $status = $request->has('status') ? 1 : 0;

        // Create a new country instance
        $district = new District();
        $district->name = $validatedData['name'];
        $district->country_id = $validatedData['country'];
        $district->division_id = $validatedData['division'];
        $district->status = $status;
        $district->save();

        // Redirect back with success message
        return redirect()->route('admin.district.index')->with('success', 'District created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $district = District::find($id);
        $countryes = Country::all();
        $divisions = Division::all();
        return view('admin.district.edit', compact('district', 'divisions', 'countryes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, District $district)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string',
            'division' => 'required|string',
        ]);

        $status = $request->has('status') ? 1 : 0;

        $district->name = $validatedData['name'];
        $district->country_id = $validatedData['country'];
        $district->division_id = $validatedData['division'];
        $district->status = $status;
        $district->save();

        return redirect()->route('admin.district.index')->with('success', 'District updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        $district->delete();

        return redirect()->route('admin.district.index')->with('success', 'District deleted successfully!');
    }
}
