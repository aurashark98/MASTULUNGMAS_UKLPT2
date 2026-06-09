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
            <a href="{{ Auth::check() && Auth::user()->isMitra() ? route('mitra.dashboard') : route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logomtm.png') }}" alt="MTM Logo" class="h-10 w-auto object-contain transition-transform duration-500 group-hover:scale-110">
            </a>
            <div class="hidden lg:block w-px h-6 bg-[#D1D5DB] dark:bg-white/10 ml-4"></div>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-3 px-4">
            @if(!Auth::check() || !Auth::user()->isMitra())
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
            @else
                <div class="flex items-center gap-2 px-4 py-2 bg-mtm-red/10 text-mtm-red rounded-full border border-mtm-red/20 text-xs font-black uppercase tracking-widest">
                    Konsol Mitra Kerja
                </div>
            @endif
        </div>

        <!-- Action Section -->
        <div class="flex items-center gap-2">
            @if(Auth::check() && Auth::user()->isMitra())
                @php $profile = Auth::user()->mitraProfile; @endphp
                <div class="flex items-center gap-2 mr-1">
                    <span class="hidden md:block text-[10px] font-bold uppercase tracking-widest {{ $profile->is_online ? 'text-green-500' : 'text-gray-500' }}">
                        {{ $profile->is_online ? 'Kerja (On)' : 'Off' }}
                    </span>
                    <form method="POST" action="{{ route('mitra.toggle-status') }}">
                        @csrf
                        <button type="submit" 
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 focus:outline-none {{ $profile->is_online ? 'bg-green-500 shadow-sm shadow-green-500/25' : 'bg-gray-300 dark:bg-gray-600' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-all duration-300 {{ $profile->is_online ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </form>
                </div>
                <div class="w-px h-6 bg-[#D1D5DB] dark:bg-white/10 mx-1"></div>
            @else
                <div class="hidden lg:block w-px h-6 bg-[#D1D5DB] dark:bg-white/10 mr-4"></div>
            @endif
            
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 mr-1">
                    @auth
                        <!-- Notifications Icon -->
                        <a href="{{ route('notifications.index') }}" class="relative p-2 rounded-full hover:bg-black/[0.03] dark:hover:bg-white/[0.05] transition-all text-[#111827] dark:text-white hover:text-mtm-red dark:hover:text-mtm-red" title="Notifikasi">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @php
                                $unreadNotificationsCount = \Illuminate\Support\Facades\DB::table('notifications')
                                    ->where('notifiable_id', Auth::id())
                                    ->whereNull('read_at')
                                    ->count();
                            @endphp
                            @if($unreadNotificationsCount > 0)
                                <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-mtm-red text-[8px] font-black text-white rounded-full flex items-center justify-center animate-pulse">
                                    {{ $unreadNotificationsCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Chat Icon -->
                        <a href="{{ route('chat.index') }}" class="relative p-2 rounded-full hover:bg-black/[0.03] dark:hover:bg-white/[0.05] transition-all text-[#111827] dark:text-white hover:text-mtm-red dark:hover:text-mtm-red" title="Pesan Chat">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            @php
                                $unreadChatsCount = \App\Models\Message::whereHas('chatRoom', function($q) {
                                        $q->where('user_id', Auth::id())->orWhere('mitra_id', Auth::id());
                                    })
                                    ->where('sender_id', '!=', Auth::id())
                                    ->where('is_read', false)
                                    ->count();
                            @endphp
                            @if($unreadChatsCount > 0)
                                <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-mtm-red text-[8px] font-black text-white rounded-full flex items-center justify-center animate-pulse">
                                    {{ $unreadChatsCount }}
                                </span>
                            @endif
                        </a>
                    @endauth
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
                                @if(!Auth::user()->isMitra())
                                    <x-dropdown-link :href="Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard')" class="font-bold text-[#111827] dark:!text-white">
                                        {{ __('Dashboard') }}
                                    </x-dropdown-link>
                                @endif
                                <x-dropdown-link :href="route('profile.edit')" class="font-bold text-[#111827] dark:!text-white">
                                    {{ __('Profil Saya') }}
                                </x-dropdown-link>
                                <div class="h-px bg-[#D1D5DB] dark:bg-white/5 my-1"></div>
                                @if(Auth::user()->mitraProfile && Auth::user()->mitraProfile->is_verified)
                                    <form method="POST" action="{{ route('profile.switch-role') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-bold text-amber-500 hover:bg-black/[0.03] dark:hover:bg-white/5 transition-colors cursor-pointer">
                                            {{ Auth::user()->role === 'mitra' ? 'Beralih ke Mode Pengguna' : 'Beralih ke Mode Mitra' }}
                                        </button>
                                    </form>
                                    <div class="h-px bg-[#D1D5DB] dark:bg-white/5 my-1"></div>
                                @endif
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
                    <div class="hidden lg:block">
                        <button @click="$dispatch('open-modal', 'auth-modal'); setTimeout(() => $dispatch('open-auth-modal', { tab: 'login' }), 50)" class="btn-premium !px-8 !py-2.5 !text-xs !shadow-none whitespace-nowrap cursor-pointer">
                            Sign In
                        </button>
                    </div>
                    <!-- Mobile Sign In Button -->
                    <button @click="$dispatch('open-modal', 'auth-modal'); setTimeout(() => $dispatch('open-auth-modal', { tab: 'login' }), 50)" class="lg:hidden btn-premium !px-6 !py-2.5 !text-xs !shadow-none cursor-pointer">
                        Sign In
                    </button>
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
            @if(!Auth::check() || !Auth::user()->isMitra())
                @foreach($navLinks as $link)
                    <a href="{{ $link['url'] }}" 
                       class="px-6 py-4 rounded-2xl text-lg font-bold text-foreground hover:bg-mtm-red/10 hover:text-mtm-red transition-all"
                       :class="activeNav === '{{ $link['id'] }}' ? 'text-mtm-red bg-mtm-red/5' : ''"
                       @click="isOpen = false">
                        {{ $link['name'] }}
                    </a>
                @endforeach
                <div class="h-px bg-gray-100 dark:bg-white/5 my-4"></div>
            @endif
            <div class="flex flex-col gap-3">
                @auth
                    @if(!Auth::user()->isMitra())
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="btn-outline-premium !py-3">Dashboard</a>
                    @endif
                    @if(Auth::user()->mitraProfile && Auth::user()->mitraProfile->is_verified)
                        <form method="POST" action="{{ route('profile.switch-role') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-center py-3.5 px-6 rounded-2xl bg-amber-500/10 text-amber-500 hover:bg-amber-500/20 font-bold transition-all text-xs uppercase tracking-wider cursor-pointer">
                                {{ Auth::user()->role === 'mitra' ? 'Beralih ke Mode Pengguna' : 'Beralih ke Mode Mitra' }}
                            </button>
                        </form>
                    @endif
                @else
                    <button @click="isOpen = false; $dispatch('open-modal', 'auth-modal'); setTimeout(() => $dispatch('open-auth-modal', { tab: 'login' }), 50)" class="btn-premium !py-3 cursor-pointer">Sign In</button>
                @endauth
            </div>
    </div>
</nav>

<!-- Auth Selection Modal -->
@php
    $hasAuthErrors = $errors->has('email') || $errors->has('password') || $errors->has('name') || $errors->has('password_confirmation');
@endphp
<x-modal name="auth-modal" :show="$hasAuthErrors || session('open_login') || session('open_register')" maxWidth="md" focusable>
    <div x-data="{ 
            activeTab: '{{ (session('open_register') || $errors->has('name') || $errors->has('password_confirmation') || old('role') === 'user' && $hasAuthErrors) ? 'register' : 'login' }}',
            role: '{{ old('role', session('role', 'user')) }}'
         }"
         @open-auth-modal.window="activeTab = $event.detail.tab || 'login'; if ($event.detail.role) { role = $event.detail.role }"
         class="p-5 md:p-6 bg-white dark:bg-[#1e1e1e] space-y-4 max-h-[90vh] overflow-y-auto">
        
        <!-- Tab Toggles -->
        <div class="flex border-b border-gray-100 dark:border-white/5">
            <button @click="activeTab = 'login'" 
                    class="flex-1 text-center pb-3 text-lg font-black transition-all cursor-pointer"
                    :class="activeTab === 'login' ? 'text-mtm-red border-b-2 border-mtm-red' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600'">
                Masuk (Login)
            </button>
            <button @click="activeTab = 'register'" 
                    class="flex-1 text-center pb-3 text-lg font-black transition-all cursor-pointer"
                    :class="activeTab === 'register' ? 'text-mtm-red border-b-2 border-mtm-red' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600'">
                Daftar (Register)
            </button>
        </div>

        <!-- LOGIN FORM -->
        <form x-show="activeTab === 'login'" method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <x-input-label for="login_email" :value="__('Email')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                    </div>
                    <x-text-input id="login_email" class="block w-full !pl-12 !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-2" x-data="{ show: false }">
                <div class="flex items-center justify-between">
                    <x-input-label for="login_password" :value="__('Password')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-mtm-red hover:underline" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <x-text-input id="login_password" class="block w-full !pl-12 !pr-12 !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl"
                                    x-bind:type="show ? 'text' : 'password'"
                                    name="password"
                                    required placeholder="••••••••" />
                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.003 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me -->
            <div class="block">
                <label for="login_remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="login_remember_me" type="checkbox" class="rounded-lg border-gray-200 dark:border-white/10 text-mtm-red shadow-sm focus:ring-mtm-red transition-all cursor-pointer" name="remember">
                    <span class="ms-2 text-xs text-gray-600 dark:text-gray-400 group-hover:text-mtm-red transition-colors">{{ __('Ingat saya') }}</span>
                </label>
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full !py-3.5 !text-sm">
                    {{ __('Masuk Sekarang') }}
                </x-primary-button>
            </div>

            <!-- Divider -->
            <div class="relative py-2">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100 dark:border-white/5"></div>
                </div>
                <div class="relative flex justify-center text-[10px] uppercase">
                    <span class="bg-white dark:bg-[#1e1e1e] px-4 text-gray-400 font-bold tracking-widest">Atau</span>
                </div>
            </div>

            <div class="w-full">
                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-2 py-2.5 border border-gray-100 dark:border-white/10 rounded-2xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all group cursor-pointer">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-xs font-bold text-gray-650 dark:text-gray-300">Google</span>
                </a>
            </div>

            <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-4 font-medium">
                Belum punya akun? <button type="button" @click="activeTab = 'register'" class="text-mtm-red font-bold hover:underline">Daftar Sekarang</button>
            </p>
        </form>

        <!-- REGISTER FORM -->
        <form x-show="activeTab === 'register'" method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="role" value="user">

            <!-- Name -->
            <div class="space-y-2">
                <x-input-label for="register_name" :value="__('Nama Lengkap')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <x-text-input id="register_name" class="block w-full !pl-12 !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <x-input-label for="register_email" :value="__('Email')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                    </div>
                    <x-text-input id="register_email" class="block w-full !pl-12 !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red" type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <x-input-label for="register_password" :value="__('Password')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <x-text-input id="register_password" class="block w-full !pl-12 !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red" type="password" name="password" required placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <x-input-label for="register_password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <x-text-input id="register_password_confirmation" class="block w-full !pl-12 !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red" type="password" name="password_confirmation" required placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] border border-transparent rounded-full font-bold text-sm text-white uppercase tracking-wider hover:brightness-110 hover:scale-[1.02] hover:shadow-lg shadow-red-500/25 hover:shadow-red-500/35 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-mtm-red focus:ring-offset-2 dark:focus:ring-offset-black transition-all duration-300 cursor-pointer">
                    Daftar Sekarang
                </button>
            </div>

            <!-- Divider -->
            <div class="relative py-2">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100 dark:border-white/5"></div>
                </div>
                <div class="relative flex justify-center text-[10px] uppercase">
                    <span class="bg-white dark:bg-[#1e1e1e] px-4 text-gray-400 font-bold tracking-widest">Atau</span>
                </div>
            </div>

            <div class="w-full">
                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-2 py-2.5 border border-gray-100 dark:border-white/10 rounded-2xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all group cursor-pointer">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-xs font-bold text-gray-650 dark:text-gray-300">Google</span>
                </a>
            </div>

            <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-4 font-medium">
                Sudah punya akun? <button type="button" @click="activeTab = 'login'" class="text-mtm-red font-bold hover:underline">Masuk Sekarang</button>
            </p>
        </form>

        <!-- Cancel / Close Button -->
        <div class="text-center pt-4 border-t border-gray-100 dark:border-white/5">
            <button type="button" x-on:click="$dispatch('close')" class="text-xs font-bold text-gray-500 hover:text-mtm-red transition-colors cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</x-modal>
