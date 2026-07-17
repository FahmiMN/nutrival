<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $users = User::where('role', 'user')
            ->when($q, fn ($query) => $query->where(fn ($sub) =>
                $sub->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%")
            ))
            ->withCount('foodLogs')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function toggle(User $user)
    {
        abort_if($user->isAdmin(), 403);
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', $user->is_active ? 'User diaktifkan.' : 'User dinonaktifkan.');
    }

    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 403);
        $user->delete();
        return back()->with('success', 'User dihapus.');
    }
}
