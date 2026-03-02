<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
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

    public function index(Request $request, Colocation $colocation)
    {
        $this->ensureMember($colocation);

        $month = $request->query('month'); 
        $query = $colocation->expenses()->with(['payer', 'category'])->orderByDesc('spent_at');

        if ($month) {
            $query->whereRaw("DATE_FORMAT(spent_at, '%Y-%m') = ?", [$month]);
        }

        $expenses = $query->get();

        $availableMonths = $colocation->expenses()
            ->selectRaw("DATE_FORMAT(spent_at, '%Y-%m') as month")
            ->groupBy('month')
            ->orderByDesc('month')
            ->pluck('month');

        $categories = $colocation->categories()->orderBy('name')->get();

        return view('expenses.index', compact('colocation', 'expenses', 'categories', 'month', 'availableMonths'));
    }

    public function store(Request $request, Colocation $colocation)
    {
        $this->ensureMember($colocation);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'spent_at' => ['required', 'date'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $category = $colocation->categories()->where('id', $validated['category_id'])->first();
        if (!$category) {
            return back()->withErrors(['category_id' => 'Catégorie invalide pour cette colocation.'])->withInput();
        }

        Expense::create([
            'colocation_id' => $colocation->id,
            'payer_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'spent_at' => $validated['spent_at'],
        ]);

        return back()->with('status', 'Dépense ajoutée.');
    }

    public function destroy(Colocation $colocation, Expense $expense)
    {
        $this->ensureMember($colocation);

        if ($expense->colocation_id !== $colocation->id) {
            abort(404);
        }

        $user = Auth::user();
        if (!$user->is_global_admin && $expense->payer_id !== $user->id) {
            abort(403);
        }

        $expense->delete();

        return back()->with('status', 'Dépense supprimée.');
    }
}
