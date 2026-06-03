<x-guest-layout>
    <div class="mb-8" x-data="{ role: '{{ request()->query('role', 'user') }}' }">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Buat Akun Baru</h2>
        <p class="text-gray-500 dark:text-gray-400">Gabung dengan komunitas MTM sekarang</p>

        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
            @csrf

            <!-- Role Selection -->
            <div class="space-y-3">
                <x-input-label :value="__('Daftar Sebagai')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="role" value="user" class="hidden peer" x-model="role">
                        <div class="p-4 rounded-2xl border-2 border-gray-100 dark:border-white/10 peer-checked:border-mtm-red peer-checked:bg-mtm-red/5 transition-all flex flex-col items-center gap-2 group-hover:border-mtm-red/50">
                            <svg class="w-6 h-6 text-gray-400 peer-checked:text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-tighter">Pengguna</span>
                        </div>
                    </label>
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="role" value="mitra" class="hidden peer" x-model="role">
                        <div class="p-4 rounded-2xl border-2 border-gray-100 dark:border-white/10 peer-checked:border-mtm-brown peer-checked:bg-mtm-brown/5 transition-all flex flex-col items-center gap-2 group-hover:border-mtm-brown/50">
                            <svg class="w-6 h-6 text-gray-400 peer-checked:text-mtm-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-tighter">Mitra Tulung</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Name -->
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <x-text-input id="name" class="block mt-1 w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                    </div>
                    <x-text-input id="email" class="block mt-1 w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <x-text-input id="password" class="block mt-1 w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" 
                                    placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-white/5 border-gray-100 dark:border-white/10 rounded-2xl focus:ring-mtm-red focus:border-mtm-red"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" 
                                    placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-4">
                <x-primary-button class="w-full btn-premium !py-4 !text-base" :class="role === 'mitra' ? 'from-mtm-brown to-mtm-brown-dark shadow-mtm-brown/30 hover:shadow-mtm-brown/40' : ''">
                    <span x-text="role === 'mitra' ? 'Daftar Jadi Mitra' : 'Daftar Sekarang'">Daftar Sekarang</span>
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="mt-8 text-center border-t border-gray-100 dark:border-white/5 pt-8">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-mtm-red font-bold hover:underline ms-1">Masuk</a>
        </p>
    </div>
</x-guest-layout>
