<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Tambah Pesan Baru</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kirim pesan chat baru secara manual ke ruang obrolan tertentu.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.messages.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Chat Room ID -->
                <div class="space-y-2">
                    <x-input-label for="chat_room_id" :value="__('Pilih Ruang Chat *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="chat_room_id" name="chat_room_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Ruang Chat --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('chat_room_id') == $room->id ? 'selected' : '' }}>
                                Room #{{ $room->id }} - Tugas: {{ $room->task->title ?? 'N/A' }} (Klien: {{ $room->user->name ?? 'N/A' }} vs Mitra: {{ $room->mitra->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('chat_room_id')" class="mt-1" />
                </div>

                <!-- Sender ID -->
                <div class="space-y-2">
                    <x-input-label for="sender_id" :value="__('Pengirim *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="sender_id" name="sender_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Pengirim --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('sender_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }}) - Peran: {{ strtoupper($user->role) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('sender_id')" class="mt-1" />
                </div>

                <!-- Message -->
                <div class="space-y-2">
                    <x-input-label for="message" :value="__('Isi Pesan')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <textarea id="message" name="message" rows="4" placeholder="Tuliskan isi pesan obrolan..." class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-1" />
                </div>

                <!-- Image -->
                <div class="space-y-2">
                    <x-input-label for="image" :value="__('Lampiran Gambar')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <input id="image" name="image" type="file" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-mtm-red/10 file:text-mtm-red hover:file:bg-mtm-red/20 file:cursor-pointer" />
                    <x-input-error :messages="$errors->get('image')" class="mt-1" />
                </div>

                <!-- Read Status -->
                <div class="space-y-2">
                    <x-input-label for="is_read" :value="__('Status Baca *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="is_read" name="is_read" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="0" {{ old('is_read') == '0' ? 'selected' : '' }}>Belum Dibaca (Terkirim)</option>
                        <option value="1" {{ old('is_read') == '1' ? 'selected' : '' }}>Sudah Dibaca</option>
                    </select>
                    <x-input-error :messages="$errors->get('is_read')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Kirim Pesan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
