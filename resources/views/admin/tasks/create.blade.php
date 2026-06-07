<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Tambah Tugas Baru</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Buat tugas/pekerjaan baru untuk dipublikasikan di platform MTM.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.tasks.store') }}" class="space-y-6">
                @csrf

                <!-- Client / User ID -->
                <div class="space-y-2">
                    <x-input-label for="user_id" :value="__('Klien / Pembuat Tugas *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="user_id" name="user_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Klien --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                </div>

                <!-- Category ID -->
                <div class="space-y-2">
                    <x-input-label for="category_id" :value="__('Kategori Jasa *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="category_id" name="category_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
                </div>

                <!-- Title -->
                <div class="space-y-2">
                    <x-input-label for="title" :value="__('Judul Tugas / Pekerjaan *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="title" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="title" :value="old('title')" required placeholder="Contoh: Perbaikan AC Rusak di Rumah" />
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <x-input-label for="description" :value="__('Deskripsi Detail Pekerjaan *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <textarea id="description" name="description" rows="5" required placeholder="Jelaskan detail pekerjaan, kondisi kerusakan, serta persyaratan khusus..." class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <!-- Budget -->
                <div class="space-y-2">
                    <x-input-label for="budget" :value="__('Anggaran (Rp) *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="budget" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="number" name="budget" :value="old('budget')" required placeholder="Masukkan angka anggaran" />
                    <x-input-error :messages="$errors->get('budget')" class="mt-1" />
                </div>

                <!-- Location -->
                <div class="space-y-2">
                    <x-input-label for="location" :value="__('Lokasi Pekerjaan *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="location" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="location" :value="old('location')" required placeholder="Contoh: Lowokwaru, Malang" />
                    <x-input-error :messages="$errors->get('location')" class="mt-1" />
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <x-input-label for="status" :value="__('Status Tugas *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="status" name="status" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending (Mencari Mitra)</option>
                        <option value="assigned" {{ old('status') == 'assigned' ? 'selected' : '' }}>Assigned (Mitra Ditugaskan)</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Simpan Tugas') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
