<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 2)->orderBy("id", "desc")->get();
        return view("admin.users.index", compact("users"));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view("admin.users.edit", compact("user"));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'country' => 'nullable',
            'city' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'email_verified_at' => $request->email_verified_at === 'on' ?  now() : null,
        ];


        $user->update($data);


        // Redirect back with success message
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with("success", "User deleted successfully");
    }
}
