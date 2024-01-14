<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chest;
use App\Models\Inventory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChestController extends Controller
{
    //
    public function showAllChest()
    {
        $chests = Chest::all();

        $inventories = Inventory::join('users', 'inventories.user_id', '=', 'users.id')
            ->join('chests', 'inventories.chest_id', '=', 'chests.id')
            ->select(
                'inventories.*',
                'users.name as user_name',
                'chests.name as chest_name'
            )
            ->orderByDesc('inventories.created_at')
            ->paginate(10);

        // Định dạng thời gian
        foreach ($inventories as $item) {
            $item->formatted_created_at = $this->formatTime($item->created_at);
        }

        return view('pages.chest_manage', compact('chests', 'inventories'));
    }

    private function formatTime($timestamp)
    {
        $timeAgo = \Carbon\Carbon::parse($timestamp)->diffForHumans();

        return $timeAgo;
    }

    public function createChest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:chests|string|max:50',
            'image' => 'required|image|max:2048',
            'type' => 'required|in:1,2,3,4,5',
            'point' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $chest = new Chest([
            'name' => $request->input('name'),
            'image' => Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath(),
            'type' => $request->input('type'),
            'point' => $request->input('point'),
        ]);
        $chest->save();
        return redirect('/admin/chest-manage')->with(['success' => 'Create successfully!']);
    }
    public function createChestForm()
    {
        return view('pages.create_chest');
    }
    public function deleteChest($id)
    {
        $chest = Chest::find($id);
        if (!$chest) {
            return redirect()->back()->with(['error' => 'Chest not found']);
        }
        $inventoryExists = Inventory::where('chest_id', $id)->exists();
        if ($inventoryExists) {
            return redirect()->back()->with(['error' => 'Cannot delete this chest!']);
        }
        $chest->delete();
        return redirect()->back()->with(['success' => 'Delete successfully']);
    }
    public function updateChest(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'image' => 'required|image|max:2048',
            'type' => 'required|in:1,2,3,4,5',
            'point' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $chest = Chest::find($id);
        $chest->name = $request->input('name');
        $chest->image = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        $chest->type = $request->input('type');
        $chest->point = $request->input('point');
        $chest->save();
        return redirect('/admin/chest-manage')->with(['success' => 'Update successfully']);
    }
    public function updateChestForm($id)
    {
        $chest = Chest::find($id);
        return view('pages.update_chest', compact('chest'));
    }
    public function chestDetail($id)
    {
        $chest = Chest::find($id);
        return view('pages.chest_detail', compact('chest'));
    }
}
