<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invitations — {{ $colocation->name }}
            </h2>

            <a href="{{ route('colocations.show', $colocation) }}"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <form method="POST" action="{{ route('invitations.store', $colocation) }}">
                    @csrf
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Créer une invitation (lien)
                    </button>
                </form>
                <p class="text-sm text-gray-600 mt-3">
                    Copie le lien généré et envoie-le à ton ami.
                </p>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-semibold mb-3">Historique</h3>
                @if($invitations->isEmpty())
                    <p class="text-gray-600">Aucune invitation.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($invitations as $inv)
                            <li class="border-b pb-2 text-sm">
                                <div>Token: <span class="font-mono">{{ $inv->token }}</span></div>
                                <div>Status: <b>{{ $inv->status }}</b></div>
                                <div>Expire: {{ $inv->expires_at }}</div>
                                <div>Lien: <span class="font-mono">{{ route('invitations.acceptForm', $inv->token) }}</span></div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>