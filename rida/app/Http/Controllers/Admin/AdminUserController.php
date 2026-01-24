<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        // ما نخلي الأدمن يزيل صلاحية نفسه بالغلط
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own admin role.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return back()->with('success', 'User role updated ✅');
    }
}
