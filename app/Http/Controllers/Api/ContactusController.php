<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class ContactusController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|exists:shops,id',
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $contact = Contactus::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Message sent successfully',
            'data' => $contact
        ]);
    }



    public function index(Request $request, $shop_id)
    {
        $query = Contactus::where('shop_id', $shop_id);

        // Search Filter (subject, name, email, phone, message)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        // Pagination (Default: 10 per page)
        $messages = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'status' => 200,
            'data' => $messages
        ]);
    }



    public function show($id)
    {
        $contact = Contactus::find($id);

        if (!$contact) {
            return response()->json(['error' => 'Contact not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $contact
        ]);
    }

    public function destroy($id)
{
    $contact = Contactus::find($id);

    if (!$contact) {
        return response()->json(['error' => 'Contact not found'], 404);
    }

    $contact->delete();

    return response()->json(['message' => 'Contact deleted successfully']);
}

}