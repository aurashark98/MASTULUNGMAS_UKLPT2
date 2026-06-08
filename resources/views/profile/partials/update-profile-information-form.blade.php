<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black text-gray-900 dark:text-white">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 font-medium">
            {{ __('Perbarui informasi nama lengkap dan alamat email akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div class="space-y-4" x-data="{ photoPreview: null }">
            <x-input-label for="photo" :value="__('Foto Profil')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            
            <div class="flex flex-col md:flex-row items-center gap-6 p-6 rounded-[2rem] bg-gray-50/50 dark:bg-[#121212]/30 border border-gray-100 dark:border-white/5 transition-all hover:border-mtm-red/20 group">
                <!-- Current Profile Photo / Preview -->
                <div class="relative flex-shrink-0">
                    <div class="w-24 h-24 rounded-[1.8rem] overflow-hidden border-4 border-white dark:border-white/10 shadow-lg group-hover:shadow-mtm-red/10 transition-all duration-500">
                        <template x-if="!photoPreview">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        </template>
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                    </div>
                    
                    <!-- Drag & Drop Overlay Indicator -->
                    <div class="absolute inset-0 rounded-[1.8rem] bg-mtm-red/10 opacity-0 group-hover:opacity-100 border-2 border-dashed border-mtm-red transition-all pointer-events-none flex items-center justify-center">
                        <svg class="w-6 h-6 text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left space-y-3">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ __('Unggah foto terbaik Anda. Mendukung JPG, PNG, atau WebP (Maks 2MB).') }}
                    </p>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <!-- Upload Button -->
                        <button type="button" 
                                @click="$refs.photo.click()" 
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl text-xs font-black uppercase tracking-widest text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10 transition-all active:scale-95">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M16 8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            {{ __('Pilih Foto') }}
                        </button>

                        @if ($user->profile_photo_path)
                            <!-- Remove Button -->
                            <button type="button" 
                                    @click="$refs.removePhotoForm.submit()"
                                    class="inline-flex items-center px-4 py-2 bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 rounded-xl text-xs font-black uppercase tracking-widest text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 transition-all active:scale-95">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                {{ __('Hapus') }}
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Hidden Inputs -->
                <input type="file" class="hidden" x-ref="photo" name="profile_photo"
                       @change="
                            const file = $event.target.files[0];
                            if (! file) return;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL(file);
                       ">
            </div>
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
        </div>

        <form x-ref="removePhotoForm" action="{{ route('profile.photo.destroy') }}" method="POST" class="hidden">
            @csrf
            @method('delete')
        </form>

        <!-- Nama Lengkap -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <x-text-input id="name" name="name" type="text" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Username -->
        <div class="space-y-2">
            <x-input-label for="username" :value="__('Username')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <x-text-input id="username" name="username" type="text" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" :value="old('username', $user->username)" placeholder="johndoe123" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- Alamat Email -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Alamat Email')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                </div>
                <x-text-input id="email" name="email" type="email" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" :value="old('email', $user->email)" required autocomplete="username" placeholder="nama@email.com" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            <!-- Nomor HP -->
            <div class="space-y-2">
                <x-input-label for="phone_number" :value="__('Nomor HP')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                <div class="relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-mtm-red transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <x-text-input id="phone_number" name="phone_number" type="text" class="block w-full !pl-12 !py-4 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" :value="old('phone_number', $user->phone_number)" placeholder="081234567890" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/30">
                    <p class="text-sm text-amber-800 dark:text-amber-300 font-medium">
                        {{ __('Alamat email Anda belum terverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-amber-900 dark:text-amber-200 hover:text-mtm-red font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-mtm-red ml-1">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-sm text-green-600 dark:text-green-400">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-8 py-3.5">{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
