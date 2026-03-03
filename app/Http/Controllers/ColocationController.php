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

    public function leave(Colocation $colocation)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $isActiveMember = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivotNull('left_at')
            ->exists();

        if (!$user->is_global_admin && !$isActiveMember) {
            abort(403);
        }

        $isOwner = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivot('role', 'owner')
            ->wherePivotNull('left_at')
            ->exists();

        if ($isOwner) {
            return back()->withErrors([
                'leave' => "Le owner ne peut pas quitter. Il doit annuler la colocation."
            ]);
        }

        $colocation->members()->updateExistingPivot($user->id, [
            'left_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('status', 'Vous avez quitté la colocation.');
    }


    public function balances(Colocation $colocation)
    {
        // $user = auth()->user();
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

        $expenses = $colocation->expenses;
        $payments = $colocation->payments()->get();

        $total = $expenses->sum('amount');
        $memberCount = $members->count();

        $share = $memberCount > 0 ? $total / $memberCount : 0;

        $balances = [];

        foreach ($members as $member) {
            $paid = $expenses
                ->where('payer_id', $member->id)
                ->sum('amount');

            $balances[] = [
                'member' => $member,
                'paid' => $paid,
                'balance' => $paid - $share
            ];
        }

        foreach ($payments as $p) {
            foreach ($balances as &$b) {
                if ($b['member']->id === $p->from_user_id) {
                    $b['balance'] += (float) $p->amount;
                }
                if ($b['member']->id === $p->to_user_id) {
                    $b['balance'] -= (float) $p->amount;
                }
            }
            unset($b);
        }

        $debtors = collect($balances)->filter(fn($b) => $b['balance'] < 0);
        $creditors = collect($balances)->filter(fn($b) => $b['balance'] > 0);

        $settlements = [];

        foreach ($debtors as $debtor) {
            foreach ($creditors as $creditor) {

                if ($debtor['balance'] == 0) break;
                if ($creditor['balance'] == 0) continue;

                $amount = min(
                    abs($debtor['balance']),
                    $creditor['balance']
                );

                $settlements[] = [
                    'from' => $debtor['member'],
                    'to' => $creditor['member'],
                    'amount' => $amount
                ];

                $debtor['balance'] += $amount;
                $creditor['balance'] -= $amount;
            }
        }

        return view('colocations.balances', compact(
            'colocation',
            'balances',
            'settlements',
            'total',
            'share'
        ));
    }

}
