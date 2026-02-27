<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->activeColocation()) {
            return back()->withErrors([
                'name' => 'Vous avez déjà une colocation active. Quittez-la avant d’en créer une autre.'
            ])->withInput();
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);

        $colocation = Colocation::create([
            'name' => $validated['name'],
            'status' => 'active',
            'owner_id' => Auth::id(),
        ]);

        $colocation->members()->attach(Auth::id(), [
            'role' => 'owner',
            'joined_at' => now(),
            'left_at' => null,
        ]);

        return redirect()->route('colocations.show', $colocation);
    }

    public function show(Colocation $colocation)
    {
        $user = Auth::user();

        $isMember = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivotNull('left_at')
            ->exists();

        if (!$user->is_global_admin && !$isMember) {
            abort(403);
        }

        $members = $colocation->members()
            ->wherePivotNull('left_at')
            ->get();

        $isOwner = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivot('role', 'owner')
            ->wherePivotNull('left_at')
            ->exists();

        return view('colocations.show', compact('colocation', 'members', 'isOwner'));
    }

    public function cancel(Colocation $colocation)
    {
        $user = Auth::user();

        $isOwner = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivot('role', 'owner')
            ->wherePivotNull('left_at')
            ->exists();

        if (!$user->is_global_admin && !$isOwner) {
            abort(403);
        }

        $colocation->update(['status' => 'cancelled']);

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('status', 'Colocation annulée.');
    }

}
