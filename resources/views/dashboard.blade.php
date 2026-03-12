<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-heading font-bold text-slate-900">Tableau de bord</h2>
                <p class="text-sm text-slate-500 mt-1">Bienvenue, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </x-slot>

    @php $activeColoc = auth()->user()->activeColocation(); @endphp

    <div class="space-y-8 animate-fade-in">
        {{-- Alert --}}
        @if(session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        {{-- Main Card --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                
                <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        Ma colocation
                    </div>

                    @if(!$activeColoc)
                        <h3 class="text-2xl font-heading font-bold text-slate-900">Vous n'avez pas encore de colocation</h3>
                        <p class="text-base text-slate-500 max-w-md leading-relaxed">
                            Créez votre première colocation pour commencer à gérer vos dépenses et paiements avec vos colocataires.
                        </p>
                    @else
                        <h3 class="text-2xl font-heading font-bold text-slate-900">{{ $activeColoc->name ?? 'Ma colocation' }}</h3>
                        <p class="text-base text-slate-500">Votre colocation est active. Gérez vos dépenses et suivez les paiements.</p>
                        <div class="flex items-center gap-2 pt-2">
                            <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <span class="text-sm font-semibold text-emerald-600">Active</span>
                        </div>
                    @endif
                </div>

                <div class="flex-shrink-0">
                    @if(!$activeColoc)
                        <a href="{{ route('colocations.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white font-medium rounded-xl transition-all shadow-sm hover:shadow-brand-500/30 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Créer une colocation
                        </a>
                    @else
                        <a href="{{ route('colocations.show', $activeColoc) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-xl transition-all shadow-sm hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Voir ma colocation
                        </a>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
