<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function showDashboard()
    {
        $data = [];

        for ($week = 0; $week <= 9; $week++) {
            $startOfWeek = Carbon::now()->subWeeks($week)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($week)->endOfWeek();

            $orderCount = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $totalPrice = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('price');
            $userCount = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

            $data[$week] = [
                'orderCount' => $orderCount,
                'totalPrice' => $totalPrice,
                'userCount' => $userCount,
            ];
        }

        return view('pages.dashboard', compact('data'));
    }
}
