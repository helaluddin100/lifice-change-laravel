<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Division;
use Illuminate\Support\Facades\Log;
use League\Config\Exception\ValidationException;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::with('country')->get();
        return view('admin.division.index', compact('divisions'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countryes = Country::all();
        return view('admin.division.create', compact('countryes'));
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
        ]);



        $status = $request->has('status') ? 1 : 0;

        // Create a new country instance
        $division = new Division();
        $division->name = $validatedData['name'];
        $division->country_id = $validatedData['country'];
        $division->status = $status;
        $division->save();

        // Redirect back with success message
        return redirect()->route('admin.division.index')->with('success', 'Division created successfully!');
    }


    public function edit($id)
    {
        $division = Division::find($id);
        $countryes = Country::all();
        return view('admin.division.edit', compact('division', 'countryes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Division $division)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string',


        ]);
        $status = $request->has('status') ? 1 : 0;

        $division->name = $validatedData['name'];
        $division->status = $status;
        $division->country_id = $validatedData['country'];

        $division->save();

        return redirect()->route('admin.division.index')->with('success', 'Division updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()->route('admin.division.index')->with('success', 'Division deleted successfully!');
    }
}
