<x-admin-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-xs text-gray-500 mb-1 uppercase font-bold">Total Pengguna</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-xs text-gray-500 mb-1 uppercase font-bold">Total Mitra</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_mitra'] }}</h3>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-xs text-gray-500 mb-1 uppercase font-bold">Total Tugas</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_tasks'] }}</h3>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-xs text-gray-500 mb-1 uppercase font-bold">Tugas Selesai</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_completed_tasks'] }}</h3>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-xs text-gray-500 mb-1 uppercase font-bold">Jumlah Transaksi</p>
                    <h3 class="text-2xl font-bold text-[#10B981]">{{ $stats['total_transactions'] }}</h3>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-xs text-gray-500 mb-1 uppercase font-bold">Total Transaksi (Rp)</p>
                    <h3 class="text-2xl font-bold text-mtm-red">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-xs text-gray-500 mb-1 uppercase font-bold">Rata-Rata Rating</p>
                    <h3 class="text-2xl font-bold text-amber-500">★ {{ number_format($stats['average_rating'], 1) }}</h3>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Recent Tasks -->
                <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-sm rounded-3xl border border-gray-100 dark:border-gray-800">
                    <div class="p-8">
                        <h4 class="text-lg font-bold mb-6 font-poppins">Tugas Terbaru</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-gray-400 text-xs uppercase border-b border-gray-50 dark:border-gray-800">
                                        <th class="pb-4 font-bold">Tugas</th>
                                        <th class="pb-4 font-bold">Status</th>
                                        <th class="pb-4 font-bold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                    @foreach($recent_tasks as $task)
                                        <tr>
                                            <td class="py-4">
                                                <p class="font-bold text-sm">{{ $task->title }}</p>
                                                <p class="text-[10px] text-gray-500">{{ $task->user->name }}</p>
                                            </td>
                                            <td class="py-4">
                                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-[10px] font-bold rounded-full">
                                                    {{ strtoupper($task->status) }}
                                                </span>
                                            </td>
                                            <td class="py-4">
                                                <button class="text-mtm-red hover:underline text-xs font-bold">Detail</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Unverified Mitra -->
                <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-sm rounded-3xl border border-gray-100 dark:border-gray-800">
                    <div class="p-8">
                        <h4 class="text-lg font-bold mb-6 font-poppins">Verifikasi Mitra</h4>
                        <div class="space-y-6">
                            @forelse($unverified_mitra as $mitra)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-mtm-dark/30 rounded-2xl">
                                    <div class="flex items-start gap-3">
                                        @if($mitra->mitraProfile && $mitra->mitraProfile->profile_photo_path)
                                            <img src="{{ asset('storage/' . $mitra->mitraProfile->profile_photo_path) }}" class="w-10 h-10 rounded-full object-cover border border-gray-100 dark:border-gray-800" alt="Foto Profil" />
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-400">
                                                {{ strtoupper(substr($mitra->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-sm leading-tight">{{ $mitra->name }}</p>
                                            <p class="text-[10px] text-gray-500 mb-1">{{ $mitra->email }}</p>
                                            
                                            <div class="flex flex-wrap items-center gap-1.5 text-[9px] font-bold">
                                                @if($mitra->mitraProfile && $mitra->mitraProfile->ktp_path)
                                                    <a href="{{ asset('storage/' . $mitra->mitraProfile->ktp_path) }}" target="_blank" class="text-amber-600 hover:text-amber-500 hover:underline flex items-center gap-0.5">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5l-2-3z"></path></svg>
                                                        Lihat KTP
                                                    </a>
                                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                                @endif
                                                <span class="text-gray-400">
                                                    Keahlian: {{ implode(', ', $mitra->mitraProfile->skills ?? []) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.mitra.verify', $mitra) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2.5 bg-green-600 hover:bg-green-700 transition-colors text-white text-[10px] font-black rounded-xl cursor-pointer shadow-sm">
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.mitra.reject', $mitra) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan mitra ini?')">
                                            @csrf
                                            <button type="submit" class="px-4 py-2.5 bg-mtm-red hover:bg-mtm-red/95 transition-colors text-white text-[10px] font-black rounded-xl cursor-pointer shadow-sm">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">Semua mitra sudah terverifikasi.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
