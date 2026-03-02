<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dépenses — {{ $colocation->name }}
            </h2>

            <a href="{{ route('colocations.show', $colocation) }}"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Filtre mois --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <form method="GET" action="{{ route('expenses.index', $colocation) }}" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Filtrer par mois</label>
                        <select name="month" class="mt-1 border-gray-300 rounded-md">
                            <option value="">Tous les mois</option>
                            @foreach($availableMonths as $m)
                                <option value="{{ $m }}" @selected($month === $m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                        Filtrer
                    </button>

                    @if($month)
                        <a href="{{ route('expenses.index', $colocation) }}"
                           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>

            {{-- Ajouter dépense --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="font-semibold mb-3">Ajouter une dépense</h3>

                <form method="POST" action="{{ route('expenses.store', $colocation) }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input name="title" value="{{ old('title') }}" required
                               class="mt-1 w-full border-gray-300 rounded-md" placeholder="Ex: Courses Carrefour">
                        @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Montant</label>
                        <input name="amount" value="{{ old('amount') }}" required type="number" step="0.01" min="0.01"
                               class="mt-1 w-full border-gray-300 rounded-md" placeholder="0.00">
                        @error('amount') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input name="spent_at" value="{{ old('spent_at', date('Y-m-d')) }}" required type="date"
                               class="mt-1 w-full border-gray-300 rounded-md">
                        @error('spent_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category_id" class="mt-1 w-full border-gray-300 rounded-md" required>
                            <option value="">Choisir...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 flex items-end">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>

            {{-- Liste dépenses --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-semibold mb-3">Liste des dépenses</h3>

                @if($expenses->isEmpty())
                    <p class="text-gray-600">Aucune dépense pour le moment.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600">
                                <tr>
                                    <th class="py-2">Date</th>
                                    <th>Titre</th>
                                    <th>Catégorie</th>
                                    <th>Payeur</th>
                                    <th class="text-right">Montant</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $e)
                                    <tr class="border-t">
                                        <td class="py-2">{{ $e->spent_at }}</td>
                                        <td>{{ $e->title }}</td>
                                        <td>{{ $e->category->name }}</td>
                                        <td>{{ $e->payer->name }}</td>
                                        <td class="text-right">{{ number_format($e->amount, 2) }}</td>
                                        <td class="text-right">
                                            @if(auth()->user()->is_global_admin || $e->payer_id === auth()->id())
                                                <form method="POST" action="{{ route('expenses.destroy', [$colocation, $e]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                                            onclick="return confirm('Supprimer cette dépense ?')">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>