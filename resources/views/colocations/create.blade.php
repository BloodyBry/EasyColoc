<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Créer une colocation</h2>
            <p class="text-sm text-gray-500 mt-0.5">Configurez votre espace de colocation</p>
        </div>
    </x-slot>

    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); */
        .db-wrap { font-family: 'Inter', sans-serif; }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .form-label {
            display: block;
            font-size: 13.5px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            color: #111827;
            background: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .form-input::placeholder { color: #9ca3af; }

        .form-error {
            font-size: 12.5px;
            color: #e11d48;
            margin-top: 5px;
        }

        .btn-submit {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 24px;
            background: #111827;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            font-family: 'Inter', sans-serif;
        }
        .btn-submit:hover { background: #1f2937; }

        .btn-cancel {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 20px;
            background: #fff;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            font-family: 'Inter', sans-serif;
        }
        .btn-cancel:hover { background: #f9fafb; color: #374151; }
    </style>

    <div class="db-wrap py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="card sm:rounded-lg">

                {{-- Card Header --}}
                <div class="p-6 sm:px-8 sm:py-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <!-- <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg> -->
                        </div>
                        <div>
                            <p class="text-base sm:text-sm font-semibold text-gray-900">Nouvelle colocation</p>
                            <p class="text-sm sm:text-xs text-gray-500 sm:text-gray-400 mt-0.5 sm:mt-0">Donnez un nom à votre colocation</p>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('colocations.store') }}">
                    @csrf

                    <div class="p-6 sm:p-8 space-y-6">

                        <div>
                            <label class="form-label" for="name">
                                Nom de la colocation
                                <span class="text-red-400 ml-0.5">*</span>
                            </label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                placeholder="Ex : Appart Centre-Ville"
                                class="form-input"
                                required
                                autofocus
                            />
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="p-6 sm:px-8 sm:py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3 sm:gap-4">
                        <a href="{{ route('dashboard') }}" class="btn-cancel">
                            Annuler
                        </a>
                        <button type="submit" class="btn-submit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Créer la colocation
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
