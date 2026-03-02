<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    private function ensureOwner(Colocation $colocation): void
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
    }

    public function index(Colocation $colocation)
    {
        $this->ensureOwner($colocation);

        $invitations = $colocation->invitations()->latest()->get();

        return view('invitations.index', compact('colocation', 'invitations'));
    }

    public function store(Colocation $colocation)
    {
        $this->ensureOwner($colocation);

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'token' => Str::random(40),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        return back()->with('status', 'Invitation créée : ' . route('invitations.acceptForm', $invitation->token));
    }

    public function acceptForm(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        return view('invitations.accept', compact('invitation'));
    }

    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $user = Auth::user();

        if ($invitation->status !== 'pending') {
            return redirect()->route('dashboard')->with('status', 'Invitation déjà utilisée.');
        }

        if ($invitation->expires_at && now()->greaterThan($invitation->expires_at)) {
            $invitation->update(['status' => 'expired']);
            return redirect()->route('dashboard')->with('status', 'Invitation expirée.');
        }

        if ($user->activeColocation()) {
            return redirect()->route('dashboard')
                ->withErrors(['invitation' => 'Vous avez déjà une colocation active.']);
        }

        $colocation = $invitation->colocation;

        $colocation->members()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now(),
            'left_at' => null,
        ]);

        $invitation->update(['status' => 'accepted']);

        return redirect()->route('colocations.show', $colocation)
            ->with('status', 'Bienvenue dans la colocation !');
    }
}