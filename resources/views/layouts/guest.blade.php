<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline theme script -->
    <script>
        if (localStorage.getItem('mtm-theme') === 'dark' || (!('mtm-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-background text-foreground overflow-x-hidden">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white via-red-50/30 to-white dark:from-mtm-dark dark:via-red-950/10 dark:to-mtm-dark py-12 px-4 relative">
        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-20">
            <div class="absolute top-1/4 left-10 w-64 h-64 bg-mtm-red/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-10 w-64 h-64 bg-mtm-brown/20 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-md relative z-10" 
             x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)"
             x-show="shown"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-flex flex-col items-center gap-4 group">
                    <img src="{{ asset('images/logomtm.png') }}" alt="MTM Logo" class="h-24 w-auto object-contain transition-transform duration-500 group-hover:scale-110">
                    <p class="text-sm text-mtm-brown dark:text-mtm-brown-light font-medium">Bantuan Apa Pun, Kini Dalam Satu Klik</p>
                </a>
            </div>

            <!-- Form Card -->
            <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-2xl">
                {{ $slot }}
            </div>

            <!-- Back to Home -->
            <div class="mt-8 text-center">
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-mtm-red text-sm font-medium transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
