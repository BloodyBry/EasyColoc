<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $colocation->name }}
                <span class="text-sm text-gray-500">({{ $colocation->status }})</span>
            </h2>

            <div class="flex gap-3">
                @if($isOwner && $colocation->status === 'active')
                    <form method="POST" action="{{ route('colocations.cancel', $colocation) }}">
                        @csrf
                        <button
                            class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow hover:bg-red-700 transition"
                            onclick="return confirm('Annuler la colocation ?')">
                            Annuler
                        </button>
                    </form>
                @endif

                @if(!$isOwner && $colocation->status === 'active')
                    <form method="POST" action="{{ route('colocations.leave', $colocation) }}">
                        @csrf
                        <button
                            class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow hover:bg-orange-600 transition"
                            onclick="return confirm('Quitter la colocation ?')">
                            Quitter
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Bouton Dépenses --}}
            <div class="mb-4 flex flex-wrap gap-3">
                <a href="{{ route('expenses.index', $colocation) }}"
                   class="inline-block px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                    Voir / Ajouter des dépenses
                </a>

                {{-- (optionnel) bouton catégories si tu l’as déjà --}}
                @if($isOwner)
                    <a href="{{ route('categories.index', $colocation) }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                        Gérer les catégories
                    </a>
                @endif

                @if($isOwner)
                    <a href="{{ route('invitations.index', $colocation) }}"
                    class="inline-block px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow hover:bg-purple-700 transition">
                        Invitations
                    </a>
                @endif
        
                @if($isOwner)
                <a href="{{ route('colocations.balances', $colocation) }}"
                    class="inline-block px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg shadow hover:bg-yellow-700 transition">
                        Voir balances
                </a>
                @endif
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-semibold text-lg mb-3">Membres actifs</h3>

                <ul class="space-y-2">
                    @foreach($members as $member)
                        <li class="flex justify-between border-b pb-2">
                            <span>{{ $member->name }} ({{ $member->email }})</span>
                            <span class="text-gray-600">{{ $member->pivot->role }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 text-sm text-gray-600">
                    Owner: {{ $colocation->owner->name }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>