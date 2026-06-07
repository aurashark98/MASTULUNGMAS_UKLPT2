<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
        <!-- Back Link -->
        <div>
            <a href="{{ route('admin.tasks.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Tugas
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Detail Tugas #{{ $task->id }}</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Task Details Card -->
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm space-y-6">
                    <div>
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-1">Judul Tugas</span>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $task->title }}</h3>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-1">Deskripsi</span>
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $task->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-1">Kategori Jasa</span>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $task->category->name ?? 'Tanpa Kategori' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block mb-1">Lokasi</span>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $task->location }}</p>
                        </div>
                    </div>
                </div>

                <!-- Offers / Bids Card -->
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm space-y-6">
                    <h4 class="text-lg font-bold font-poppins text-gray-800 dark:text-white">Daftar Penawaran Mitra</h4>
                    <div class="space-y-4">
                        @forelse($task->bids as $bid)
                            <div class="p-4 bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-white/5 rounded-2xl flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-bold text-sm text-gray-800 dark:text-white">{{ $bid->mitra->name ?? 'Mitra MTM' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pesan: "{{ $bid->message ?? '-' }}"</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-mtm-red">Rp {{ number_format($bid->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada penawaran masuk dari Mitra.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Status & Client Info Side Card -->
            <div class="space-y-6">
                <!-- Status & Budget Card -->
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-[2rem] border border-gray-200 dark:border-white/5 shadow-sm space-y-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Anggaran Maksimal</span>
                        <p class="text-2xl font-black text-mtm-red">Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Status Tugas</span>
                        @if($task->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-600 dark:text-yellow-400">
                                PENDING
                            </span>
                        @elseif($task->status === 'assigned')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                DITUGASKAN
                            </span>
                        @elseif($task->status === 'completed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-600 dark:text-green-400">
                                SELESAI
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500/10 text-red-600 dark:text-red-400">
                                {{ strtoupper($task->status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Client Info Card -->
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-[2rem] border border-gray-200 dark:border-white/5 shadow-sm space-y-4">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-400">Informasi Pembuat (Klien)</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center font-black text-xs text-mtm-red border border-gray-200 dark:border-white/10">
                            {{ strtoupper(substr($task->user->name ?? 'K', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm text-gray-800 dark:text-white">{{ $task->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $task->user->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assignment Info Card (if assigned) -->
                @if($task->assignment)
                    <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-[2rem] border border-green-100 dark:border-green-950/20 bg-green-50/5 shadow-sm space-y-4">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-green-600 dark:text-green-400">Mitra yang Ditugaskan</h4>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center font-black text-xs text-green-600">
                                {{ strtoupper(substr($task->assignment->mitra->name ?? 'M', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-800 dark:text-white">{{ $task->assignment->mitra->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $task->assignment->mitra->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
