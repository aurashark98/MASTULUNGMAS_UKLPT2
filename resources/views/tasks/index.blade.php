<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Search & Filter Card -->
            <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-[2rem] border border-gray-150 dark:border-white/5 shadow-sm">
                <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Cari Tugas</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan judul, deskripsi, lokasi..." 
                               class="w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl text-sm p-3.5 focus:ring-mtm-red focus:border-mtm-red text-gray-700 dark:text-white" />
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Kategori Jasa</label>
                        <select id="category_id" name="category_id" 
                                class="w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl text-sm p-3.5 focus:ring-mtm-red focus:border-mtm-red text-gray-700 dark:text-gray-300">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 py-3.5 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-2xl font-bold text-xs shadow-lg hover:shadow-mtm-red/20 active:scale-[0.98] transition-all cursor-pointer text-center">
                            Filter
                        </button>
                        <a href="{{ route('tasks.index') }}" class="py-3.5 px-4 bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-gray-300 rounded-2xl font-bold text-xs transition-all text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tasks Listing Grid -->
            <div class="space-y-6">
                @forelse($tasks as $task)
                    <div class="bg-white dark:bg-mtm-dark-surface p-6 md:p-8 rounded-[2rem] border border-gray-150 dark:border-white/5 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="space-y-2.5 flex-1 min-w-0">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2.5 py-0.5 bg-red-500/10 text-mtm-red text-[10px] font-bold rounded-full uppercase tracking-wider">
                                    {{ $task->category->name }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Status: 
                                    <span class="text-amber-500 font-black">{{ str_replace('_', ' ', $task->status) }}</span>
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white truncate font-poppins">{{ $task->title }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                            
                            <div class="flex items-center gap-4 text-xs font-semibold text-gray-400 pt-1">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $task->location }}
                                </span>
                                <span>•</span>
                                <span>Diposting {{ $task->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Right Panel: Budget & Action -->
                        <div class="text-left md:text-right border-t md:border-t-0 border-gray-100 dark:border-white/5 pt-4 md:pt-0 w-full md:w-auto flex md:flex-col justify-between md:justify-center items-center md:items-end gap-3 flex-shrink-0">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Budget Maksimal</p>
                                <p class="text-xl font-black text-mtm-red font-poppins">Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                            </div>
                            
                            <a href="{{ route('tasks.show', $task) }}" class="px-6 py-3 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-full font-bold text-xs hover:shadow-lg transition-all text-center">
                                Detail Tugas
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white/40 dark:bg-mtm-dark-surface/40 p-16 rounded-[2.5rem] text-center border border-dashed border-gray-200 dark:border-white/5">
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada tugas yang ditemukan.</p>
                    </div>
                @endforelse

                <!-- Pagination Links -->
                <div class="pt-4">
                    {{ $tasks->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
