<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
            {{ __('Laporkan Masalah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-mtm-dark-surface p-8 md:p-12 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                <div class="mb-8">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2 font-poppins">Tugas: {{ $task->title }}</h3>
                    <p class="text-sm text-gray-500">Silakan jelaskan masalah yang Anda hadapi. Admin akan meninjau laporan ini dalam waktu 1x24 jam.</p>
                </div>

                <form action="{{ route('disputes.store', $task) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="reason" :value="__('Alasan Pelaporan')" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                        <select id="reason" name="reason" class="w-full border-gray-100 dark:border-white/5 dark:bg-[#121212] focus:border-mtm-red focus:ring-mtm-red rounded-2xl shadow-sm text-sm" required>
                            <option value="">Pilih Alasan</option>
                            <option value="Hasil tidak sesuai deskripsi">Hasil tidak sesuai deskripsi</option>
                            <option value="Mitra tidak dapat dihubungi">Mitra tidak dapat dihubungi</option>
                            <option value="Pekerjaan tidak selesai tepat waktu">Pekerjaan tidak selesai tepat waktu</option>
                            <option value="Perilaku tidak sopan">Perilaku tidak sopan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Deskripsi Masalah')" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                        <textarea id="description" name="description" rows="5" class="w-full border-gray-100 dark:border-white/5 dark:bg-[#121212] focus:border-mtm-red focus:ring-mtm-red rounded-2xl shadow-sm text-sm" placeholder="Ceritakan kronologi kejadian secara detail..." required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="evidence" :value="__('Bukti Foto (Opsional)')" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-100 dark:border-white/5 rounded-[2rem] cursor-pointer hover:bg-gray-50 dark:hover:bg-white/5 transition-all group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-mtm-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-xs text-gray-500 font-bold uppercase tracking-widest">Klik untuk unggah foto</p>
                                </div>
                                <input type="file" id="evidence" name="evidence" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-4 bg-mtm-red text-white rounded-2xl font-black text-sm shadow-lg hover:shadow-mtm-red/20 transition-all active:scale-95">
                            Kirim Laporan Masalah
                        </button>
                        <a href="{{ route('tasks.show', $task) }}" class="block text-center mt-4 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
