<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{

    public function pricingPlan()
    {
        $packages = Package::where('status', 1)->get();
        return response()->json($packages);
    }


    public function show($id)
    {
        $package = Package::find($id);
        return response()->json($package);
    }
}
