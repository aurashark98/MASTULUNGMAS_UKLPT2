<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MTM Admin') }} - Admin Control Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Inline theme script to prevent flash -->
    <script>
        if (localStorage.getItem('mtm-theme') === 'dark' || (!('mtm-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-black text-gray-900 dark:text-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-mtm-dark-surface border-r border-gray-200 dark:border-white/5 flex flex-col fixed inset-y-0 left-0 z-30">
        <!-- Sidebar Header / Logo -->
        <div class="h-20 flex items-center px-6 border-b border-gray-100 dark:border-white/5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logomtm.png') }}" alt="MTM Logo" class="h-10 w-auto object-contain">
                <span class="text-lg font-black text-mtm-red leading-none font-poppins">ADMIN Panel</span>
            </a>
        </div>

        <!-- Sidebar Navigation Links -->
        <nav class="flex-1 px-4 py-4 space-y-4 overflow-y-auto text-xs">
            <div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Kategori: Pengguna -->
            <div class="space-y-1">
                <span class="px-4 text-[9px] font-black uppercase tracking-wider text-gray-400 block mb-1">Pengguna</span>
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Akun Pengguna
                </a>
                <a href="{{ route('admin.mitra-profiles.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.mitra-profiles.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    Profil Mitra
                </a>
            </div>

            <!-- Kategori: Pekerjaan -->
            <div class="space-y-1">
                <span class="px-4 text-[9px] font-black uppercase tracking-wider text-gray-400 block mb-1">Pekerjaan</span>
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Kategori Jasa
                </a>
                <a href="{{ route('admin.tasks.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.tasks.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012 2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Daftar Tugas
                </a>
                <a href="{{ route('admin.task-bids.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.task-bids.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Penawaran Mitra
                </a>
                <a href="{{ route('admin.task-assignments.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.task-assignments.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Penugasan Mitra
                </a>
            </div>

            <!-- Kategori: Transaksi & Review -->
            <div class="space-y-1">
                <span class="px-4 text-[9px] font-black uppercase tracking-wider text-gray-400 block mb-1">Transaksi & Ulasan</span>
                <a href="{{ route('admin.payments.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.payments.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Histori Transaksi
                </a>
                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.reviews.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.371 1.24.588 1.81l-3.97 2.879a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.878a1 1 0 00-1.175 0l-3.97 2.878c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 10.1c-.783-.57-.373-1.81.588-1.81h4.906a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Ulasan Mitra
                </a>
            </div>

            <!-- Kategori: Chat & Log -->
            <div class="space-y-1">
                <span class="px-4 text-[9px] font-black uppercase tracking-wider text-gray-400 block mb-1">Chat & Sistem</span>
                <a href="{{ route('admin.chat-rooms.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.chat-rooms.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Ruang Obrolan
                </a>
                <a href="{{ route('admin.messages.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.messages.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Pesan Obrolan
                </a>
                <a href="{{ route('admin.activity-logs.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.activity-logs.*') ? 'bg-mtm-red/10 text-mtm-red font-extrabold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Log Aktivitas
                </a>
            </div>
            
            <div class="h-px bg-gray-100 dark:bg-white/5 my-4"></div>

            <a href="{{ route('home') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-950 dark:hover:text-white transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Home
            </a>
        </nav>

        <!-- Sidebar Footer / Logout -->
        <div class="p-4 border-t border-gray-100 dark:border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-red-950/10 transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 pl-64 flex flex-col min-h-screen">
        <!-- Top Header Bar -->
        <header class="h-20 bg-white dark:bg-mtm-dark-surface/60 backdrop-blur-md border-b border-gray-200 dark:border-white/5 flex items-center justify-between px-8 sticky top-0 z-20">
            <div>
                <h1 class="text-xl font-black font-poppins text-gray-800 dark:text-white">Admin Control Panel</h1>
            </div>

            <div class="flex items-center gap-4">
                <x-theme-toggle />
                
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-white/10">
                    <div class="w-8 h-8 rounded-full bg-mtm-red flex items-center justify-center text-white text-xs font-black">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
