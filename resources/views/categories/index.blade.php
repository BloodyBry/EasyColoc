<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Catégories — {{ $colocation->name }}
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
                <h3 class="font-semibold mb-3">Ajouter une catégorie</h3>

                <form method="POST" action="{{ route('categories.store', $colocation) }}" class="flex gap-3">
                    @csrf
                    <input name="name" value="{{ old('name') }}"
                           class="w-full border-gray-300 rounded-md"
                           placeholder="Ex: Courses, Électricité..." required>

                    <button class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                        Ajouter
                    </button>
                </form>

                @error('name')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-semibold mb-3">Liste des catégories</h3>

                @if($categories->isEmpty())
                    <p class="text-gray-600">Aucune catégorie pour le moment.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                            <li class="flex items-center justify-between border-b pb-2">
                                <span>{{ $category->name }}</span>

                                <form method="POST" action="{{ route('categories.destroy', [$colocation, $category]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                            onclick="return confirm('Supprimer cette catégorie ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>