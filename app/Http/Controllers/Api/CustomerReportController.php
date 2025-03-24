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
            'order_id' => 'required|exists:orders,id|unique:customer_reports,order_id', // Ensuring order_id exists in orders and is unique in customer_reports
            'email' => 'required|email',
            'phone' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'status' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $status = filter_var($validated['status'] ?? false, FILTER_VALIDATE_BOOLEAN);


        // Create the report in the customer_reports table
        $report = CustomerReport::create([
            'order_id' => $request->order_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'message' => $request->message,
            'status' => $status,
        ]);

        // Return success response
        return response()->json(['message' => 'Report submitted successfully!', 'data' => $report], 200);
    }

    // Method to view reports for a specific order
    public function viewReports($orderId)
    {
        // Fetch the reports for the provided order_id
        $reports = CustomerReport::with('order') // Eager load related order data
            ->where('order_id', $orderId)
            ->get();

        // If no reports found, return a message
        if ($reports->isEmpty()) {
            return response()->json(['message' => 'No reports found for this order.'], 404);
        }

        // Return the reports
        return response()->json(['reports' => $reports], 200);
    }
}
