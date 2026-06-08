<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mas Tulung Mas') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet Map Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Inline theme script to prevent flash -->
    <script>
        if (localStorage.getItem('mtm-theme') === 'dark' || (!('mtm-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Handle navigation flag for loading screen
        window.addEventListener('load', () => {
            sessionStorage.removeItem('mtm_navigating');
        });

        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && link.href && link.href.startsWith(window.location.origin) && !link.hash && link.target !== '_blank') {
                sessionStorage.setItem('mtm_navigating', 'true');
            }
        });
    </script>
</head>
<body class="font-sans antialiased bg-background text-foreground overflow-x-hidden">
    <!-- Premium Loading Screen -->
    <x-loading-screen />

    <div class="min-h-screen">
        @if(!Auth::check() || Auth::user()->role !== 'mitra')
            <x-navbar />
        @endif

        <!-- Page Content -->
        <main class="{{ Auth::check() && Auth::user()->role === 'mitra' ? 'pt-8 pb-12' : 'pt-24 pb-12' }}">
            <div x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 500)" 
                 x-show="shown"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-y-4 blur-sm"
                 x-transition:enter-end="opacity-100 translate-y-0 blur-0">
                {{ $slot }}
            </div>
        </main>

        @if(!Auth::check() || Auth::user()->role !== 'mitra')
            <x-footer />
        @endif
    </div>

    <!-- Scroll to Top Button -->
    <div x-data="{ 
            isVisible: false,
            scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
         }" 
         @scroll.window="isVisible = window.pageYOffset > 500"
         x-show="isVisible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-10"
         class="fixed bottom-8 right-8 z-[80]"
         x-cloak>
        <button @click="scrollToTop()" class="w-12 h-12 glass rounded-full flex items-center justify-center text-mtm-red hover:scale-110 active:scale-95 transition-all shadow-2xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </div>
</body>
</html>
