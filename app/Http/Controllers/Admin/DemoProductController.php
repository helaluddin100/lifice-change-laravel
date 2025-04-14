<?php

namespace App\Http\Controllers\Admin;

use App\Models\DemoSize;
use App\Models\DemoColor;
use App\Models\DemoProduct;
use App\Models\DemoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessType;

class DemoProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DemoProduct::all();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $businessTypes = BusinessType::all();
        $categories = DemoCategory::where('status', 1)->get();
        $colors = DemoColor::where('status', 1)->get();
        $sizes = DemoSize::where('status', 1)->get();

        return view('admin.product.create', compact('categories', 'colors', 'sizes', 'businessTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemoProduct  $demoProduct
     * @return \Illuminate\Http\Response
     */
    public function show(DemoProduct $demoProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DemoProduct  $demoProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(DemoProduct $demoProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemoProduct  $demoProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemoProduct $demoProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemoProduct  $demoProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemoProduct $demoProduct)
    {
        //
    }
}
