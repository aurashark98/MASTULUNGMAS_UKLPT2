<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Kelola Tugas</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar tugas/pekerjaan yang dibuat oleh pengguna di platform MTM.</p>
            </div>
            
            <a href="{{ route('admin.tasks.create') }}" class="px-5 py-3 bg-gradient-to-r from-red-500 to-amber-500 hover:scale-[1.02] hover:shadow-lg hover:shadow-red-500/20 active:scale-[0.98] transition-all text-white font-bold text-sm rounded-2xl flex items-center gap-2 cursor-pointer shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Tugas
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Tasks Table -->
        <div class="bg-white dark:bg-mtm-dark-surface rounded-3xl border border-gray-200 dark:border-white/5 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 dark:text-gray-500 text-xs uppercase font-bold border-b border-gray-100 dark:border-white/5">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Tugas / Pekerjaan</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Klien (Pembuat)</th>
                            <th class="px-6 py-4">Anggaran</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-gray-500 dark:text-gray-400">
                                    #{{ $task->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-sm text-gray-800 dark:text-white leading-tight mb-0.5">{{ $task->title }}</p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">Lokasi: {{ $task->location }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-600 dark:text-gray-400">
                                    {{ $task->category->name ?? 'Tanpa Kategori' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ $task->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-black text-mtm-red">
                                    Rp {{ number_format($task->budget, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($task->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-600 dark:text-yellow-400">
                                            PENDING
                                        </span>
                                    @elseif($task->status === 'assigned')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                            DITUGASKAN
                                        </span>
                                    @elseif($task->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-600 dark:text-green-400">
                                            SELESAI
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-500/10 text-red-600 dark:text-red-400">
                                            {{ strtoupper($task->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.tasks.show', $task) }}" class="p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 rounded-xl transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.tasks.edit', $task) }}" class="p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 rounded-xl transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini? Tindakan ini tidak dapat dibatalkan.')">
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
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                    Tidak ada data tugas/pekerjaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($tasks->hasPages())
                <div class="p-6 border-t border-gray-100 dark:border-white/5">
                    {{ $tasks->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
