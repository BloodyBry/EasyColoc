<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Tableau de bord</h2>
                <p class="text-sm text-gray-500 mt-0.5">Bienvenue, {{ auth()->user()->name }}</p>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        .db-wrap { font-family: 'Inter', sans-serif; }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 28px 32px;
            transition: box-shadow 0.15s ease;
        }
        .card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }

        .cta-btn {
            display: inline-flex; align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 14px; font-weight: 600;
            text-decoration: none;
            border: none; cursor: pointer;
            transition: all 0.15s;
        }
        .cta-blue  { background: #2563eb; color: #fff; }
        .cta-blue:hover  { background: #1d4ed8; }
        .cta-green { background: #16a34a; color: #fff; }
        .cta-green:hover { background: #15803d; }

        .alert-ok {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #15803d; border-radius: 10px;
            padding: 13px 16px; font-size: 13.5px;
        }

        .status-dot {
            width: 10px; height: 10px; border-radius: 50%; display: inline-block;
        }
    </style>

    @php $activeColoc = auth()->user()->activeColocation(); @endphp

    <div class="db-wrap py-14">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 pt-4">

            {{-- Alert --}}
            @if(session('status'))
                <div class="alert-ok flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Main Card --}}
            <div class="card">
                <div class="flex items-start justify-between flex-wrap gap-6">

                    <div class="space-y-2">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Ma colocation</p>

                        @if(!$activeColoc)
                            <h3 class="text-xl font-semibold text-gray-900">Vous n'avez pas encore de colocation</h3>
                            <p class="text-sm text-gray-500 max-w-sm">Créez votre première colocation pour commencer à gérer vos dépenses et paiements avec vos colocataires.</p>
                        @else
                            <h3 class="text-xl font-semibold text-gray-900">{{ $activeColoc->name ?? 'Ma colocation' }}</h3>
                            <p class="text-sm text-gray-500">Votre colocation est active. Gérez vos dépenses et suivez les paiements.</p>
                            <div class="flex items-center gap-2 pt-1">
                                <span class="status-dot bg-emerald-400"></span>
                                <span class="text-xs font-medium text-emerald-600">Active</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center">
                        @if(!$activeColoc)
                            <a href="{{ route('colocations.create') }}" class="cta-btn cta-blue">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Créer une colocation
                            </a>
                        @else
                            <a href="{{ route('colocations.show', $activeColoc) }}" class="cta-btn cta-green">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Voir ma colocation
                            </a>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
