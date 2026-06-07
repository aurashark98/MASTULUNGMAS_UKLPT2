<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Tambah Pengguna Baru</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftarkan akun pengguna, mitra, atau admin baru di MTM.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div class="space-y-2">
                    <x-input-label for="name" :value="__('Nama Lengkap *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="name" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama lengkap" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <x-input-label for="email" :value="__('Email *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="email" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="email" name="email" :value="old('email')" required placeholder="email@contoh.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <x-input-label for="username" :value="__('Username')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="username" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="username" :value="old('username')" placeholder="username_unik" />
                    <x-input-error :messages="$errors->get('username')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('Password *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="password" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="password" name="password" required placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Phone Number -->
                <div class="space-y-2">
                    <x-input-label for="phone_number" :value="__('Nomor HP')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="phone_number" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="phone_number" :value="old('phone_number')" placeholder="Contoh: 08123456789" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <x-input-label for="role" :value="__('Peran / Role *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="role" name="role" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="mitra" {{ old('role') == 'mitra' ? 'selected' : '' }}>Mitra</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>

                <!-- Address -->
                <div class="space-y-2">
                    <x-input-label for="address" :value="__('Alamat')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <textarea id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap..." class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Simpan Pengguna') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
