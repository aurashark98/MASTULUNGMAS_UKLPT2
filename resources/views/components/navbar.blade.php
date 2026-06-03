<nav x-data="{ 
        isOpen: false, 
        isScrolled: false,
        activeNav: '{{ Route::currentRouteName() }}'
     }" 
     @scroll.window="isScrolled = window.pageYOffset > 50"
     class="fixed top-8 left-1/2 -translate-x-1/2 z-[90] w-[95%] max-w-5xl transition-all duration-700 ease-out"
     :class="isScrolled ? 'top-4 w-[90%]' : 'top-8 w-[95%]'">
    
    <div class="glass rounded-full px-4 py-2.5 md:px-6 md:py-3 flex items-center justify-between shadow-2xl border border-white/20 dark:border-white/5">
        <!-- Logo Section -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 pl-2 group">
            <div class="w-10 h-10 bg-gradient-premium rounded-full flex items-center justify-center shadow-lg group-hover:rotate-[360deg] transition-transform duration-700">
                <span class="text-white font-black text-xl">M</span>
            </div>
            <span class="font-black text-2xl text-mtm-red dark:text-white font-poppins tracking-tighter group-hover:text-mtm-red transition-colors">MTM</span>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-1">
            @php
                $navLinks = [
                    ['name' => 'Home', 'id' => 'home', 'url' => route('home')],
                    ['name' => 'Layanan', 'id' => 'layanan', 'url' => route('layanan')],
                    ['name' => 'Cara Kerja', 'id' => 'cara-kerja', 'url' => route('cara-kerja')],
                    ['name' => 'Tentang Kami', 'id' => 'tentang-kami', 'url' => route('tentang-kami')],
                ];
            @endphp

            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}" 
                   class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group overflow-hidden"
                   :class="activeNav === '{{ $link['id'] }}' ? 'text-mtm-red dark:text-white' : 'text-black dark:text-white hover:text-mtm-red'">
                    <span class="relative z-10">{{ $link['name'] }}</span>
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-mtm-red rounded-full transition-all duration-300 opacity-0"
                         :class="activeNav === '{{ $link['id'] }}' ? 'opacity-100' : 'group-hover:opacity-50'"></div>
                </a>
            @endforeach
        </div>

        <!-- Action Section -->
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2 mr-2">
                <x-theme-toggle />
            </div>
            
            @auth
                <a href="{{ route('dashboard') }}" class="hidden md:block px-6 py-2.5 text-sm font-bold text-black dark:text-white hover:text-mtm-red transition-colors">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-premium !px-6 !py-2.5 !text-xs !shadow-none">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hidden md:block px-6 py-2.5 text-sm font-bold text-black dark:text-white hover:text-mtm-red transition-colors">Login</a>
                <a href="{{ route('register') }}" class="btn-premium !px-8 !py-2.5 !text-xs !shadow-none">Daftar</a>
            @endauth

            <!-- Mobile Toggle -->
            <button @click="isOpen = !isOpen" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full hover:bg-mtm-red/10 transition-colors ml-2">
                <div class="w-5 flex flex-col gap-1.5">
                    <span class="w-full h-0.5 bg-gray-600 dark:bg-white transition-all duration-300" :class="isOpen ? 'rotate-45 translate-y-2' : ''"></span>
                    <span class="w-full h-0.5 bg-gray-600 dark:bg-white transition-all duration-300" :class="isOpen ? 'opacity-0' : ''"></span>
                    <span class="w-full h-0.5 bg-gray-600 dark:bg-white transition-all duration-300" :class="isOpen ? '-rotate-45 -translate-y-2' : ''"></span>
                </div>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 -translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-y-10 scale-95"
         class="absolute top-20 left-0 right-0 glass rounded-[2rem] p-6 shadow-3xl lg:hidden mt-2"
         x-cloak>
        <div class="flex flex-col gap-2">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}" 
                   class="px-6 py-4 rounded-2xl text-lg font-bold text-black dark:text-white hover:bg-mtm-red/10 hover:text-mtm-red transition-all"
                   @click="isOpen = false">
                    {{ $link['name'] }}
                </a>
            @endforeach
            <div class="h-px bg-gray-100 dark:bg-white/5 my-4"></div>
            <div class="flex flex-col gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-outline-premium !py-3">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline-premium !py-3">Login</a>
                    <a href="{{ route('register') }}" class="btn-premium !py-3">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
