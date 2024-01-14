<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\Reward;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    //
    public function openChest(Request $request)
    {
        $chestId = $request->input('chest_id');
        // Tìm chest trong inventory
        $chest = Inventory::where('chest_id', $chestId)
            ->where('status', 1)
            ->where('user_id', 1)
            ->first();

        if ($chest) {
            // Lấy thông tin của chest
            $chestInfo = $chest->chest;
            $chestType = $chestInfo->type;

            // Tìm các items có rank <= type của chest và qty > 0
            $items = Item::where('rank', '<=', $chestType)
                ->where('qty', '>', 0)
                ->get();

            $totalQty = $items->sum('qty');

            if ($totalQty > 0) {
                // Tạo một số ngẫu nhiên để chọn item
                $randomWeight = mt_rand(0, $totalQty);
                $cumulativeWeight = 0;

                foreach ($items as $item) {
                    $cumulativeWeight += $item->qty;

                    // Nếu randomWeight nằm trong khoảng itemWeight, chọn item đó
                    if ($randomWeight <= $cumulativeWeight) {
                        // Lưu thông tin reward vào bảng rewards
                        $reward = new Reward([
                            'user_id' => 1, // Thay bằng user_id thực tế
                            'item_id' => $item->id,
                        ]);
                        $reward->save();

                        // Giảm qty của item trong bảng items
                        $allowedItemNames = ['No Item', '1 Coin', '5 Coins', '10 Coins', '20 Coins'];

                        if (!in_array($item->name, $allowedItemNames)) {
                            $item->qty -= 1;
                        }
                        $item->save();

                        $chest->status = 0;
                        $chest->save();

                        return response()->json(['message' => 'Chest opened successfully.', 'item' => $item]);
                    }
                }
            } else {
                return response()->json(['message' => 'No valid items available.'], 400);
            }
        } else {
            return response()->json(['message' => 'Invalid chest or already opened.'], 400);
        }
    }

}
