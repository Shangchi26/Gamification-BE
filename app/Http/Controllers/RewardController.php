<?php

namespace App\Http\Controllers;

use App\Models\Reward;

class RewardController extends Controller
{
    //
    public function listWinner()
    {
        $list = Reward::join('items', 'rewards.item_id', '=', 'items.id')
            ->join('users', 'rewards.user_id', '=', 'users.id')
            ->select('users.name as user_name', 'items.name as item_name', 'items.rank', 'rewards.status')
            ->orderByDesc('items.rank')
            ->get(10);

        return response()->json(['list' => $list]);
    }
}
