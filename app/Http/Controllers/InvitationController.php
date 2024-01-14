<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    //
    public function invitation(Request $request)
    {
        $userId = 1;
        $user = User::find($userId);
        $exists = Invitation::where('receiver_id', $userId)->exists();
        if($exists) {
            return response()->json(['message' => 'Bạn đã nhập mã mời trước đó rồi']);
        }
        $inviteCode = $request->input('invite_code');
        if ($user->invite_code == $inviteCode) {
            return response()->json(['message' => 'Không thể nhập mã mời của bản thân']);
        }
        $sender = User::where('invite_code', $inviteCode)->first();
        if (!$sender) {
            return response()->json(['message' => 'Không tồn tại người dùng']);
        }
        Invitation::create([
            'sender_id' => $sender->id,
            'receiver_id' => $userId
        ]);
        $user->increment('point', 10);
        $sender->increment('point', 10);
        return response()->json(['message' => 'Hoàn tất']);
    }
}
