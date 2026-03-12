<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900">
                    Balances
                </h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm text-slate-500">Colocation:</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-50 text-brand-700">
                        {{ $colocation->name }}
                    </span>
                </div>
            </div>

            <a href="{{ route('colocations.show', $colocation) }}"
               class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-medium rounded-xl transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 animate-fade-in">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Résumé Card -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-slate-900">Résumé</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 sm:p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-600 font-medium">Total dépenses</span>
                        <span class="font-heading font-bold text-xl text-slate-900">{{ number_format($total, 2) }} €</span>
                    </div>
                    <div class="flex justify-between items-center p-3 sm:p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                        <span class="text-emerald-700 font-medium">Part par membre</span>
                        <span class="font-heading font-bold text-xl text-emerald-700">{{ number_format($share, 2) }} €</span>
                    </div>
                </div>
            </div>

            <!-- Soldes individuels Card -->
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-slate-900">Soldes individuels</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($balances as $b)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-3 gap-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                                    {{ strtoupper(substr($b['member']->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-slate-800">{{ $b['member']->name }}</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 sm:justify-end text-sm">
                                <span class="text-slate-500">Payé: <span class="font-medium text-slate-700">{{ number_format($b['paid'], 2) }} €</span></span>
                                <span class="text-slate-300 hidden sm:inline">|</span>
                                <span>Solde: 
                                    <span class="inline-flex items-center px-2 py-0.5 rounded font-bold ml-1 {{ $b['balance'] >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ number_format($b['balance'], 2) }} €
                                    </span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Qui doit à qui Card -->
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900">Règlements ("Qui doit à qui")</h3>
            </div>

            @if(empty($settlements))
                <div class="text-center p-8 bg-emerald-50 border border-emerald-100 rounded-xl">
                    <div class="w-12 h-12 mx-auto bg-emerald-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="font-heading font-bold text-emerald-800 text-lg">Tout est équilibré !</p>
                    <p class="text-emerald-600 mt-1">Aucun membre ne doit d'argent à un autre.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                    @foreach($settlements as $s)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 bg-slate-50/50 hover:bg-white transition-colors gap-4">
                            <div class="flex items-center flex-wrap gap-2 text-base text-slate-700">
                                <span class="font-bold text-slate-900">{{ $s['from']->name }}</span>
                                <span class="text-slate-400">doit</span>
                                <span class="font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">{{ number_format($s['amount'], 2) }} €</span>
                                <span class="text-slate-400">à</span>
                                <span class="font-bold text-emerald-600">{{ $s['to']->name }}</span>
                            </div>

                            @if(auth()->user()->is_global_admin || auth()->id() === $s['from']->id)
                                <form method="POST" action="{{ route('payments.store', $colocation) }}" class="flex-shrink-0 mt-2 md:mt-0">
                                    @csrf
                                    <input type="hidden" name="from_user_id" value="{{ $s['from']->id }}">
                                    <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                                    <input type="hidden" name="amount" value="{{ $s['amount'] }}">

                                    <button class="w-full md:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm"
                                            onclick="return confirm('Confirmer que ce paiement a bien été effectué ?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Marquer comme payé
                                    </button>
                                </form>
                            @else
                                <div class="text-slate-400 text-sm italic font-medium mt-2 md:mt-0 bg-slate-100 px-3 py-1 rounded inline-block">
                                    En attente de paiement
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>