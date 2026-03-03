<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Dashboard</h2>
                <p class="text-sm text-gray-500 mt-0.5">Vue d'ensemble de la plateforme</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                Système opérationnel
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        .db-wrap { font-family: 'Inter', sans-serif; }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            transition: box-shadow 0.15s ease;
        }
        .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }

        .stat-label { font-size: 13px; font-weight: 500; color: #6b7280; }
        .stat-value { font-size: 32px; font-weight: 700; color: #111827; line-height: 1.1; margin: 8px 0 12px; }
        .stat-sub   { font-size: 12.5px; color: #6b7280; }

        .pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }
        .pill-red    { background: #fff1f2; color: #e11d48; }
        .pill-green  { background: #f0fdf4; color: #16a34a; }
        .pill-blue   { background: #eff6ff; color: #2563eb; }
        .pill-gray   { background: #f9fafb; color: #6b7280; border: 1px solid #e5e7eb; }
        .pill-indigo { background: #eef2ff; color: #4f46e5; }

        .table-wrap {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }
        .table-wrap table { width: 100%; border-collapse: collapse; }
        .table-wrap thead th {
            background: #f9fafb;
            padding: 11px 20px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #9ca3af;
            border-bottom: 1px solid #e5e7eb;
        }
        .table-wrap tbody td {
            padding: 15px 20px;
            font-size: 13.5px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }
        .table-wrap tbody tr:last-child td { border-bottom: none; }
        .table-wrap tbody tr:hover td { background: #fafafa; }

        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; color: #fff;
            flex-shrink: 0;
        }

        .btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 14px; border-radius: 7px;
            font-size: 12.5px; font-weight: 500;
            border: 1px solid transparent;
            cursor: pointer; transition: all 0.15s;
            white-space: nowrap;
        }
        .btn-danger  { background: #fff1f2; color: #e11d48; border-color: #fecdd3; }
        .btn-danger:hover  { background: #e11d48; color: #fff; border-color: #e11d48; }
        .btn-primary { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
        .btn-primary:hover { background: #2563eb; color: #fff; border-color: #2563eb; }

        .alert-ok  { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; border-radius:10px; padding:13px 16px; font-size:13.5px; }
        .alert-err { background:#fff1f2; border:1px solid #fecdd3; color:#be123c; border-radius:10px; padding:13px 16px; font-size:13.5px; }

        .kpi-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
    </style>

    <div class="db-wrap pt-12 pb-8 sm:pt-16 sm:pb-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- Alerts --}}
            @if(session('status'))
                <div class="alert-ok flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert-err space-y-1">
                    @foreach($errors->all() as $err)
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $err }}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-1">
                        <span class="stat-label">Utilisateurs</span>
                        <div class="kpi-icon bg-violet-50">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $stats['users'] }}</div>
                    <div class="flex items-center gap-2">
                        <span class="pill pill-red">{{ $stats['banned_users'] }} bannis</span>
                        <span class="stat-sub">au total</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-1">
                        <span class="stat-label">Colocations</span>
                        <div class="kpi-icon bg-emerald-50">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $stats['colocations'] }}</div>
                    <div class="flex items-center gap-2">
                        <span class="pill pill-green">{{ $stats['active_colocations'] }} actives</span>
                        <span class="stat-sub">en ce moment</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-1">
                        <span class="stat-label">Activité</span>
                        <div class="kpi-icon bg-amber-50">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $stats['expenses'] + $stats['payments'] }}</div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="stat-sub">Dépenses : <strong class="text-gray-800">{{ $stats['expenses'] }}</strong></span>
                        <span class="text-gray-300">·</span>
                        <span class="stat-sub">Paiements : <strong class="text-gray-800">{{ $stats['payments'] }}</strong></span>
                    </div>
                </div>

            </div>

            {{-- Users Table --}}
            <div class="table-wrap">

                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Gestion des utilisateurs</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Gérer les comptes, rôles et accès</p>
                    </div>
                    <span class="pill pill-gray">{{ $stats['users'] }} membres</span>
                </div>

                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th style="text-align:right; padding-right:24px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                            <span class="font-medium text-gray-900">{{ $u->name }}</span>
                                        </div>
                                    </td>
                                    <td style="font-family: 'Courier New', monospace; font-size: 12.5px; color: #9ca3af;">
                                        {{ $u->email }}
                                    </td>
                                    <td>
                                        @if($u->is_global_admin)
                                            <span class="pill pill-indigo">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                Admin
                                            </span>
                                        @else
                                            <span class="pill pill-gray">Membre</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($u->banned_at)
                                            <span class="pill pill-red">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>
                                                Banni
                                            </span>
                                        @else
                                            <span class="pill pill-green">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                                                Actif
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align:right; padding-right:24px;">
                                        @if(!$u->is_global_admin)
                                            @if(!$u->banned_at)
                                                <form method="POST" action="{{ route('admin.users.ban', $u) }}" class="inline">
                                                    @csrf
                                                    <button class="btn btn-danger" onclick="return confirm('Bannir cet utilisateur ?')">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                        Bannir
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.unban', $u) }}" class="inline">
                                                    @csrf
                                                    <button class="btn btn-primary" onclick="return confirm('Débannir cet utilisateur ?')">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Débannir
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-gray-300 text-sm">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <span class="text-xs text-gray-400">{{ count($users) }} utilisateur(s) au total</span>
                    <span class="text-xs text-gray-400">Mis à jour le {{ now()->format('d/m/Y à H:i') }}</span>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
