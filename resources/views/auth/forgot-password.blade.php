<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Lupa Password?</h2>
        <p class="text-gray-500 dark:text-gray-400">Masukkan alamat email Anda untuk menyetel ulang kata sandi.</p>
    </div>

    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400 font-medium leading-relaxed">
        {{ __('Masukkan alamat email Anda yang terdaftar, dan kami akan mengirimkan tautan penyetelan ulang kata sandi melalui email.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                </div>
                <x-text-input id="email" class="block mt-1 w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full btn-premium !py-4 !text-base">
                {{ __('Kirim Tautan Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
