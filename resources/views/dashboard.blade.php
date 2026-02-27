<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @php
                        $activeColoc = auth()->user()->activeColocation();
                    @endphp

                    <p class="mb-4">
                        {{ __("You're logged in!") }}
                    </p>

                    @if(session('status'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="flex flex-wrap gap-4">
                        @if(!$activeColoc)
                            <a href="{{ route('colocations.create') }}"
                            class="px-5 py-2 bg-blue-600 text-black font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                                Créer une colocation
                            </a>
                        @else
                            <a href="{{ route('colocations.show', $activeColoc) }}"
                            class="px-5 py-2 bg-green-600 text-black font-semibold rounded-lg shadow hover:bg-green-700 transition">
                                Aller à ma colocation
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>