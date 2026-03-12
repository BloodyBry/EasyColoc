<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'EasyColoc') }} - Find your perfect roommate</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50 selection:bg-brand-500 selection:text-white overflow-x-hidden">
        <!-- Navigation -->
        <nav class="absolute top-0 w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-accent-500 flex items-center justify-center text-white font-heading font-bold text-xl shadow-lg">
                            EC
                        </div>
                        <span class="font-heading font-bold text-2xl tracking-tight text-slate-800">EasyColoc</span>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-medium text-slate-600 hover:text-brand-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-slate-600 hover:text-brand-600 transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white rounded-xl font-heading font-medium text-sm transition-all shadow-sm hover:shadow-brand-500/30 hover:-translate-y-0.5">
                                    Sign Up Free
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative min-h-screen flex items-center pt-20 overflow-hidden">
            <!-- Background Decorations -->
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] rounded-full bg-brand-200/40 blur-3xl opacity-60 mix-blend-multiply pointer-events-none"></div>
            <div class="absolute top-[30%] -left-[10%] w-[40%] h-[40%] rounded-full bg-accent-200/40 blur-3xl opacity-60 mix-blend-multiply pointer-events-none"></div>
            <div class="absolute -bottom-[10%] right-[20%] w-[30%] h-[30%] rounded-full bg-purple-200/40 blur-3xl opacity-60 mix-blend-multiply pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="max-w-2xl animate-fade-in">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand-600 text-sm font-medium mb-6">
                            <span class="flex h-2 w-2 rounded-full bg-brand-500"></span>
                            The #1 Platform for Colocation
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-heading font-extrabold text-slate-900 leading-tight mb-6 tracking-tight">
                            Find your perfect <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-500">roommate</span> today.
                        </h1>
                        <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-xl">
                            Join thousands of students and young professionals finding their ideal shared living spaces. Safe, easy, and completely tailored to your lifestyle.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-8 py-4 bg-brand-600 hover:bg-brand-500 text-white rounded-2xl font-heading font-semibold text-lg transition-all shadow-lg hover:shadow-brand-500/30 hover:-translate-y-1">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 bg-brand-600 hover:bg-brand-500 text-white rounded-2xl font-heading font-semibold text-lg transition-all shadow-lg hover:shadow-brand-500/30 hover:-translate-y-1">
                                    Get Started Free
                                </a>
                                <a href="#features" class="inline-flex justify-center items-center px-8 py-4 bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 rounded-2xl font-heading font-semibold text-lg transition-all hover:shadow-md">
                                    Learn More
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-5xl font-heading font-bold text-slate-900 mb-4">Why choose EasyColoc?</h2>
                    <p class="text-lg text-slate-500">We make finding a roommate or a room as simple as possible.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-brand-100 flex items-center justify-center mb-6 group-hover:bg-brand-500 transition-colors">
                            <svg class="w-7 h-7 text-brand-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-slate-900 mb-3">Smart Search</h3>
                        <p class="text-slate-600">Find rooms and roommates that match your lifestyle, budget, and preferences with our advanced filtering.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-accent-100 flex items-center justify-center mb-6 group-hover:bg-accent-500 transition-colors">
                            <svg class="w-7 h-7 text-accent-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-slate-900 mb-3">Verified Users</h3>
                        <p class="text-slate-600">Safety is our priority. Profiles and listings go through verification so you can browse with peace of mind.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center mb-6 group-hover:bg-purple-500 transition-colors">
                            <svg class="w-7 h-7 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-slate-900 mb-3">Easy Messaging</h3>
                        <p class="text-slate-600">Connect instantly with potential roommates through our secure, built-in messaging system.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-900 py-12 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-accent-500 flex items-center justify-center text-white font-heading font-bold text-sm">
                        EC
                    </div>
                    <span class="font-heading font-bold text-xl tracking-tight text-white">EasyColoc</span>
                </div>
                <p class="text-slate-400 text-sm">
                    &copy; {{ date('Y') }} EasyColoc. All rights reserved.
                </p>
            </div>
        </footer>
    </body>
</html>
