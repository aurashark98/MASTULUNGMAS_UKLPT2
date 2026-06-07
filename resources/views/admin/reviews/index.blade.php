<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Kelola Ulasan Mitra</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar ulasan dan rating yang diberikan oleh klien kepada mitra atas tugas yang diselesaikan.</p>
            </div>
            
            <a href="{{ route('admin.reviews.create') }}" class="px-5 py-3 bg-gradient-to-r from-red-500 to-amber-500 hover:scale-[1.02] hover:shadow-lg hover:shadow-red-500/20 active:scale-[0.98] transition-all text-white font-bold text-sm rounded-2xl flex items-center gap-2 cursor-pointer shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Ulasan
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Reviews Table -->
        <div class="bg-white dark:bg-mtm-dark-surface rounded-3xl border border-gray-200 dark:border-white/5 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 dark:text-gray-500 text-xs uppercase font-bold border-b border-gray-100 dark:border-white/5">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Tugas</th>
                            <th class="px-6 py-4">Klien (Penulis)</th>
                            <th class="px-6 py-4">Mitra (Penerima)</th>
                            <th class="px-6 py-4">Rating</th>
                            <th class="px-6 py-4">Komentar</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        @forelse($reviews as $review)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-gray-500 dark:text-gray-400">
                                    #{{ $review->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-sm text-gray-800 dark:text-white leading-tight">{{ $review->task->title ?? 'Tugas Terhapus' }}</p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500">ID Tugas: #{{ $review->task_id }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ $review->user->name ?? 'User Terhapus' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ $review->mitra->name ?? 'Mitra Terhapus' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-black text-amber-500">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span>{{ $review->rating }} / 5</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                    {{ $review->comment ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.reviews.edit', $review) }}" class="p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 rounded-xl transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
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
                                    Tidak ada data ulasan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($reviews->hasPages())
                <div class="p-6 border-t border-gray-100 dark:border-white/5">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
