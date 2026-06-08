<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
                {{ __('Detail Laporan Masalah') }}
            </h2>
            <a href="{{ route('disputes.index') }}" class="text-xs font-black uppercase tracking-widest text-gray-500 hover:text-mtm-red transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Dispute Info -->
                    <div class="bg-white dark:bg-mtm-dark-surface p-8 md:p-10 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2 font-poppins">{{ $dispute->task->title }}</h3>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Alasan: {{ $dispute->reason }}</p>
                            </div>
                            @php
                                $statusClasses = match($dispute->status) {
                                    'open' => 'bg-blue-100 text-blue-700',
                                    'investigating' => 'bg-yellow-100 text-yellow-700',
                                    'resolved' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                };
                            @endphp
                            <span class="px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest {{ $statusClasses }}">
                                {{ $dispute->status }}
                            </span>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-3">Deskripsi Masalah</h4>
                                <div class="p-6 bg-gray-50 dark:bg-black/20 rounded-2xl text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $dispute->description }}
                                </div>
                            </div>

                            @if($dispute->evidence_path)
                                <div>
                                    <h4 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-3">Bukti Pelapor</h4>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="relative group aspect-video overflow-hidden rounded-2xl border border-gray-100 dark:border-white/5">
                                            <img src="{{ $dispute->evidence_url }}" alt="Evidence" class="w-full h-full object-cover">
                                            <a href="{{ $dispute->evidence_url }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-black text-xs uppercase tracking-widest">
                                                Lihat Gambar Penuh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Partner Response -->
                    @if($dispute->partner_response)
                        <div class="bg-white dark:bg-mtm-dark-surface p-8 md:p-10 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6 font-poppins">Tanggapan Pihak Terlapor</h3>
                            <div class="space-y-6">
                                <div class="p-6 bg-gray-50 dark:bg-black/20 rounded-2xl text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $dispute->partner_response }}
                                </div>

                                @if($dispute->partner_evidence_path)
                                    <div>
                                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-3">Bukti Tanggapan</h4>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div class="relative group aspect-video overflow-hidden rounded-2xl border border-gray-100 dark:border-white/5">
                                                <img src="{{ $dispute->partner_evidence_url }}" alt="Partner Evidence" class="w-full h-full object-cover">
                                                <a href="{{ $dispute->partner_evidence_url }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-black text-xs uppercase tracking-widest">
                                                    Lihat Gambar Penuh
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif(Auth::id() === $dispute->reported_user_id && $dispute->status !== 'resolved' && $dispute->status !== 'rejected')
                        <!-- Response Form for Reported User -->
                        <div class="bg-white dark:bg-mtm-dark-surface p-8 md:p-10 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6 font-poppins">Berikan Tanggapan</h3>
                            <form action="{{ route('disputes.respond', $dispute) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <div>
                                    <x-input-label for="partner_response" :value="__('Penjelasan Anda')" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                                    <textarea id="partner_response" name="partner_response" rows="5" class="w-full border-gray-100 dark:border-white/5 dark:bg-[#121212] focus:border-mtm-red focus:ring-mtm-red rounded-2xl shadow-sm text-sm" placeholder="Berikan penjelasan Anda terkait masalah ini..." required>{{ old('partner_response') }}</textarea>
                                    <x-input-error :messages="$errors->get('partner_response')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="partner_evidence" :value="__('Bukti Foto (Opsional)')" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                                    <div class="flex items-center justify-center w-full">
                                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-100 dark:border-white/5 rounded-[2rem] cursor-pointer hover:bg-gray-50 dark:hover:bg-white/5 transition-all group">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-mtm-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                <p class="mb-2 text-xs text-gray-500 font-bold uppercase tracking-widest">Klik untuk unggah bukti</p>
                                            </div>
                                            <input type="file" id="partner_evidence" name="partner_evidence" class="hidden" accept="image/*" />
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('partner_evidence')" class="mt-2" />
                                </div>

                                <button type="submit" class="w-full py-4 bg-mtm-red text-white rounded-2xl font-black text-sm shadow-lg hover:shadow-mtm-red/20 transition-all active:scale-95">
                                    Kirim Tanggapan
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Resolution -->
                    @if($dispute->resolution)
                        <div class="bg-mtm-red/5 p-8 md:p-10 rounded-[2.5rem] border border-mtm-red/10 shadow-sm">
                            <h3 class="text-xl font-black text-mtm-red mb-6 font-poppins">Resolusi Admin</h3>
                            <div class="space-y-4">
                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $dispute->resolution }}
                                </div>
                                <div class="pt-4 border-t border-mtm-red/10 flex items-center justify-between">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Diselesaikan oleh: {{ $dispute->resolver->name }}</span>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ $dispute->resolved_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-8">
                    <!-- Task Summary -->
                    <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-6">Informasi Tugas</h4>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-black/20 flex items-center justify-center text-mtm-red">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Status Tugas</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white uppercase">{{ $dispute->task->status }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-black/20 flex items-center justify-center text-mtm-red">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V15m0 1v-8m0 0H8m4 0h4m-4 8H8m4 0h4"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Anggaran</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($dispute->task->budget, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('tasks.show', $dispute->task) }}" class="block w-full py-3 text-center bg-gray-50 dark:bg-black/20 text-gray-600 dark:text-gray-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-black/40 transition-all">
                                Lihat Detail Tugas
                            </a>
                        </div>
                    </div>

                    <!-- Involved Parties -->
                    <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-500 mb-6">Pihak Terlibat</h4>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ $dispute->reporter->profile_photo_url }}" class="w-12 h-12 rounded-2xl object-cover">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Pelapor</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $dispute->reporter->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <img src="{{ $dispute->reportedUser->profile_photo_url }}" class="w-12 h-12 rounded-2xl object-cover">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Terlapor</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $dispute->reportedUser->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
