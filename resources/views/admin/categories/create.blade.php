<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Tambah Kategori Jasa</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Buat bidang layanan jasa baru di platform MTM.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div class="space-y-2">
                    <x-input-label for="name" :value="__('Nama Kategori *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="name" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Kelistrikan, Kebersihan" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Icon -->
                <div class="space-y-2">
                    <x-input-label for="icon" :value="__('Nama Icon Lucide (Opsional)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="icon" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="icon" :value="old('icon')" placeholder="Contoh: Zap, Sparkles, Clock, Truck" />
                    <x-input-error :messages="$errors->get('icon')" class="mt-1" />
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <x-input-label for="description" :value="__('Deskripsi Kategori')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <textarea id="description" name="description" rows="4" placeholder="Tuliskan deskripsi singkat mengenai cakupan kategori jasa ini..." class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Simpan Kategori') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
