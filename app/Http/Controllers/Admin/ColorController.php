<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    public function index()
    {
        $colors = Color::all();
        return view('admin.color.index', compact('colors'));
    }
    public function create()
    {
        return view('admin.color.create');
    }
}
