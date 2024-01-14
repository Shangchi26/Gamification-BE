<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quest;
use App\Models\QuestProgess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestController extends Controller
{
    //
    public function questManage()
    {
        $quests = Quest::all();
        $progess = QuestProgess::join('users', 'quest_progess.user_id', '=', 'users.id')
            ->join('quests', 'quest_progess.quest_id', '=', 'quests.id')
            ->select('quest_progess.*', 'users.name as user_name', 'quests.name as quest_name')
            ->orderByDesc('created_at')->paginate(10);
        foreach ($progess as $item) {
            $item->formatted_created_at = $this->formatTime($item->created_at);
        }

        return view('pages.quest_manage', compact('quests', 'progess'));
    }
    private function formatTime($timestamp)
    {
        $timeAgo = \Carbon\Carbon::parse($timestamp)->diffForHumans();

        return $timeAgo;
    }
    public function createQuestForm()
    {
        return view('pages.create_quest');
    }
    public function createQuest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'type' => 'required|in:daily,one_time',
            'max_completion' => 'required|integer|min:0',
            'point' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $quest = new Quest([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'max_completion' => $request->input('max_completion'),
            'point' => $request->input('point'),
        ]);
        $quest->save();
        return redirect('/admin/quest-manage')->with(['success' => 'Quest created successfully']);
    }
    public function deleteQuest($id)
    {
        $quest = Quest::find($id);
        if (!$quest) {
            return redirect()->back()->with(['error' => 'Quest not found']);
        }
        $questExists = QuestProgess::where('quest_id', $id)->exists();
        if ($questExists) {
            return redirect()->back()->with(['error' => 'Cannot delete this quest!']);
        }
        $quest->delete();
        return redirect()->back()->with(['success' => 'Delete successfully']);
    }
    public function updateQuestForm($id)
    {
        $quest = Quest::find($id);
        if (!$quest) {
            return redirect()->back()->with(['error' => 'Quest not found']);
        }
        return view('pages.update_quest', compact('quest'));
    }
    public function updateQuest(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'type' => 'required|in:daily,one_time',
            'max_completion' => 'required|integer|min:0',
            'point' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $quest = Quest::find($id);
        $quest->name = $request->input('name');
        $quest->type = $request->input('type');
        $quest->max_completion = $request->input('max_completion');
        $quest->point = $request->input('point');
        $quest->save();
        return redirect('/admin/quest-manage')->with(['success' => 'Quest update successfully'])->withInput();
    }
}
