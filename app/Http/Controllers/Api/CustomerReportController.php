<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use App\Models\CustomerReport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CustomerReportController extends Controller
{


    public function reportOrder(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'orderId' => 'required|exists:orders,id|unique:customer_reports,order_id',
            'email' => 'required|email',
            'phone' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Create the report in the customer_reports table
        $report = CustomerReport::create([
            'order_id' => $request->orderId,
            'email' => $request->email,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'message' => $request->message,
        ]);

        // Return success response
        return response()->json(['message' => 'Report submitted successfully!', 'data' => $report], 200);
    }
}
