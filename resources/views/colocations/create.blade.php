<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer une colocation
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('colocations.store') }}">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nom</label>

                        <input
                            name="name"
                            value="{{ old('name') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            required
                        />

                        @error('name')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button class="px-4 py-2 bg-gray-900 text-black rounded">
                            Créer
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>