<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin — Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">
                    @foreach($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Utilisateurs</div>
                    <div class="text-2xl font-bold">{{ $stats['users'] }}</div>
                    <div class="text-sm text-red-600 mt-1">Bannis: {{ $stats['banned_users'] }}</div>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Colocations</div>
                    <div class="text-2xl font-bold">{{ $stats['colocations'] }}</div>
                    <div class="text-sm text-green-700 mt-1">Actives: {{ $stats['active_colocations'] }}</div>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Activité</div>
                    <div class="text-sm mt-2">Dépenses : <b>{{ $stats['expenses'] }}</b></div>
                    <div class="text-sm">Paiements : <b>{{ $stats['payments'] }}</b></div>
                </div>
            </div>

            {{-- Users --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-4">Utilisateurs</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600">
                            <tr>
                                <th class="py-2">Nom</th>
                                <th>Email</th>
                                <th>Admin</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr class="border-t">
                                    <td class="py-2">{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->is_global_admin ? 'Oui' : 'Non' }}</td>
                                    <td>
                                        @if($u->banned_at)
                                            <span class="text-red-600 font-semibold">Banni</span>
                                        @else
                                            <span class="text-green-700 font-semibold">Actif</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if(!$u->is_global_admin)
                                            @if(!$u->banned_at)
                                                <form method="POST" action="{{ route('admin.users.ban', $u) }}" class="inline">
                                                    @csrf
                                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                                            onclick="return confirm('Bannir cet utilisateur ?')">
                                                        Bannir
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.unban', $u) }}" class="inline">
                                                    @csrf
                                                    <button class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                                            onclick="return confirm('Débannir cet utilisateur ?')">
                                                        Débannir
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="text-xs text-gray-500 mt-4">
                    Note: Un utilisateur banni est automatiquement déconnecté par ton middleware EnsureUserNotBanned.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>