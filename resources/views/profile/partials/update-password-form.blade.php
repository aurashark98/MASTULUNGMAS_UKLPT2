<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black text-gray-900 dark:text-white">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 font-medium">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan.') }}
        </p>
    </header>

    <!-- Linked Google Account Info -->
    <div class="mb-8 p-5 rounded-[2rem] border border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-[#121212]/30 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-white dark:bg-white/5 flex items-center justify-center border border-gray-200 dark:border-white/5">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Akun Google Tertaut</p>
                <p class="text-sm font-black text-gray-700 dark:text-gray-200">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <span class="px-3 py-1 bg-green-500/10 text-green-500 text-[10px] font-black uppercase tracking-wider rounded-full border border-green-500/20">Aktif</span>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <x-text-input id="update_password_password" name="password" type="password" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- OTP Verification Code -->
        <div class="space-y-2" x-data="{
            cooldown: 0,
            loading: false,
            message: '',
            messageType: '',
            sendOtp() {
                if (this.cooldown > 0 || this.loading) return;
                this.loading = true;
                this.message = '';
                axios.post('{{ route('profile.password.send-otp') }}')
                    .then(response => {
                        this.loading = false;
                        this.cooldown = 60;
                        this.message = response.data.message || 'Kode OTP berhasil dikirim!';
                        this.messageType = 'success';
                        if (response.data.dev_otp) {
                            this.message = '[Dev Mode] Kode OTP Anda: ' + response.data.dev_otp + ' (Salin untuk verifikasi)';
                        }
                        let timer = setInterval(() => {
                            this.cooldown--;
                            if (this.cooldown <= 0) clearInterval(timer);
                        }, 1000);
                    })
                    .catch(error => {
                        this.loading = false;
                        this.message = 'Gagal mengirim OTP. Silakan coba lagi.';
                        this.messageType = 'error';
                    });
            }
        }">
            <x-input-label for="otp" :value="__('Kode Verifikasi OTP')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="flex gap-4">
                <div class="relative flex-1 group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <x-text-input id="otp" name="otp" type="text" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" required placeholder="123456" />
                </div>
                
                <button type="button" 
                        @click="sendOtp" 
                        :disabled="cooldown > 0 || loading"
                        class="px-6 py-4 bg-gradient-to-r from-red-500 to-amber-500 text-white rounded-2xl text-xs font-black uppercase tracking-wider hover:brightness-110 active:scale-95 disabled:opacity-50 disabled:scale-100 disabled:pointer-events-none transition-all duration-300">
                    <span x-text="loading ? 'Mengirim...' : (cooldown > 0 ? 'Kirim Ulang ('+cooldown+'s)' : 'Minta Kode OTP')"></span>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('otp')" class="mt-2" />
            
            <p x-show="message" 
               :class="messageType === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
               class="text-xs font-bold mt-1" 
               x-text="message"></p>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-8 py-3.5">{{ __('Simpan Kata Sandi') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-2"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-2"
                     x-init="setTimeout(() => show = false, 3000)"
                     class="flex items-center gap-2 text-green-600 dark:text-green-400 font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ __('Berhasil disimpan.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
