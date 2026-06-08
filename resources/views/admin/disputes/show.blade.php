<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.disputes.index') }}" class="p-2 bg-white dark:bg-mtm-dark-surface rounded-xl border border-gray-100 dark:border-white/5 text-gray-400 hover:text-mtm-red transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
                {{ __('Detail Laporan Masalah') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Dispute Content -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-mtm-dark-surface p-8 md:p-12 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-mtm-red mb-2 block">Alasan: {{ $dispute->reason }}</span>
                                <h3 class="text-3xl font-black text-gray-900 dark:text-white font-poppins">{{ $dispute->task->title }}</h3>
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

                        <div class="space-y-10">
                            <section>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Kronologi Masalah</h4>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">{{ $dispute->description }}</p>
                            </section>

                            @if($dispute->evidence_path)
                                <section>
                                    <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Bukti Pendukung (Pelapor)</h4>
                                    <div class="w-full max-w-lg rounded-[2rem] overflow-hidden border border-gray-100 dark:border-white/5 shadow-lg">
                                        <img src="{{ $dispute->evidence_url }}" class="w-full h-auto cursor-pointer hover:scale-105 transition-transform duration-500" @click="$dispatch('open-modal', 'view-evidence')">
                                    </div>
                                </section>
                            @endif

                            @if($dispute->partner_response)
                                <section class="border-t border-gray-100 dark:border-white/5 pt-10">
                                    <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Tanggapan Terlapor</h4>
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $dispute->partner_response }}</p>
                                    
                                    @if($dispute->partner_evidence_path)
                                        <div class="mt-6 w-full max-w-lg rounded-[2rem] overflow-hidden border border-gray-100 dark:border-white/5 shadow-lg">
                                            <img src="{{ $dispute->partner_evidence_url }}" class="w-full h-auto cursor-pointer hover:scale-105 transition-transform duration-500" @click="$dispatch('open-modal', 'view-partner-evidence')">
                                        </div>
                                    @endif
                                </section>
                            @endif

                            @if($dispute->resolution)
                                <section class="bg-gray-50 dark:bg-black/20 p-8 rounded-[2rem] border border-gray-100 dark:border-white/5">
                                    <h4 class="text-[10px] font-black uppercase tracking-widest text-mtm-red mb-4">Resolusi Admin</h4>
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $dispute->resolution }}</p>
                                    <div class="mt-6 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center text-white dark:text-gray-900 text-[10px] font-black">MTM</div>
                                        <div class="text-[10px] font-black uppercase tracking-widest text-gray-400">
                                            Diselesaikan oleh {{ $dispute->resolver->name }} • {{ $dispute->resolved_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </section>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Admin Actions Sidebar -->
                <div class="space-y-8">
                    <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-6">Pihak Terlibat</h4>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4 p-4 bg-gray-50/50 dark:bg-white/5 rounded-2xl">
                                <div class="w-10 h-10 rounded-xl overflow-hidden">
                                    <img src="{{ $dispute->reporter->profile_photo_url }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Pelapor</p>
                                    <p class="text-sm font-bold">{{ $dispute->reporter->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-gray-50/50 dark:bg-white/5 rounded-2xl">
                                <div class="w-10 h-10 rounded-xl overflow-hidden">
                                    <img src="{{ $dispute->reportedUser->profile_photo_url }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Terlapor</p>
                                    <p class="text-sm font-bold">{{ $dispute->reportedUser->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($dispute->status !== 'resolved' && $dispute->status !== 'rejected')
                        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-lg">
                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 dark:text-white mb-6">Tindakan Admin</h4>
                            <form action="{{ route('admin.disputes.update-status', $dispute) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('patch')
                                <div>
                                    <x-input-label for="status" :value="__('Status Baru')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2" />
                                    <select id="status" name="status" class="w-full border-gray-100 dark:border-white/5 dark:bg-[#121212] focus:border-mtm-red focus:ring-mtm-red rounded-2xl shadow-sm text-sm" required>
                                        <option value="investigating" {{ $dispute->status === 'investigating' ? 'selected' : '' }}>Investigasi</option>
                                        <option value="resolved">Selesaikan (Resolved)</option>
                                        <option value="rejected">Tolak (Rejected)</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="resolution" :value="__('Catatan Resolusi')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2" />
                                    <textarea id="resolution" name="resolution" rows="4" class="w-full border-gray-100 dark:border-white/5 dark:bg-[#121212] focus:border-mtm-red focus:ring-mtm-red rounded-2xl shadow-sm text-sm" placeholder="Berikan keputusan atau instruksi penyelesaian..."></textarea>
                                </div>
                                <button type="submit" class="w-full py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all">
                                    Update Laporan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Evidence Preview Modal -->
    <x-modal name="view-evidence" focusable>
        <div class="p-4">
            <img src="{{ $dispute->evidence_url }}" class="w-full h-auto rounded-3xl">
            <div class="mt-4 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Tutup</x-secondary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="view-partner-evidence" focusable>
        <div class="p-4">
            <img src="{{ $dispute->partner_evidence_url }}" class="w-full h-auto rounded-3xl">
            <div class="mt-4 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Tutup</x-secondary-button>
            </div>
        </div>
    </x-modal>
</x-app-layout>
