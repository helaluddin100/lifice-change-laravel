<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminContactUs;
use Illuminate\Http\Request;

class AdminContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = AdminContactUs::all();
        return view('admin.contact_us.index', compact('contacts'));
    }
    public function show($id)
    {
        // Find the contact by ID
        $contact = AdminContactUs::find($id);

        // If the contact doesn't exist, return an error message
        if (!$contact) {
            return redirect()->route('admin.contact.index')->with('error', 'Contact not found');
        }

        // **Update Status to 1 (Mark as Read)**
        $contact->update(['status' => 1]);

        // Return the contact view with the contact data
        return view('admin.contact_us.view', compact('contact'))->with('success', 'Contact View successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminContactUs  $adminContactUs
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminContactUs $adminContactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminContactUs  $adminContactUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminContactUs $adminContactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminContactUs  $adminContactUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminContactUs $adminContactUs)
    {
        //
    }
}
