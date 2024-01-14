<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    //
    public function showAllPackages()
    {
        $packages = Package::all();
        return response()->json(['packages' => $packages]);
    }
    public function order(Request $request)
    {
        $user = Auth::user();
        $packageId = $request->input('package_id');
        $package = Package::find($packageId);
        Order::create([
            'user_id' => $user->id,
            'package_id' => $packageId,
            'price' => $package->price,
            'payment' =>$request->input('payment')
        ]);
        $user->increment('point', $package->point);
        return response()->json(['message' => 'Thành công']);
    }
}
