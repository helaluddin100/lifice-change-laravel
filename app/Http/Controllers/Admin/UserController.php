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
}
