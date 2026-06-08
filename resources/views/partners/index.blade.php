<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
            {{ __('Cari Mitra Terbaik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filters -->
            <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm mb-12">
                <form action="{{ route('partners.index') }}" method="GET" class="space-y-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mitra atau keahlian..." class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-black/20 border-transparent rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm transition-all">
                            <svg class="absolute left-4 top-4 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <button type="submit" class="px-8 py-4 bg-mtm-red text-white rounded-2xl font-black text-sm shadow-lg hover:shadow-mtm-red/20 transition-all active:scale-95">
                            Cari Sekarang
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-gray-50 dark:border-white/5">
                        <div class="flex items-center gap-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Kategori:</label>
                            <select name="category" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-bold focus:ring-0 cursor-pointer">
                                <option value="">Semua</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Rating:</label>
                            <select name="rating" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-bold focus:ring-0 cursor-pointer">
                                <option value="">Semua</option>
                                <option value="4.5" {{ request('rating') == '4.5' ? 'selected' : '' }}>4.5+</option>
                                <option value="4.0" {{ request('rating') == '4.0' ? 'selected' : '' }}>4.0+</option>
                                <option value="3.0" {{ request('rating') == '3.0' ? 'selected' : '' }}>3.0+</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Urutkan:</label>
                            <select name="sort" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-bold focus:ring-0 cursor-pointer">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                                <option value="completed" {{ request('sort') == 'completed' ? 'selected' : '' }}>Pekerjaan Terbanyak</option>
                            </select>
                        </div>

                        <label class="flex items-center gap-2 cursor-pointer ml-auto">
                            <input type="checkbox" name="online" value="1" onchange="this.form.submit()" {{ request('online') ? 'checked' : '' }} class="rounded text-mtm-red focus:ring-mtm-red">
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Online Sekarang</span>
                        </label>
                    </div>
                </form>
            </div>

            <!-- Partners Grid -->
            @if($partners->isEmpty())
                <div class="text-center py-24">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2 font-poppins">Mitra Tidak Ditemukan</h3>
                    <p class="text-gray-500">Coba ubah kata kunci atau filter pencarian Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($partners as $partner)
                        <div class="bg-white dark:bg-mtm-dark-surface rounded-[2.5rem] p-8 border border-gray-100 dark:border-white/5 shadow-sm group hover:shadow-xl transition-all duration-500 relative overflow-hidden">
                            <!-- Favorite Heart -->
                            @auth
                                <form action="{{ route('partners.favorite', $partner) }}" method="POST" class="absolute top-6 right-6 z-10">
                                    @csrf
                                    <button type="submit" class="p-3 rounded-2xl bg-gray-50 dark:bg-black/20 text-gray-300 hover:text-mtm-red transition-all {{ $partner->isFavoriteOf(auth()->id()) ? 'text-mtm-red bg-red-50 dark:bg-red-500/10' : '' }}">
                                        <svg class="w-5 h-5 {{ $partner->isFavoriteOf(auth()->id()) ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                </form>
                            @endauth

                            <div class="flex items-center gap-6 mb-8">
                                <div class="relative">
                                    <div class="w-20 h-20 rounded-[1.8rem] overflow-hidden border-4 border-gray-50 dark:border-white/5 shadow-lg group-hover:scale-105 transition-all duration-500">
                                        <img src="{{ $partner->profile_photo_url }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
                                    </div>
                                    @if($partner->mitraProfile->is_online)
                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-4 border-white dark:border-mtm-dark-surface rounded-full"></div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-lg font-black text-gray-900 dark:text-white mb-1 font-poppins">{{ $partner->name }}</h4>
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest border {{ $partner->level_badge }}">
                                            {{ $partner->level }}
                                        </span>
                                        <div class="flex items-center gap-1 text-xs text-yellow-500 font-bold">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            {{ number_format($partner->mitraProfile->rating, 1) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl">
                                    <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Tugas Selesai</p>
                                    <p class="text-sm font-black text-gray-900 dark:text-white">{{ $partner->completed_tasks_count }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl">
                                    <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Review</p>
                                    <p class="text-sm font-black text-gray-900 dark:text-white">{{ $partner->received_reviews_count ?? $partner->receivedReviews->count() }}</p>
                                </div>
                            </div>

                            <div class="space-y-4 mb-8">
                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $partner->mitraProfile->bio }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(array_slice($partner->mitraProfile->skills ?? [], 0, 3) as $skill)
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400 rounded-lg text-[9px] font-bold">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($partner->mitraProfile->skills ?? []) > 3)
                                        <span class="text-[9px] font-bold text-gray-400">+{{ count($partner->mitraProfile->skills) - 3 }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="#" class="flex-1 py-4 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-300 rounded-2xl font-black text-xs uppercase tracking-widest text-center hover:bg-gray-200 transition-all">
                                    Detail Profil
                                </a>
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'mitra-portfolio-{{ $partner->id }}')" class="px-6 py-4 border border-gray-100 dark:border-white/5 rounded-2xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Reusing the Portfolio Modal from Task Show if available, or simplified here -->
                        <x-modal name="mitra-portfolio-{{ $partner->id }}" focusable>
                            <div class="p-8">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden border-2 border-mtm-red/20">
                                        <img src="{{ $partner->profile_photo_url }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-gray-900 dark:text-white font-poppins">{{ $partner->name }}</h3>
                                        <div class="flex items-center gap-3 mt-1">
                                            <div class="flex items-center gap-1 text-xs text-yellow-500 font-bold">
                                                ★ {{ number_format($partner->mitraProfile->rating, 1) }}
                                            </div>
                                            <span class="text-gray-300 dark:text-white/10 text-xs">•</span>
                                            <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">{{ $partner->portfolios->count() }} Portfolio</span>
                                            <span class="text-gray-300 dark:text-white/10 text-xs">•</span>
                                            <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">Gabung {{ $partner->created_at->format('M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                                    <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                        <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Tugas Selesai</p>
                                        <p class="text-sm font-black text-gray-900 dark:text-white">{{ $partner->completed_tasks_count }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                        <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Review</p>
                                        <p class="text-sm font-black text-gray-900 dark:text-white">{{ $partner->receivedReviews->count() }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                        <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Level</p>
                                        <p class="text-sm font-black text-gray-900 dark:text-white">{{ $partner->level }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                        <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Pendapatan</p>
                                        <p class="text-sm font-black text-mtm-red">Rp {{ number_format($partner->mitraProfile->earnings, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <h4 class="text-xs font-black uppercase tracking-widest text-gray-400">Portfolio Terbaru</h4>
                                    
                                    @if($partner->portfolios->isEmpty())
                                        <div class="py-12 text-center bg-gray-50 dark:bg-white/5 rounded-3xl border border-dashed border-gray-200 dark:border-white/10">
                                            <p class="text-sm text-gray-500">Mitra belum menambahkan portfolio.</p>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($partner->portfolios->take(4) as $portfolio)
                                                <div class="bg-gray-50 dark:bg-white/5 rounded-2xl overflow-hidden border border-gray-100 dark:border-white/10 group">
                                                    <div class="h-32 overflow-hidden">
                                                        @if($portfolio->image_path)
                                                            <img src="{{ asset('storage/' . $portfolio->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-500">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="p-4">
                                                        <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-1 truncate">{{ $portfolio->title }}</h5>
                                                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">{{ $portfolio->completed_date->format('M Y') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-8 pt-8 border-t border-gray-100 dark:border-white/5">
                                    <button x-on:click="$dispatch('close')" class="w-full py-4 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-300 rounded-2xl font-black text-sm hover:bg-gray-200 transition-all">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </x-modal>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $partners->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
