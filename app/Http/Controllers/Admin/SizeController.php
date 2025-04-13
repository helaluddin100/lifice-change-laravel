<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{

    public function index()
    {
        $sizes = Size::all();
        return view('admin.size.index', compact('sizes'));
    }
    public function create()
    {
        return view('admin.size.create');
    }
}
