<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Color::all();
        return view('admin.product.index', compact('products'));
    }
    public function create()
    {
        return view('admin.product.create');
    }
}
