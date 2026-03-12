<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-heading font-bold text-slate-900">{{ $colocation->name }}</h2>
                    @if($colocation->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-slate-100 text-slate-500 border border-slate-200">
                            <span class="w-2 h-2 rounded-full bg-slate-400 inline-block"></span>
                            {{ $colocation->status }}
                        </span>
                    @endif
                </div>
                <p class="text-sm text-slate-500 mt-1">Gérez votre colocation et vos colocataires</p>
            </div>

            <div class="flex items-center gap-3">
                @if($isOwner && $colocation->status === 'active')
                    <form method="POST" action="{{ route('colocations.cancel', $colocation) }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-red-200 text-red-600 text-sm font-semibold rounded-xl hover:bg-red-50 hover:border-red-300 transition-colors shadow-sm"
                            onclick="return confirm('Annuler la colocation ?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Annuler la colocation
                        </button>
                    </form>
                @endif

                @if(!$isOwner && $colocation->status === 'active')
                    <form method="POST" action="{{ route('colocations.leave', $colocation) }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-amber-200 text-amber-600 text-sm font-semibold rounded-xl hover:bg-amber-50 hover:border-amber-300 transition-colors shadow-sm"
                            onclick="return confirm('Quitter la colocation ?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Quitter
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

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

        {{-- Quick Actions --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <a href="{{ route('expenses.index', $colocation) }}" class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl hover:border-brand-300 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-slate-900 group-hover:text-brand-700 transition-colors">Dépenses</h3>
                </div>
            </a>

            <a href="{{ route('colocations.balances', $colocation) }}" class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl hover:border-brand-300 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-slate-900 group-hover:text-brand-700 transition-colors">Balances</h3>
                </div>
            </a>

            @if($isOwner)
                <a href="{{ route('categories.index', $colocation) }}" class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl hover:border-brand-300 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center group-hover:bg-brand-100 transition-colors">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-slate-900 group-hover:text-brand-700 transition-colors">Catégories</h3>
                    </div>
                </a>

                <a href="{{ route('invitations.index', $colocation) }}" class="flex items-center gap-4 p-4 bg-white border border-slate-200 rounded-2xl hover:border-brand-300 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-slate-900 group-hover:text-brand-700 transition-colors">Invitations</h3>
                    </div>
                </a>
            @endif
        </div>

        {{-- Members --}}
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-heading font-bold text-slate-900">Membres actifs</h3>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $members->count() }} membre(s) dans cette colocation</p>
                </div>
                <div class="flex -space-x-2">
                    @foreach($members->take(4) as $member)
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-accent-500 ring-2 ring-white flex items-center justify-center text-xs font-bold text-white shadow-sm">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($members as $member)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-4 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-400 to-accent-500 flex items-center justify-center text-sm font-bold text-white shadow-sm flex-shrink-0">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">{{ $member->name }}</p>
                                <p class="text-sm text-slate-500">{{ $member->email }}</p>
                            </div>
                        </div>
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide {{ $member->pivot->role === 'owner' ? 'bg-brand-50 text-brand-700 border border-brand-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                {{ $member->pivot->role === 'owner' ? 'Propriétaire' : 'Membre' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                <p class="text-sm text-slate-500">
                    Propriétaire : <span class="font-semibold text-slate-700">{{ $colocation->owner->name }}</span>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
