<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    //
    public function packageManage()
    {
        $packages = Package::all();

        $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('packages', 'orders.package_id', '=', 'packages.id')
            ->select('orders.*', 'users.name as user_name', 'packages.point as package_point')
            ->orderByDesc('created_at')->paginate(10);
        foreach ($orders as $item) {
            $item->formatted_created_at = $this->formatTime($item->created_at);
        }

        return view('pages.package_manage', compact('packages', 'orders'));
    }
    private function formatTime($timestamp)
    {
        $timeAgo = \Carbon\Carbon::parse($timestamp)->diffForHumans();

        return $timeAgo;
    }
    public function createPackageForm(Request $request)
    {
        return view('pages.create_package');
    }public function createPackage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'point' => 'required|integer',
            'price' => 'required|numeric|between:0,9999999.99',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $package = new Package([
            'point' => $request->input('point'),
            'price' => $request->input('price'),
        ]);
        $package->save();
        return redirect('/admin/package-manage')->with(['success' => 'Package created successfully']);
    }
    public function packageDetail($id)
    {
        $package = Package::find($id);
        return view('pages.package_detail', compact('package'));
    }
    public function updatePackageForm($id)
    {
        $package = Package::find($id);
        return view('pages.package_update', compact('package'));
    }
    public function updatePackage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'point' => 'required|integer',
            'price' => 'required|numeric|between:0,9999999.99',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $package = Package::find($id);
        $package->point = $request->input('point');
        $package->price = $request->input('price');
        $package->save();
        return redirect('/admin/package-manage')->with(['success' => 'Package update successfully'])->withInput();
    }
    public function deletePackage($id)
    {
        $package = Package::find($id);
        if (!$package) {
            return redirect()->back()->with(['error' => 'Package not found']);
        }
        $orderExists = Order::where('package_id', $id)->exists();
        if ($orderExists) {
            return redirect()->back()->with(['error' => 'Cannot delete this package!']);
        }
        $package->delete();
        return redirect()->back()->with(['success' => 'Delete successfully']);
    }
}
