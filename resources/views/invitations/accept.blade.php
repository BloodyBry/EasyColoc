<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rejoindre une colocation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <p class="mb-4">
                    Invitation pour rejoindre la colocation :
                    <b>{{ $invitation->colocation->name }}</b>
                </p>

                <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">
                    @csrf
                    <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Accepter et rejoindre
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>