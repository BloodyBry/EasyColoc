<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $colocation->name }}</h2>
                    @if($colocation->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                            {{ $colocation->status }}
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-0.5">Gérez votre colocation et vos colocataires</p>
            </div>

            <div class="flex items-center gap-3">
                @if($isOwner && $colocation->status === 'active')
                    <form method="POST" action="{{ route('colocations.cancel', $colocation) }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-600 text-sm font-medium rounded-8 rounded-lg hover:bg-red-50 transition"
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
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-orange-200 text-orange-600 text-sm font-medium rounded-lg hover:bg-orange-50 transition"
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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        .db-wrap { font-family: 'Inter', sans-serif; }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .nav-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px;
            border-radius: 9px;
            font-size: 13.5px; font-weight: 500;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
            transition: all 0.15s;
        }
        .nav-btn:hover { background: #f9fafb; border-color: #d1d5db; color: #111827; }
        .nav-btn .icon-wrap {
            width: 28px; height: 28px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .alert-ok {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #15803d; border-radius: 10px;
            padding: 13px 16px; font-size: 13.5px;
        }

        .member-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 24px;
            border-bottom: 1px solid #f3f4f6;
        }
        .member-row:last-child { border-bottom: none; }

        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; color: #fff;
            flex-shrink: 0;
        }

        .role-pill {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }
        .role-owner  { background: #eef2ff; color: #4f46e5; }
        .role-member { background: #f9fafb; color: #6b7280; border: 1px solid #e5e7eb; }
    </style>

    <div class="db-wrap pt-12 pb-8 sm:pt-16 sm:pb-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- Alert --}}
            @if(session('status'))
                <div class="alert-ok flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Quick Actions --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">

                <a href="{{ route('expenses.index', $colocation) }}" class="nav-btn">
                    <div class="icon-wrap bg-emerald-50">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Dépenses
                </a>

                <a href="{{ route('colocations.balances', $colocation) }}" class="nav-btn">
                    <div class="icon-wrap bg-amber-50">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    Balances
                </a>

                @if($isOwner)
                    <a href="{{ route('categories.index', $colocation) }}" class="nav-btn">
                        <div class="icon-wrap bg-blue-50">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        Catégories
                    </a>

                    <a href="{{ route('invitations.index', $colocation) }}" class="nav-btn">
                        <div class="icon-wrap bg-violet-50">
                            <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        Invitations
                    </a>
                @endif

            </div>

            {{-- Members --}}
            <div class="card">

                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Membres actifs</h3>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $members->count() }} membre(s) dans cette colocation</p>
                    </div>
                    <div class="flex -space-x-2">
                        @foreach($members->take(4) as $member)
                            <div class="avatar ring-2 ring-white" style="width:30px;height:30px;font-size:11px;">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    @foreach($members as $member)
                        <div class="member-row">
                            <div class="flex items-center gap-3">
                                <div class="avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                    <p class="text-xs text-gray-400" style="font-family: monospace;">{{ $member->email }}</p>
                                </div>
                            </div>
                            <span class="role-pill {{ $member->pivot->role === 'owner' ? 'role-owner' : 'role-member' }}">
                                {{ $member->pivot->role === 'owner' ? 'Propriétaire' : 'Membre' }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <p class="text-xs text-gray-400">
                        Propriétaire : <span class="font-medium text-gray-600">{{ $colocation->owner->name }}</span>
                    </p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
