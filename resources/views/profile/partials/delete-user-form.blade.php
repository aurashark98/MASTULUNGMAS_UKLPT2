<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black text-red-600 dark:text-red-500">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 font-medium">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun, silakan unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <div class="pt-2">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-8 py-3.5 shadow-lg shadow-red-500/20"
        >
            {{ __('Hapus Akun Saya') }}
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 md:p-10 space-y-6 bg-white dark:bg-[#1e1e1e]">
            @csrf
            @method('delete')

            <div class="space-y-2">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white flex items-center gap-3">
                    <svg class="w-8 h-8 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    {{ __('Apakah Anda yakin ingin menghapus akun?') }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium leading-relaxed">
                    {{ __('Setelah akun Anda dihapus, semua data akan hilang selamanya. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini secara permanen.') }}
                </p>
            </div>

            <div class="space-y-2">
                <x-input-label for="password" value="{{ __('Kata Sandi Konfirmasi') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500" />

                <div class="relative group max-w-md">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl"
                        placeholder="{{ __('Kata Sandi Konfirmasi') }}"
                    />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100 dark:border-white/5">
                <x-secondary-button x-on:click="$dispatch('close')" class="px-8 py-3.5">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="px-8 py-3.5 shadow-lg shadow-red-500/20">
                    {{ __('Hapus Akun Secara Permanen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
