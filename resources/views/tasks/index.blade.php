<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white font-poppins">Daftar Tugas</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Temukan tugas yang tersedia atau buat tugas baru</p>
            </div>
            @auth
                @if(Auth::user()->role === 'user')
                    <a href="{{ route('tasks.create') }}" class="btn-premium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Buat Tugas Baru
                    </a>
                @endif
            @endauth
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white dark:bg-[#1E1E1E] p-5 rounded-2xl border border-gray-100 dark:border-white/[0.07] shadow-sm">
            <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="sm:col-span-2">
                    <label for="search" class="form-label">Cari Tugas</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               placeholder="Cari judul, deskripsi, lokasi..."
                               class="form-input pl-10" />
                    </div>
                </div>
                <div>
                    <label for="category_id" class="form-label">Kategori</label>
                    <select id="category_id" name="category_id" class="form-input">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-mtm-red to-mtm-orange text-white rounded-xl font-bold text-sm hover:brightness-110 active:scale-[0.98] transition-all cursor-pointer">
                        Filter
                    </button>
                    <a href="{{ route('tasks.index') }}" class="py-3 px-4 bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-gray-300 rounded-xl font-bold text-sm transition-all text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Task List --}}
        <div class="space-y-4">
            @forelse($tasks as $task)
                @php
                    $statusClass = match($task->status) {
                        'waiting_for_bid' => 'badge-waiting',
                        'bid_received'    => 'badge-bid',
                        'in_progress'     => 'badge-progress',
                        'completed'       => 'badge-complete',
                        'paid'            => 'badge-paid',
                        default           => 'badge-cancel',
                    };
                    $statusLabel = match($task->status) {
                        'waiting_for_bid' => 'Menunggu Bid',
                        'bid_received'    => 'Ada Penawaran',
                        'in_progress'     => 'Dikerjakan',
                        'completed'       => 'Selesai',
                        'paid'            => 'Dibayar',
                        default           => ucfirst(str_replace('_', ' ', $task->status)),
                    };
                @endphp
                <div class="bg-white dark:bg-[#1E1E1E] p-5 md:p-6 rounded-2xl border border-gray-100 dark:border-white/[0.07] shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
                    <div class="flex-1 min-w-0 space-y-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2.5 py-0.5 bg-red-50 dark:bg-red-950/30 text-mtm-red text-[10px] font-bold rounded-full uppercase tracking-wider">
                                {{ $task->category->name }}
                            </span>
                            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate font-poppins">{{ $task->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                        <div class="flex items-center gap-4 text-xs font-medium text-gray-400 dark:text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $task->location }}
                            </span>
                            <span>•</span>
                            <span>{{ $task->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="flex md:flex-col items-center md:items-end justify-between md:justify-center gap-3 w-full md:w-auto border-t md:border-t-0 border-gray-100 dark:border-white/5 pt-4 md:pt-0 shrink-0">
                        <div class="text-left md:text-right">
                            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Budget</p>
                            <p class="text-lg font-black text-mtm-red font-poppins">Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('tasks.show', $task) }}" class="px-5 py-2.5 bg-gradient-to-r from-mtm-red to-mtm-orange text-white rounded-full font-bold text-xs hover:brightness-110 hover:shadow-lg transition-all whitespace-nowrap">
                            Detail →
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-gray-50 dark:bg-white/[0.02] p-16 rounded-2xl text-center border-2 border-dashed border-gray-200 dark:border-white/10">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada tugas yang ditemukan.</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Coba ubah filter atau kata kunci pencarian.</p>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($tasks->hasPages())
                <div class="pt-2">
                    {{ $tasks->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
