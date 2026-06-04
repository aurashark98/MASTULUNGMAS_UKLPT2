<nav x-data="{ 
        isOpen: false, 
        isScrolled: false,
        activeNav: '{{ Route::currentRouteName() }}'
     }" 
     @scroll.window="isScrolled = window.pageYOffset > 50"
     class="fixed top-8 left-1/2 -translate-x-1/2 z-[90] w-[95%] max-w-5xl transition-all duration-700 ease-out"
     :class="isScrolled ? 'top-4 w-[90%]' : 'top-8 w-[95%]'">
    
    <div class="glass rounded-full px-4 py-2.5 md:px-6 md:py-3 flex items-center justify-between shadow-2xl border border-[#D1D5DB] dark:border-white/10 dark:shadow-2xl dark:shadow-black/40">
        <!-- Logo Section -->
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logomtm.png') }}" alt="MTM Logo" class="h-10 w-auto object-contain transition-transform duration-500 group-hover:scale-110">
            </a>
            <div class="hidden lg:block w-px h-6 bg-[#D1D5DB] dark:bg-white/10 ml-4"></div>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-3 px-4">
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
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 relative group"
                   :class="activeNav === '{{ $link['id'] }}' ? 'bg-gradient-to-r from-red-500 to-amber-500 text-white' : 'text-[#111827] dark:text-white hover:text-[#DC2626]'">
                    {{ $link['name'] }}
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] rounded-full transition-all duration-300 opacity-0"
                         :class="activeNav === '{{ $link['id'] }}' ? 'opacity-100' : 'group-hover:opacity-50'"></div>
                </a>
            @endforeach
        </div>

        <!-- Action Section -->
        <div class="flex items-center gap-2">
            <div class="hidden lg:block w-px h-6 bg-[#D1D5DB] dark:bg-white/10 mr-4"></div>
            
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 mr-1">
                    <x-theme-toggle />
                </div>
                
                @auth
                    <!-- Desktop User Dropdown -->
                    <div class="hidden lg:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-black/[0.03] dark:hover:bg-white/[0.05] transition-all group">
                                    <div class="w-7 h-7 bg-white dark:bg-white/10 rounded-full flex items-center justify-center text-[#DC2626] text-[10px] font-black shadow-md group-hover:scale-110 transition-transform border border-[#D1D5DB]">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="text-[13px] font-bold text-[#111827] dark:text-white/80 group-hover:text-[#DC2626] transition-colors whitespace-nowrap">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 text-[#374151] dark:text-gray-400 group-hover:text-[#DC2626] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-[#D1D5DB] dark:border-white/5">
                                    <p class="text-xs font-bold text-[#6B7280] uppercase tracking-widest">Menu Pengguna</p>
                                </div>
                                <x-dropdown-link :href="route('dashboard')" class="font-bold text-[#111827] dark:!text-white">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')" class="font-bold text-[#111827] dark:!text-white">
                                    {{ __('Profil Saya') }}
                                </x-dropdown-link>
                                <div class="h-px bg-[#D1D5DB] dark:bg-white/5 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-[#DC2626] font-bold">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Mobile Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                        @csrf
                        <button type="submit" class="btn-premium !px-6 !py-2.5 !text-xs !shadow-none">Logout</button>
                    </form>
                @else
                    <div class="hidden lg:flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold text-[#111827] dark:text-white hover:text-[#DC2626] transition-colors whitespace-nowrap">Login</a>
                        <a href="{{ route('register') }}" class="btn-premium !px-8 !py-2.5 !text-xs !shadow-none whitespace-nowrap">Daftar</a>
                    </div>
                    <!-- Mobile Register Button -->
                    <a href="{{ route('register') }}" class="lg:hidden btn-premium !px-6 !py-2.5 !text-xs !shadow-none">Daftar</a>
                @endauth

                <!-- Mobile Toggle -->
                <button @click="isOpen = !isOpen" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-full hover:bg-black/[0.05] dark:hover:bg-white/[0.05] transition-all ml-1">
                    <div class="w-4 flex flex-col gap-1">
                        <span class="w-full h-0.5 bg-[#DC2626] transition-all duration-300" :class="isOpen ? 'rotate-45 translate-y-1.5' : ''"></span>
                        <span class="w-full h-0.5 bg-[#DC2626] transition-all duration-300" :class="isOpen ? 'opacity-0' : ''"></span>
                        <span class="w-full h-0.5 bg-[#DC2626] transition-all duration-300" :class="isOpen ? '-rotate-45 -translate-y-1.5' : ''"></span>
                    </div>
                </button>
            </div>
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
                   class="px-6 py-4 rounded-2xl text-lg font-bold text-foreground hover:bg-mtm-red/10 hover:text-mtm-red transition-all"
                   :class="activeNav === '{{ $link['id'] }}' ? 'text-mtm-red bg-mtm-red/5' : ''"
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
