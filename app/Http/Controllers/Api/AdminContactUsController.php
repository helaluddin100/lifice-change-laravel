<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\AdminContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AdminContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Remove the shop_id validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'not_regex:/@(tempmail|mailinator|guerrillamail|dispostable|10minutemail|yopmail)\./i',
            ],
            'phone' => 'required|digits:11',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // If validation fails, return error
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ], 400);
        }

        // Save the data to the database
        $contact = AdminContactUs::create($request->all());

        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Message sent successfully',
            'data' => $contact
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminContactUs  $adminContactUs
     * @return \Illuminate\Http\Response
     */
    public function show(AdminContactUs $adminContactUs)
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
