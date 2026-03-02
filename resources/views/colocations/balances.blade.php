<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Balances — {{ $colocation->name }}
            </h2>

            <a href="{{ route('colocations.show', $colocation) }}"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-3">Résumé</h3>
                <p>Total dépenses : <b>{{ number_format($total, 2) }} €</b></p>
                <p>Part par membre : <b>{{ number_format($share, 2) }} €</b></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-3">Soldes individuels</h3>

                @foreach($balances as $b)
                    <div class="flex justify-between border-b py-2">
                        <span>{{ $b['member']->name }}</span>
                        <span>
                            Payé: {{ number_format($b['paid'], 2) }} € |
                            Solde:
                            <b class="{{ $b['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($b['balance'], 2) }} €
                            </b>
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-3">Qui doit à qui</h3>

                @if(empty($settlements))
                    <p class="text-green-600">Tout est équilibré</p>
                @else
                    @foreach($settlements as $s)
                        <div class="border-b py-2 flex items-center justify-between gap-3">
                            <p>
                                <b>{{ $s['from']->name }}</b>
                                doit
                                <b>{{ number_format($s['amount'], 2) }} €</b>
                                à
                                <b>{{ $s['to']->name }}</b>
                            </p>

                            @if(auth()->user()->is_global_admin || auth()->id() === $s['from']->id)
                                <form method="POST" action="{{ route('payments.store', $colocation) }}">
                                    @csrf
                                    <input type="hidden" name="from_user_id" value="{{ $s['from']->id }}">
                                    <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                                    <input type="hidden" name="amount" value="{{ $s['amount'] }}">

                                    <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition"
                                            onclick="return confirm('Confirmer le paiement ?')">
                                        Marquer payé
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</x-app-layout>