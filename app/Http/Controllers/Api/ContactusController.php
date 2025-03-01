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




    public function index($shop_id)
    {
        $messages = Contactus::where('shop_id', $shop_id)->get();
        return response()->json($messages);
    }

    public function reply(Request $request, $id)
    {
        $message = Contactus::findOrFail($id);
        $message->reply = $request->reply;
        $message->save();

        Mail::raw($request->reply, function ($mail) use ($message) {
            $mail->to($message->email)
                 ->from($message->shop->email) // শপের ইমেইল থেকে পাঠাবে
                 ->subject('Reply to your message');
        });

        return response()->json(['message' => 'Reply Sent Successfully', 'data' => $message]);
    }
}