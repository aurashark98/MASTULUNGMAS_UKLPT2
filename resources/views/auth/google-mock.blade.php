<x-guest-layout>
    <div x-data="{ email: '', name: '', showCustom: false }" class="space-y-6">
        <!-- Google Logo SVG -->
        <div class="flex flex-col items-center justify-center text-center">
            <svg class="w-10 h-10 mb-4" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pilih akun Google</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">untuk melanjutkan ke <span class="font-semibold text-mtm-red">MTM (Mode Simulasi)</span></p>
        </div>

        <!-- Hidden submit form -->
        <form x-ref="form" method="POST" action="{{ route('auth.google.mock-select.post') }}" class="hidden">
            @csrf
            <input type="hidden" name="email" x-model="email">
            <input type="hidden" name="name" x-model="name">
        </form>

        <!-- Mock Accounts List -->
        <div x-show="!showCustom" x-transition:enter="transition ease-out duration-300" class="space-y-3">
            <div class="border border-gray-100 dark:border-white/10 rounded-3xl overflow-hidden divide-y divide-gray-100 dark:divide-white/10 bg-gray-50/50 dark:bg-white/5">
                
                <!-- Account 1 -->
                <button type="button" 
                        @click="email = 'google_user@gmail.com'; name = 'Mock Google User'; $nextTick(() => $refs.form.submit())"
                        class="w-full flex items-center gap-4 p-4 text-left hover:bg-gray-100/50 dark:hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-base group-hover:scale-105 transition-transform">
                        M
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Mock Google User</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">google_user@gmail.com</p>
                    </div>
                </button>

                <!-- Account 2 -->
                <button type="button" 
                        @click="email = 'budi.santoso@gmail.com'; name = 'Budi Santoso'; $nextTick(() => $refs.form.submit())"
                        class="w-full flex items-center gap-4 p-4 text-left hover:bg-gray-100/50 dark:hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-base group-hover:scale-105 transition-transform">
                        B
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Budi Santoso</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">budi.santoso@gmail.com</p>
                    </div>
                </button>

                <!-- Account 3 -->
                <button type="button" 
                        @click="email = 'siti.aminah@gmail.com'; name = 'Siti Aminah'; $nextTick(() => $refs.form.submit())"
                        class="w-full flex items-center gap-4 p-4 text-left hover:bg-gray-100/50 dark:hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-base group-hover:scale-105 transition-transform">
                        S
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Siti Aminah</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">siti.aminah@gmail.com</p>
                    </div>
                </button>

                <!-- Custom Account trigger -->
                <button type="button" 
                        @click="showCustom = true"
                        class="w-full flex items-center gap-4 p-4 text-left hover:bg-gray-100/50 dark:hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-full border border-dashed border-gray-300 dark:border-white/20 text-gray-500 dark:text-gray-400 flex items-center justify-center font-medium text-lg group-hover:scale-105 transition-transform">
                        +
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-mtm-red hover:underline">Gunakan akun lain / email asli Anda</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Ketik email Google kustom Anda</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Custom Account Form -->
        <div x-show="showCustom" 
             x-transition:enter="transition ease-out duration-300"
             class="space-y-4">
            
            <form method="POST" action="{{ route('auth.google.mock-select.post') }}" class="space-y-4">
                @csrf
                
                <div class="space-y-1">
                    <x-input-label for="custom_name" :value="__('Nama Lengkap')" class="text-[10px] font-bold uppercase tracking-widest text-gray-400" />
                    <x-text-input id="custom_name" class="block w-full !py-3 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm" 
                                  type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan Nama Lengkap" />
                </div>

                <div class="space-y-1">
                    <x-input-label for="custom_email" :value="__('Email Google')" class="text-[10px] font-bold uppercase tracking-widest text-gray-400" />
                    <x-text-input id="custom_email" class="block w-full !py-3 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm" 
                                  type="email" name="email" :value="old('email')" required placeholder="email.anda@gmail.com" />
                </div>

                <div class="flex gap-3 pt-2">
                    <x-secondary-button type="button" @click="showCustom = false" class="flex-1 !py-3 justify-center !text-sm">
                        Kembali
                    </x-secondary-button>
                    <x-primary-button type="submit" class="flex-1 !py-3 justify-center !text-sm btn-premium">
                        Lanjutkan
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Info/Disclaimer Alert Box -->
        <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-2xl text-xs text-amber-600 dark:text-amber-400 leading-relaxed space-y-1">
            <span class="font-bold flex items-center gap-1.5 mb-1">
                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Info Mode Simulasi
            </span>
            <p>Aplikasi berjalan dalam mode simulasi karena kunci <strong>GOOGLE_CLIENT_ID</strong> di file <code>.env</code> Anda kosong atau bernilai default.</p>
            <p class="mt-1">Gunakan form di atas untuk memasukkan <strong>email Google asli</strong> Anda, agar akun Anda dapat dibuat dan masuk ke dalam database lokal MTM.</p>
        </div>
    </div>
</x-guest-layout>
