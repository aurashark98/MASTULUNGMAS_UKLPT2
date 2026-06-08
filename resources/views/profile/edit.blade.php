<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.3] pointer-events-none z-0"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 max-w-4xl pt-8 pb-16">
        <!-- Header -->
        <div class="mb-10 text-center md:text-left animate-fade-in">
            <h1 class="text-4xl font-black heading-gradient mb-2">
                {{ __('Pengaturan Profil') }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium">
                Kelola informasi akun, perbarui kata sandi, dan kelola privasi Anda.
            </p>
        </div>

        <!-- Alerts -->
        @if (session('status') === 'registered-as-mitra')
            <div class="mb-8 p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ __('Pendaftaran Mitra berhasil dikirim! Silakan tunggu proses verifikasi berkas oleh Administrator.') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-8 p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 p-4 rounded-2xl bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 text-sm font-bold text-red-600 dark:text-red-400 flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-8" x-data="{ currentTab: '{{ $errors->updatePassword->any() ? 'keamanan' : ($errors->any() && old('skills') ? 'mitra' : 'akun') }}' }">
            
            <!-- Custom Tab Dropdown (Responsive) -->
            <div class="mb-8 relative" x-data="{ dropdownOpen: false }">
                <!-- Mobile Select Dropdown Trigger -->
                <div class="md:hidden">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            class="w-full flex items-center justify-between px-6 py-4 bg-white dark:bg-[#1a1a1a] border border-gray-200 dark:border-white/5 rounded-2xl shadow-sm text-left focus:outline-none">
                        <span class="text-sm font-black text-gray-700 dark:text-white flex items-center gap-2">
                            <span x-show="currentTab === 'akun'" class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Akun
                            </span>
                            <span x-show="currentTab === 'keamanan'" class="flex items-center gap-2" x-cloak>
                                <svg class="w-5 h-5 text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Keamanan
                            </span>
                            @if($user->mitraProfile && $user->mitraProfile->is_verified)
                            <span x-show="currentTab === 'mitra'" class="flex items-center gap-2" x-cloak>
                                <svg class="w-5 h-5 text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Profil Mitra
                            </span>
                            @endif
                            <span x-show="currentTab === 'notifikasi'" class="flex items-center gap-2" x-cloak>
                                <svg class="w-5 h-5 text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                Notifikasi
                            </span>
                        </span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu items -->
                    <div x-show="dropdownOpen" 
                         @click.away="dropdownOpen = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute z-25 w-full mt-2 bg-white dark:bg-[#1a1a1a] border border-gray-200 dark:border-white/10 rounded-2xl shadow-xl overflow-hidden"
                         x-cloak>
                        <button @click="currentTab = 'akun'; dropdownOpen = false" 
                                class="w-full flex items-center gap-3 px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors"
                                :class="currentTab === 'akun' ? 'text-mtm-red bg-red-500/5' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Informasi Akun
                        </button>
                        <button @click="currentTab = 'keamanan'; dropdownOpen = false" 
                                class="w-full flex items-center gap-3 px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors"
                                :class="currentTab === 'keamanan' ? 'text-mtm-red bg-red-500/5' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Keamanan
                        </button>
                        @if($user->mitraProfile && $user->mitraProfile->is_verified)
                        <button @click="currentTab = 'mitra'; dropdownOpen = false" 
                                class="w-full flex items-center gap-3 px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors"
                                :class="currentTab === 'mitra' ? 'text-mtm-red bg-red-500/5' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Profil Mitra
                        </button>
                        @endif
                        <button @click="currentTab = 'notifikasi'; dropdownOpen = false" 
                                class="w-full flex items-center gap-3 px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors"
                                :class="currentTab === 'notifikasi' ? 'text-mtm-red bg-red-500/5' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            Notifikasi
                        </button>
                    </div>
                </div>

                <!-- Desktop Tabs View -->
                <div class="hidden md:flex border-b border-gray-200 dark:border-white/5 gap-2">
                    <button @click="currentTab = 'akun'" 
                            class="px-6 pb-4 text-sm font-black transition-all flex items-center gap-2 border-b-2"
                            :class="currentTab === 'akun' ? 'text-mtm-red border-mtm-red' : 'text-gray-400 border-transparent hover:text-gray-600 dark:hover:text-gray-300'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Akun
                    </button>
                    <button @click="currentTab = 'keamanan'" 
                            class="px-6 pb-4 text-sm font-black transition-all flex items-center gap-2 border-b-2"
                            :class="currentTab === 'keamanan' ? 'text-mtm-red border-mtm-red' : 'text-gray-400 border-transparent hover:text-gray-600 dark:hover:text-gray-300'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Keamanan
                    </button>
                    @if($user->mitraProfile && $user->mitraProfile->is_verified)
                    <button @click="currentTab = 'mitra'" 
                            class="px-6 pb-4 text-sm font-black transition-all flex items-center gap-2 border-b-2"
                            :class="currentTab === 'mitra' ? 'text-mtm-red border-mtm-red' : 'text-gray-400 border-transparent hover:text-gray-600 dark:hover:text-gray-300'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Profil Mitra
                    </button>
                    @endif
                    <button @click="currentTab = 'notifikasi'" 
                            class="px-6 pb-4 text-sm font-black transition-all flex items-center gap-2 border-b-2"
                            :class="currentTab === 'notifikasi' ? 'text-mtm-red border-mtm-red' : 'text-gray-400 border-transparent hover:text-gray-600 dark:hover:text-gray-300'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Notifikasi
                    </button>
                </div>
            </div>

            <!-- Tab Content: Akun -->
            <div x-show="currentTab === 'akun'" class="space-y-8" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <!-- Update Profile Section -->
                <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-gray-200 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 backdrop-blur-md">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Mitra System Section -->
                @if(!$user->mitraProfile)
                    <!-- Promotion Card to Register Mitra -->
                    <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-amber-100 dark:border-amber-950/20 bg-amber-50/10 dark:bg-amber-950/5 backdrop-blur-md animate-fade-in">
                        <div class="max-w-3xl space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3.5 rounded-3xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-black text-amber-600 dark:text-amber-500 font-poppins">
                                        {{ __('Bergabung Sebagai Mitra Tulung') }}
                                    </h2>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest mt-0.5">MTM Partner Program</p>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-300 font-medium leading-relaxed max-w-2xl">
                                {{ __('Mulai tawarkan keahlian dan jasa pelayanan Anda kepada ribuan pelanggan di MTM. Atur jadwal kerja Anda sendiri dan kelola penawaran tarif jasa secara transparan.') }}
                            </p>

                            <!-- Benefits grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                                <div class="p-5 bg-white/50 dark:bg-black/25 rounded-2xl border border-gray-150 dark:border-white/5 space-y-2">
                                    <div class="text-amber-500 font-black text-lg">01</div>
                                    <h4 class="font-bold text-xs uppercase tracking-wider text-gray-800 dark:text-white">Bebas Atur Waktu</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-normal">Bekerja kapan pun Anda mau secara fleksibel sesuai kesiapan Anda.</p>
                                </div>
                                <div class="p-5 bg-white/50 dark:bg-black/25 rounded-2xl border border-gray-150 dark:border-white/5 space-y-2">
                                    <div class="text-amber-500 font-black text-lg">02</div>
                                    <h4 class="font-bold text-xs uppercase tracking-wider text-gray-800 dark:text-white">Sistem Bidding</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-normal">Tawarkan tarif jasa secara adil dan langsung bernegosiasi dengan konsumen.</p>
                                </div>
                                <div class="p-5 bg-white/50 dark:bg-black/25 rounded-2xl border border-gray-150 dark:border-white/5 space-y-2">
                                    <div class="text-amber-500 font-black text-lg">03</div>
                                    <h4 class="font-bold text-xs uppercase tracking-wider text-gray-800 dark:text-white">Penghasilan Penuh</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-normal">Seluruh tarif hasil kesepakatan langsung masuk ke dompet digital Anda.</p>
                                </div>
                            </div>

                            <div class="pt-4">
                                <a href="{{ route('profile.register-mitra') }}" 
                                   class="inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-full font-bold text-sm hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 transform active:scale-95 cursor-pointer">
                                    {{ __('Mulai Pendaftaran Mitra') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif(!$user->mitraProfile->is_verified)
                    <!-- Pendaftaran Menunggu Verifikasi -->
                    <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-amber-100 dark:border-amber-950/20 bg-amber-50/10 dark:bg-amber-950/5 backdrop-blur-md animate-fade-in">
                        <div class="max-w-2xl text-center md:text-left space-y-6">
                            <div class="inline-flex p-4 rounded-3xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="w-10 h-10 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            
                            <div class="space-y-2">
                                <h3 class="text-2xl font-black text-amber-600 dark:text-amber-500">
                                    Pendaftaran Mitra Sedang Ditinjau
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium leading-relaxed">
                                    Terima kasih telah mendaftar sebagai Mitra Tulung! Berkas pendaftaran Anda saat ini sedang diperiksa dan ditinjau oleh administrator kami. Mohon tunggu proses verifikasi selesai.
                                </p>
                            </div>

                            <div class="p-6 bg-white/50 dark:bg-[#121212]/20 border border-gray-100 dark:border-white/5 rounded-3xl space-y-4">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Berkas yang Anda Kirimkan:</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                    <div>
                                        <span class="text-gray-400 block mb-1">Keahlian terpilih:</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($user->mitraProfile->skills ?? [] as $skill)
                                                <span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-full font-bold">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-gray-400 block mb-1">Deskripsi Bio:</span>
                                        <p class="text-gray-600 dark:text-gray-300 font-medium italic">"{{ $user->mitraProfile->bio }}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Switch Peran (Verified Mitra) -->
                    <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-red-100 dark:border-red-950/20 bg-red-50/10 dark:bg-red-950/5 backdrop-blur-md animate-fade-in">
                        <div class="max-w-2xl space-y-6">
                            <header>
                                <h2 class="text-2xl font-black text-red-600 dark:text-red-505 flex items-center gap-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                    {{ __('Panel Beralih Peran (Role Switch)') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 font-medium">
                                    {{ __('Anda memiliki status Mitra terverifikasi. Gunakan tombol di bawah ini untuk beralih mode aktif akun Anda.') }}
                                </p>
                            </header>

                            <div class="p-6 bg-white dark:bg-[#1a1a1a] border border-gray-200 dark:border-white/5 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-red-500 to-amber-500 flex items-center justify-center text-white shadow-md">
                                        @if($user->role === 'mitra')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Mode Aktif Saat Ini:</span>
                                        <span class="text-lg font-black text-gray-800 dark:text-white">
                                            {{ $user->role === 'mitra' ? 'Mode Mitra Tulung' : 'Mode Pengguna Biasa' }}
                                        </span>
                                    </div>
                                </div>

                                <form method="post" action="{{ route('profile.switch-role') }}">
                                    @csrf
                                    @if($user->role === 'mitra')
                                        <x-primary-button class="bg-gradient-to-r from-gray-600 to-gray-800 hover:shadow-gray-600/25 px-8 py-3.5 !text-sm">
                                            {{ __('Beralih ke Mode Pengguna') }}
                                        </x-primary-button>
                                    @else
                                        <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                                            {{ __('Beralih ke Mode Mitra') }}
                                        </x-primary-button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab Content: Keamanan -->
            <div x-show="currentTab === 'keamanan'" class="space-y-8" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <!-- Update Password Section -->
                <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-gray-200 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 backdrop-blur-md">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User Section -->
                <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-red-100 dark:border-red-950/20 bg-red-50/10 dark:bg-red-950/5 backdrop-blur-md">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <!-- Tab Content: Mitra -->
            @if($user->mitraProfile && $user->mitraProfile->is_verified)
            <div x-show="currentTab === 'mitra'" class="space-y-8" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-xl border border-gray-200 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 backdrop-blur-md">
                    <div class="max-w-2xl">
                        <form method="post" action="{{ route('profile.mitra.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Detail Profil Mitra</h3>
                                <p class="text-xs text-gray-500 mt-1 font-medium">Perbarui informasi profil profesional Anda sebagai Mitra MTM.</p>
                            </div>

                            <!-- Bio -->
                            <div>
                                <x-input-label for="mitra_bio" :value="__('Bio / Deskripsi Keahlian')" />
                                <textarea id="mitra_bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 dark:border-white/10 dark:bg-black/20 dark:text-gray-300 focus:border-mtm-red dark:focus:border-mtm-red focus:ring-mtm-red dark:focus:ring-mtm-red rounded-2xl shadow-sm text-sm" required>{{ old('bio', $user->mitraProfile->bio) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                            </div>

                            <!-- Skills -->
                            <div>
                                <x-input-label :value="__('Bidang Keahlian / Kategori Jasa')" />
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    @foreach($categories as $category)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                            <input type="checkbox" name="skills[]" value="{{ $category->name }}" 
                                                class="rounded dark:bg-black/20 border-gray-300 dark:border-white/10 text-mtm-red focus:ring-mtm-red"
                                                @checked(in_array($category->name, old('skills', $user->mitraProfile->skills ?? [])))>
                                            <span>{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                            </div>

                            <!-- Service Area & Service Radius -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="service_area" :value="__('Area Layanan')" />
                                    <x-text-input id="service_area" name="service_area" type="text" class="mt-1 block w-full" :value="old('service_area', $user->mitraProfile->service_area)" placeholder="Contoh: Malang Kota, Lowokwaru" />
                                    <x-input-error class="mt-2" :messages="$errors->get('service_area')" />
                                </div>
                                <div>
                                    <x-input-label for="service_radius" :value="__('Radius Layanan (km)')" />
                                    <x-text-input id="service_radius" name="service_radius" type="number" class="mt-1 block w-full" :value="old('service_radius', $user->mitraProfile->service_radius)" placeholder="Contoh: 10" />
                                    <x-input-error class="mt-2" :messages="$errors->get('service_radius')" />
                                </div>
                            </div>

                            <!-- Operational Hours -->
                            <div>
                                <x-input-label for="operational_hours" :value="__('Jam Operasional')" />
                                <x-text-input id="operational_hours" name="operational_hours" type="text" class="mt-1 block w-full" :value="old('operational_hours', $user->mitraProfile->operational_hours)" placeholder="Contoh: Senin - Sabtu (08:00 - 17:00)" />
                                <x-input-error class="mt-2" :messages="$errors->get('operational_hours')" />
                            </div>

                            <!-- Portfolio Images -->
                            <div>
                                <x-input-label for="portfolio_images" :value="__('Unggah Gambar Portofolio (Bisa Pilih Banyak)')" />
                                <input type="file" id="portfolio_images" name="portfolio_images[]" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-red-50 dark:file:bg-red-950/20 file:text-mtm-red hover:file:bg-red-100 dark:hover:file:bg-red-950/40" accept="image/*">
                                <x-input-error class="mt-2" :messages="$errors->get('portfolio_images.*')" />
                                
                                @if($user->mitraProfile->portfolio_images)
                                    <div class="mt-4">
                                        <p class="text-xs text-gray-400 font-bold mb-2">Portofolio Saat Ini:</p>
                                        <div class="grid grid-cols-4 gap-3">
                                            @foreach($user->mitraProfile->portfolio_images as $img)
                                                <div class="relative group aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-black/40 border border-gray-200 dark:border-white/5">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 pt-4 border-t border-gray-150 dark:border-white/5">
                                <x-primary-button class="bg-gradient-to-r from-mtm-red to-mtm-red-dark hover:shadow-mtm-red/25 px-8 py-3.5 !text-sm">
                                    {{ __('Simpan Perubahan') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif<!-- Notification Preferences -->
                <div x-show="currentTab === 'notifikasi'" class="space-y-12" x-cloak>
                    <div class="bg-white dark:bg-mtm-dark-surface p-8 md:p-12 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                        <header class="mb-10">
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white font-poppins">Preferensi Notifikasi</h3>
                            <p class="mt-2 text-sm text-gray-500">Pilih bagaimana Anda ingin menerima pembaruan dari platform.</p>
                        </header>

                        <form method="post" action="{{ route('notification-settings.update') }}" class="space-y-8">
                            @csrf
                            @method('patch')

                            <div class="divide-y divide-gray-50 dark:divide-white/5">
                                @foreach(\App\Models\NotificationSetting::availableTypes() as $key => $label)
                                    @php
                                        $setting = Auth::user()->getNotificationSetting($key);
                                    @endphp
                                    <div class="py-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div>
                                            <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">{{ $label }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">Terima pemberitahuan saat terjadi {{ strtolower($label) }}.</p>
                                        </div>
                                        <div class="flex items-center gap-6">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="notif_{{ $key }}_db" value="1" {{ $setting->database_enabled ? 'checked' : '' }} class="rounded text-mtm-red focus:ring-mtm-red">
                                                <span class="ml-2 text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Aplikasi</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="notif_{{ $key }}_email" value="1" {{ $setting->email_enabled ? 'checked' : '' }} class="rounded text-mtm-red focus:ring-mtm-red">
                                                <span class="ml-2 text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Email</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-6 border-t border-gray-50 dark:border-white/5">
                                <x-primary-button class="px-8 py-3.5">{{ __('Simpan Preferensi') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
