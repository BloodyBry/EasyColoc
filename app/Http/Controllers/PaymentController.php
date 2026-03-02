<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private function ensureMember(Colocation $colocation): void
    {
        $user = Auth::user();

        $isMember = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivotNull('left_at')
            ->exists();

        if (!$user->is_global_admin && !$isMember) {
            abort(403);
        }
    }

    public function store(Request $request, Colocation $colocation)
    {
        $this->ensureMember($colocation);

        $validated = $request->validate([
            'from_user_id' => ['required', 'integer'],
            'to_user_id' => ['required', 'integer', 'different:from_user_id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $fromIsMember = $colocation->members()
            ->where('users.id', $validated['from_user_id'])
            ->wherePivotNull('left_at')
            ->exists();

        $toIsMember = $colocation->members()
            ->where('users.id', $validated['to_user_id'])
            ->wherePivotNull('left_at')
            ->exists();

        if (!$fromIsMember || !$toIsMember) {
            return back()->withErrors(['payment' => 'Paiement invalide (membres non valides).']);
        }

        $user = Auth::user();
        if (!$user->is_global_admin && (int)$validated['from_user_id'] !== (int)$user->id) {
            abort(403);
        }

        Payment::create([
            'colocation_id' => $colocation->id,
            'from_user_id' => $validated['from_user_id'],
            'to_user_id' => $validated['to_user_id'],
            'amount' => $validated['amount'],
            'paid_at' => now(),
        ]);

        return back()->with('status', 'Paiement enregistré ✅');
    }
}