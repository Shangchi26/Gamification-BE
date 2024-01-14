<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    //
    public function claimChest(Request $request)
    {
        $user = Auth::user();
        if (!Auth::check()) {
            return response(['message' => 'Unauthorized'], 401);
        }

        $inventory = new Inventory;
        $inventory->user_id = $user->id;
        $inventory->chest_id = $request->input("chest_id");
        $inventory->save();

        return response(['message' => 'Thành công'], 200);
    }
    public function checkChestExistence($id)
    {
        if (!Auth::check()) {
            return response(['message' => 'Unauthorized'], 401);
        }
        $exists = Inventory::where('chest_id', $id)
            ->where('user_id', Auth::user()->id)
            ->exists();

        return $exists;
    }
    public function inventories()
    {
        $user = Auth::user();
        $userId = $user->id;
        $inventories = DB::table('chests')
            ->leftJoin('inventories', function ($join) use ($userId) {
                $join->on('chests.id', '=', 'inventories.chest_id')
                    ->where('inventories.user_id', '=', $userId)
                    ->where('inventories.status', '=', 1);
            })
            ->select('chests.name', 'chests.image', DB::raw('IFNULL(COUNT(inventories.chest_id), 0) as chest_count'))
            ->groupBy('chests.name', 'chests.image')
            ->get();

        return response()->json(['inventories' => $inventories]);
    }
}
