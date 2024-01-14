<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function showAdminLoginForm()
    {
        if (Auth::user()) {
            return view('pages.dashboard');
        }
        return view('pages.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->is_admin) {
                return redirect()->intended('/admin/dashboard');
            } else {
                Auth::logout();
                return back()->withInput()->withErrors(['phone' => 'Tài khoản không có quyền truy cập.']);
            }
        }

        return back()->withInput()->withErrors(['phone' => 'Đăng nhập không thành công.']);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function userManage()
    {
        $users = User::paginate(10);
        $invitations = Invitation::with(['sender', 'receiver'])->paginate(10);
        foreach ($invitations as $item) {
            $item->formatted_created_at = $this->formatTime($item->created_at);
        }
        return view('pages.user_manage', compact('users', 'invitations'));
    }
    private function formatTime($timestamp)
    {
        $timeAgo = \Carbon\Carbon::parse($timestamp)->diffForHumans();

        return $timeAgo;
    }
    public function banUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with(['error' => 'User not found']);
        }
        if ($user->is_admin) {
            return redirect()->back()->with(['error' => 'Cannot ban admin']);
        }
        if ($user->is_banned) {
            return redirect()->back()->with(['error' => 'User was banned']);
        }
        $user->is_banned = 1;
        $user->save();
        return redirect()->back()->with(['success' => 'Banned user successfully']);
    }
    public function unbanUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with(['error' => 'User not found']);
        }
        if (!$user->is_banned) {
            return redirect()->back()->with(['error' => 'User was banned']);
        }
        $user->is_banned = 0;
        $user->save();
        return redirect()->back()->with(['success' => 'Unbanned user successfully']);
    }
}
