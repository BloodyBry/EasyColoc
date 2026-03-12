<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EasyColoc') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50 relative selection:bg-brand-500 selection:text-white">
        <!-- Abstract Background -->
        <div class="absolute inset-0 z-[-1] overflow-hidden bg-slate-50">
            <div class="absolute -top-[20%] -right-[10%] w-[70%] h-[70%] rounded-full bg-brand-100/50 blur-3xl opacity-60 mix-blend-multiply"></div>
            <div class="absolute top-[40%] -left-[10%] w-[60%] h-[60%] rounded-full bg-accent-100/50 blur-3xl opacity-60 mix-blend-multiply"></div>
            <div class="absolute -bottom-[20%] right-[20%] w-[50%] h-[50%] rounded-full bg-purple-100/50 blur-3xl opacity-60 mix-blend-multiply"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div class="mb-8 animate-fade-in">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-accent-500 flex items-center justify-center text-white font-heading font-bold text-2xl shadow-lg group-hover:shadow-brand-500/25 transition-all duration-300">
                        EC
                    </div>
                    <span class="font-heading font-bold text-2xl tracking-tight text-slate-800">EasyColoc</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-white/80 backdrop-blur-xl shadow-2xl shadow-slate-200/50 overflow-hidden sm:rounded-2xl border border-white flex flex-col gap-6 animate-slide-up">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-sm text-slate-500 animate-fade-in" style="animation-delay: 0.2s;">
                &copy; {{ date('Y') }} EasyColoc. All rights reserved.
            </p>
        </div>
    </body>
</html>
