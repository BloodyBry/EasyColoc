<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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

        $categories = $colocation->categories()->orderBy('name')->get();

        return view('categories.index', compact('colocation', 'categories'));
    }

    public function store(Request $request, Colocation $colocation)
    {
        $this->ensureOwner($colocation);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60'],
        ]);

        Category::create([
            'colocation_id' => $colocation->id,
            'name' => $validated['name'],
        ]);

        return back()->with('status', 'Catégorie ajoutée.');
    }

    public function destroy(Colocation $colocation, Category $category)
    {
        $this->ensureOwner($colocation);

        if ($category->colocation_id !== $colocation->id) {
            abort(404);
        }

        $category->delete();

        return back()->with('status', 'Catégorie supprimée.');
    }
}