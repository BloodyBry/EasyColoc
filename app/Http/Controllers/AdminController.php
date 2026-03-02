<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->is_global_admin) {
            abort(403);
        }

        $stats = [
            'users' => User::count(),
            'banned_users' => User::whereNotNull('banned_at')->count(),
            'colocations' => Colocation::count(),
            'active_colocations' => Colocation::where('status', 'active')->count(),
            'expenses' => Expense::count(),
            'payments' => Payment::count(),
        ];

        $users = User::orderByDesc('created_at')->get();

        return view('admin.index', compact('stats', 'users'));
    }

    public function ban(User $user)
    {
        $me = Auth::user();
        if (!$me || !$me->is_global_admin) abort(403);

        if ($user->is_global_admin) {
            return back()->withErrors(['ban' => 'Impossible de bannir un admin global.']);
        }

        $user->update(['banned_at' => now()]);
        return back()->with('status', 'Utilisateur banni');
    }

    public function unban(User $user)
    {
        $me = Auth::user();
        if (!$me || !$me->is_global_admin) abort(403);

        $user->update(['banned_at' => null]);
        return back()->with('status', 'Utilisateur débanni');
    }
}