<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Log Aktivitas Sistem</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar rekaman aksi dan aktivitas penting yang dilakukan oleh pengguna di platform MTM.</p>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Activity Logs Table -->
        <div class="bg-white dark:bg-mtm-dark-surface rounded-3xl border border-gray-200 dark:border-white/5 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 dark:text-gray-500 text-xs uppercase font-bold border-b border-gray-100 dark:border-white/5">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Aksi / Action</th>
                            <th class="px-6 py-4">Deskripsi</th>
                            <th class="px-6 py-4">Waktu Kejadian</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-gray-500 dark:text-gray-400">
                                    #{{ $log->id }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ $log->user->name ?? 'Sistem / Guest' }}
                                    <span class="text-[10px] text-gray-400 font-medium block">ID: #{{ $log->user_id ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-mtm-red bg-mtm-red/[0.02]">
                                    {{ $log->action }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 font-medium max-w-sm">
                                    {{ $log->description }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-650 dark:text-gray-500 font-medium">
                                    {{ $log->created_at->format('d M Y H:i:s') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <form action="{{ route('admin.activity-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus log ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500/20 rounded-xl transition-all cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                    Tidak ada catatan log aktivitas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($logs->hasPages())
                <div class="p-6 border-t border-gray-100 dark:border-white/5">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
