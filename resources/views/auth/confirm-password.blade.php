<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Konfirmasi Sandi</h2>
        <p class="text-gray-500 dark:text-gray-400">Silakan konfirmasi kata sandi Anda untuk melanjutkan.</p>
    </div>

    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400 font-medium leading-relaxed">
        {{ __('Ini adalah area aman dari aplikasi. Silakan masukkan kata sandi Anda untuk mengonfirmasi tindakan ini sebelum melanjutkan.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />

            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <x-text-input id="password" class="block mt-1 w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full btn-premium !py-4 !text-base">
                {{ __('Konfirmasi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
