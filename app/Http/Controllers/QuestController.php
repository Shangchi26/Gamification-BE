<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestProgess;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestController extends Controller
{
    //
    public function questProgess()
    {
        $userId = 1;

        $quests = Quest::all();

        $result = [];

        foreach ($quests as $quest) {
            $questId = $quest->id;

            $progress = QuestProgess::where('user_id', $userId)
                ->where('quest_id', $questId)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($quest->type == 'daily') {
                $isDone = $progress ? true : false;
                $progressCount = null;
                $maxCompletion = null;
            } elseif ($quest->type == 'one_time') {
                $isDone = $progress && $progress->point >= $quest->max_completion;
                $progressCount = $progressCount = QuestProgess::where('quest_id', $questId)->count();
                $maxCompletion = $quest->max_completion;
            } else {
                continue;
            }

            $result[] = [
                'quest_name' => $quest->name,
                'quest_type' => $quest->type,
                'is_done' => $isDone,
                'progress_count' => $progressCount,
                'max_completion' => $maxCompletion,
            ];
        }

        return response()->json(['quests' => $result]);
    }
    public function completeQuest(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $questId = $request->input('quest_id');

        // Lấy thông tin của quest
        $quest = Quest::findOrFail($questId);

        // Kiểm tra xem người dùng đã hoàn thành quest trong ngày chưa
        $dailyProgress = QuestProgess::where('user_id', $userId)
            ->where('quest_id', $questId)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($quest->type == 'daily') {
            if (!$dailyProgress) {
                // Chưa hoàn thành trong ngày, thêm dữ liệu vào bảng quest_progress
                QuestProgess::create([
                    'user_id' => $userId,
                    'quest_id' => $questId,
                    'point' => $quest->point,
                ]);

                // Cộng point của quest vào point của user
                $user = User::find($userId);
                $user->increment('point', $quest->point);
            } else {
                return response()->json(['message' => 'Nhiệm vụ đã được hoàn thành trước đó']);
            }
        } elseif ($quest->type == 'one_time') {
            // Kiểm tra số lần quest đã xuất hiện trong bảng quest_progress
            $progressCount = QuestProgess::where('quest_id', $questId)->count();

            if ($progressCount < $quest->max_completion) {
                // Chưa đạt max_completion, thêm dữ liệu vào bảng quest_progress
                QuestProgess::create([
                    'user_id' => $userId,
                    'quest_id' => $questId,
                    'point' => $quest->point,
                ]);

                // Cộng point của quest vào point của user
                $user = User::find($userId);
                $user->increment('point', $quest->point);
            } else {
                return response()->json(['message' => 'Nhiệm vụ đã được hoàn thành trước đó']);
            }
        }
        return response()->json(['message' => 'Hoàn tất nhiệm vụ']);
    }
}
