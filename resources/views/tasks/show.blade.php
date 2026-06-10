<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.3] pointer-events-none z-0"></div>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10 space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-white/5 pb-4">
            <div class="flex items-center gap-4">
                <a href="{{ Auth::user()->role === 'mitra' ? route('mitra.dashboard') : (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')) }}" 
                   class="p-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 rounded-full border border-gray-200 dark:border-white/5 shadow-sm transition-all flex items-center justify-center cursor-pointer" 
                   title="Kembali ke Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black heading-gradient">
                        {{ __('Detail Tugas') }}
                    </h1>
                    <p class="text-xs text-gray-500 mt-1">
                        Diposting {{ $task->created_at->diffForHumans() }} • Kategori: <span class="font-bold text-mtm-red">{{ $task->category->name }}</span>
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if(Auth::id() === $task->user_id && ($task->status === 'waiting_for_bid' || $task->status === 'bid_received'))
                    <button @click="$dispatch('open-live-negotiation')" class="px-4 py-2 bg-gradient-to-r from-mtm-red to-mtm-red-dark hover:from-mtm-red-dark hover:to-mtm-red text-white text-xs font-bold rounded-full shadow-md hover:shadow-mtm-red/25 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                        Live Negosiasi Harga
                    </button>
                    <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-full hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                        Edit Tugas
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-full transition-all cursor-pointer">
                            Hapus Tugas
                        </button>
                    </form>
                @endif
                
                <span class="px-4 py-2 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 text-xs font-black rounded-full uppercase tracking-wider">
                    {{ str_replace('_', ' ', $task->status) }}
                </span>
            </div>
        </div>
            @if(session('success'))
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 overflow-hidden shadow-xl sm:rounded-3xl p-6 text-white animate-fade-in border border-emerald-400/20">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white border border-white/20 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-black font-poppins">Sukses!</h4>
                            <p class="text-xs text-emerald-100 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>

                @if(session('success') == 'Tugas berhasil dibuat!')
                    <!-- Broadcast Radar Popup -->
                    <div x-data="{ 
                            showRadar: true, 
                            init() {
                                setTimeout(() => { this.showRadar = false }, 4000);
                            }
                         }" 
                         x-show="showRadar"
                         class="fixed inset-0 bg-black/90 backdrop-blur-md flex flex-col items-center justify-center p-4 z-[100] text-white text-center space-y-8"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-cloak>
                        
                        <div class="relative w-56 h-56 flex items-center justify-center">
                            <div class="absolute w-56 h-56 rounded-full border-2 border-red-500/15 animate-ping"></div>
                            <div class="absolute w-44 h-44 rounded-full border-2 border-red-500/25 animate-pulse"></div>
                            <div class="absolute w-32 h-32 rounded-full border-2 border-red-500/35 animate-ping" style="animation-delay:0.5s"></div>
                            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-red-500 to-rose-600 flex flex-col items-center justify-center shadow-2xl shadow-red-500/40 text-white font-black text-xs">
                                <svg class="w-7 h-7 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                MTM
                            </div>
                        </div>

                        <div class="space-y-3 max-w-sm">
                            <h4 class="text-2xl font-black font-poppins">Menyiarkan Tugas...</h4>
                            <p class="text-sm text-red-200 leading-relaxed">Tugas Anda sedang disiarkan ke para Mitra aktif. Tunggu beberapa saat atau kembali ke Dashboard untuk melihat penawaran yang masuk.</p>
                        </div>
                    </div>
                @endif
            @endif

            @if(session('error'))
                <div class="bg-gradient-to-r from-red-500 to-rose-600 overflow-hidden shadow-xl sm:rounded-3xl p-6 text-white animate-fade-in border border-rose-400/20">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white border border-white/20 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-black font-poppins">Gagal!</h4>
                            <p class="text-xs text-rose-100 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Task Details -->
                <div class="md:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-xl sm:rounded-3xl p-8">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-red-50 dark:bg-red-950/20 text-mtm-red text-[10px] font-bold rounded-full uppercase">
                            {{ $task->category->name }}
                        </span>
                        <span class="text-xs text-gray-500">• Diposting {{ $task->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-poppins">{{ $task->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">{{ $task->description }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <div>
                            @if($task->is_quick_help && ($task->status === 'completed' || $task->status === 'paid'))
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1 font-poppins">Total Telah Dibayar (Tunai)</p>
                            @else
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1 font-poppins">Total Biaya (Budget)</p>
                            @endif
                            <p class="text-xl font-bold text-mtm-red">Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1 font-poppins">Estimasi Jarak</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ floatval($task->distance) }} Km</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1 font-poppins">Estimasi Durasi</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $task->duration }} Jam</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 mt-8 border-t border-gray-100 dark:border-gray-800">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1 font-poppins">Lokasi Asal (Mulai)</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white whitespace-pre-line leading-relaxed" title="{{ $task->location }}">{{ $task->location }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1 font-poppins">Lokasi Tujuan (Akhir)</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white whitespace-pre-line leading-relaxed" title="{{ $task->destination_location ?? '-' }}">{{ $task->destination_location ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Peta Lokasi Tugas -->
                    <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <p class="text-xs text-gray-400 uppercase font-bold mb-4">Peta Lokasi Tugas</p>
                        <div class="relative">
                            <div id="detail-map" class="w-full rounded-2xl border border-gray-300 dark:border-gray-700 shadow-inner z-10" style="height: 500px;"></div>
                            <div id="detail-map-loading" class="absolute inset-0 bg-white/80 dark:bg-black/80 rounded-2xl flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-400 z-20">
                                <span class="animate-pulse">Mendeteksi lokasi tugas di peta...</span>
                            </div>
                        </div>
                    </div>

                    @if($task->images)
                        <div class="mt-8">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-4">Foto Lampiran</p>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach($task->images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-32 object-cover rounded-2xl" alt="Task Image">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Bids / Assignment Section (Visible to User/Owner) -->
                @if(Auth::id() === $task->user_id)
                    @if($task->assignment)
                        <div class="space-y-6">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Mitra Ditugaskan</h4>
                            <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex-shrink-0 overflow-hidden">
                                        @if($task->assignment->mitra->mitraProfile && $task->assignment->mitra->mitraProfile->profile_photo_path)
                                            <img src="{{ asset('storage/' . $task->assignment->mitra->mitraProfile->profile_photo_path) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-gray-400 uppercase tracking-widest font-black block">Penyedia Jasa</span>
                                        <h5 class="font-bold text-sm text-gray-900 dark:text-white">{{ $task->assignment->mitra->name }}</h5>
                                        <div class="flex items-center gap-1 text-xs text-yellow-500">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span class="font-bold">{{ number_format($task->assignment->mitra->mitraProfile->rating ?? 5.0, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-400 block mb-1">Status Pengerjaan</span>
                                    <span class="px-3 py-1 bg-green-50 dark:bg-green-950/20 text-green-700 dark:text-green-400 text-xs font-bold rounded-full uppercase">
                                        {{ str_replace('_', ' ', $task->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Penawaran Masuk ({{ $task->bids->count() }})</h4>
                                @if($task->status === 'waiting_for_bid' || $task->status === 'bid_received')
                                    <button onclick="window.dispatchEvent(new CustomEvent('open-live-negotiation'))" class="px-4 py-2 bg-mtm-red/10 text-mtm-red hover:bg-mtm-red/20 text-xs font-bold rounded-xl transition-all flex items-center gap-2 cursor-pointer border border-mtm-red/20">
                                        <span class="w-2 h-2 rounded-full bg-mtm-red animate-ping"></span>
                                        Buka Radar Mitra
                                    </button>
                                @endif
                            </div>
                            @forelse($task->bids as $bid)
                            <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full flex-shrink-0 overflow-hidden border border-gray-100 dark:border-white/5">
                                        <img src="{{ $bid->mitra->profile_photo_url }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                            <div class="flex items-center gap-2">
                                                <h5 class="font-bold text-sm">{{ $bid->mitra->name }}</h5>
                                                <span class="px-2 py-0.5 rounded-full text-[7px] font-black uppercase tracking-widest border {{ $bid->mitra->level_badge }}">
                                                    {{ $bid->mitra->level }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1 text-xs text-yellow-500">
                                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                <span class="font-bold">{{ number_format($bid->mitra->mitraProfile->rating, 1) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg text-mtm-red mb-2">Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}</p>
                                        <div class="flex flex-col gap-2">
                                            @if($task->status === 'bid_received' || $task->status === 'waiting_for_bid')
                                                <form action="{{ route('bids.accept', $bid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-full text-xs font-bold hover:shadow-lg transition-all">
                                                        Terima Penawaran
                                                    </button>
                                                </form>
                                            @endif
                                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'mitra-portfolio-{{ $bid->mitra_id }}')" class="px-6 py-2 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-300 rounded-full text-xs font-bold hover:bg-gray-200 transition-all">
                                                Lihat Portfolio
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Portfolio Preview Modal -->
                                <x-modal name="mitra-portfolio-{{ $bid->mitra_id }}" focusable>
                                    <div class="p-8">
                                        <div class="flex items-center gap-4 mb-8">
                                            <div class="w-16 h-16 rounded-2xl overflow-hidden border-2 border-mtm-red/20">
                                                <img src="{{ $bid->mitra->profile_photo_url }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-3">
                                                    <h3 class="text-xl font-black text-gray-900 dark:text-white font-poppins">{{ $bid->mitra->name }}</h3>
                                                    <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest border {{ $bid->mitra->level_badge }}">
                                                        {{ $bid->mitra->level }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <div class="flex items-center gap-1 text-xs text-yellow-500 font-bold">
                                                        ★ {{ number_format($bid->mitra->mitraProfile->rating, 1) }}
                                                    </div>
                                                    <span class="text-gray-300 dark:text-white/10 text-xs">•</span>
                                                    <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">{{ $bid->mitra->portfolios->count() }} Portfolio</span>
                                                    <span class="text-gray-300 dark:text-white/10 text-xs">•</span>
                                                    <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">Gabung {{ $bid->mitra->created_at->format('M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                                            <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                                <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Tugas Selesai</p>
                                                <p class="text-sm font-black text-gray-900 dark:text-white">{{ $bid->mitra->completed_tasks_count }}</p>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                                <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Review</p>
                                                <p class="text-sm font-black text-gray-900 dark:text-white">{{ $bid->mitra->receivedReviews->count() }}</p>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                                <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Level</p>
                                                <p class="text-sm font-black text-gray-900 dark:text-white">{{ $bid->mitra->level }}</p>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl text-center">
                                                <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Pendapatan</p>
                                                <p class="text-sm font-black text-mtm-red">Rp {{ number_format($bid->mitra->mitraProfile->earnings, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <div class="space-y-6">
                                            <h4 class="text-xs font-black uppercase tracking-widest text-gray-400">Portfolio Terbaru</h4>
                                            
                                            @if($bid->mitra->portfolios->isEmpty())
                                                <div class="py-12 text-center bg-gray-50 dark:bg-white/5 rounded-3xl border border-dashed border-gray-200 dark:border-white/10">
                                                    <p class="text-sm text-gray-500">Mitra belum menambahkan portfolio.</p>
                                                </div>
                                            @else
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    @foreach($bid->mitra->portfolios->take(4) as $portfolio)
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
                            @empty
                                <div class="bg-gray-50 dark:bg-mtm-dark/50 p-12 rounded-3xl text-center">
                                    <p class="text-gray-500">Belum ada penawaran masuk.</p>
                                </div>
                            @endforelse
                        </div>
                    @endif

                    <!-- Reviews Section -->
                    @if($task->status === 'completed' && ($task->is_quick_help || ($task->payment && $task->payment->status === 'completed')))
                        @if(!$task->review)
                            <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm space-y-6">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white font-poppins">Berikan Ulasan Layanan</h4>
                                    <p class="text-xs text-gray-500 font-medium">Bantu Mitra meningkatkan layanan mereka dengan memberikan rating dan ulasan jujur.</p>
                                </div>
                                
                                <form action="{{ route('tasks.review.store', $task) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Rating</label>
                                        <div class="flex items-center gap-2" x-data="{ rating: 5, hoverRating: 5 }">
                                            <input type="hidden" name="rating" :value="rating">
                                            <template x-for="i in 5">
                                                <button type="button" @click="rating = i" @mouseenter="hoverRating = i" @mouseleave="hoverRating = rating" class="text-2xl focus:outline-none transition-colors duration-150" :class="i <= hoverRating ? 'text-yellow-500' : 'text-gray-300 dark:text-white/10'">
                                                    ★
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Ulasan</label>
                                        <textarea name="comment" rows="3" class="w-full bg-white dark:bg-black/20 border-gray-200 dark:border-white/10 rounded-2xl text-sm focus:ring-mtm-red focus:border-mtm-red" placeholder="Bagikan pengalaman Anda bekerja dengan Mitra..."></textarea>
                                    </div>
                                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-2xl font-bold shadow-lg hover:shadow-mtm-red/25 transition-all text-sm">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm space-y-4">
                                <h4 class="font-bold text-gray-900 dark:text-white font-poppins">Ulasan Konsumen</h4>
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center text-yellow-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-lg">{{ $i <= $task->review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500">• {{ $task->review->created_at->diffForHumans() }}</span>
                                </div>
                                @if($task->review->comment)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 italic">"{{ $task->review->comment }}"</p>
                                @endif
                            </div>
                        @endif
                    @endif
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <h4 class="font-bold mb-4 font-poppins">Pembuat Tugas</h4>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden border border-gray-100 dark:border-white/5">
                            <img src="{{ $task->user->profile_photo_url }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-sm">{{ $task->user->name }}</p>
                            <p class="text-xs text-gray-500">Anggota sejak {{ $task->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Panel -->
                @php
                    $chatRoom = \App\Models\ChatRoom::where('task_id', $task->id)->first();
                @endphp
                @if($chatRoom && (Auth::id() === $task->user_id || Auth::id() === $chatRoom->mitra_id))
                    <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                        <h4 class="font-bold mb-2 font-poppins text-gray-900 dark:text-white">Diskusi Pekerjaan</h4>
                        <p class="text-xs text-gray-500 mb-6 font-medium">Hubungi partner kerja Anda langsung melalui chat internal MTM.</p>
                        <a href="{{ route('chat.show', $chatRoom) }}" class="w-full flex items-center justify-center gap-2 py-4 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-2xl font-bold shadow-lg hover:shadow-mtm-red/25 transition-all text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            Buka Chat Room
                        </a>
                    </div>
                @endif

                <!-- Payment Panel -->
                @if(Auth::id() === $task->user_id && $task->status === 'bid_accepted')
                    @if($task->payment && $task->payment->status === 'pending')
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-8 rounded-3xl text-white shadow-xl">
                            <h4 class="font-bold mb-2 font-poppins text-white">Pembayaran Sedang Diverifikasi</h4>
                            <p class="text-xs text-blue-100 mb-4 font-medium">Anda telah berhasil mengunggah bukti pembayaran QRIS sebesar Rp {{ number_format($task->budget, 0, ',', '.') }}. Mohon tunggu Admin memverifikasi pembayaran tersebut untuk menugaskan Mitra ke lokasi Anda.</p>
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/10 text-white font-bold text-xs">
                                <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse"></span>
                                Menunggu Verifikasi Admin
                            </div>
                        </div>
                    @elseif(!$task->payment || $task->payment->status !== 'completed')
                        <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-8 rounded-3xl text-white shadow-xl animate-pulse-slow">
                            <h4 class="font-bold mb-2 font-poppins text-white">Segera Selesaikan Pembayaran</h4>
                            <p class="text-xs text-amber-100 mb-6 font-medium">Anda telah menyetujui penawaran harga. Silakan lakukan pembayaran sebesar Rp {{ number_format($task->budget, 0, ',', '.') }} agar Mitra dapat segera menuju lokasi dan memulai pekerjaan.</p>
                            <a href="{{ route('tasks.pay', $task) }}" class="w-full flex items-center justify-center py-4 bg-white text-amber-600 hover:bg-amber-50 rounded-2xl font-bold shadow-lg transition-all text-sm">
                                Bayar Sekarang
                            </a>
                        </div>
                    @endif
                @endif

                <!-- Mitra Panel Action -->
                @if(Auth::user()->role === 'mitra' && $task->assignment && $task->assignment->mitra_id === Auth::id())
                    <div class="bg-gradient-to-br from-mtm-red to-mtm-brown p-8 rounded-3xl text-white shadow-xl space-y-6">
                        <div>
                            <h4 class="font-bold text-lg font-poppins text-white">Panel Aksi Mitra</h4>
                            <p class="text-xs text-red-150 font-medium">Kelola status pengerjaan tugas ini.</p>
                        </div>
                        @if($task->status === 'assigned')
                            <form action="{{ route('mitra.tasks.start', $task) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-white text-mtm-red hover:bg-gray-100 rounded-2xl font-bold shadow-lg transition-all text-sm">
                                    Mulai Pengerjaan Tugas
                                </button>
                            </form>
                        @elseif($task->status === 'in_progress')
                            <form action="{{ route('mitra.tasks.complete', $task) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-green-500 hover:bg-green-600 text-white rounded-2xl font-bold shadow-lg transition-all text-sm">
                                    Tandai Sebagai Selesai
                                </button>
                            </form>
                        @elseif($task->status === 'completed')
                            <div class="bg-white/10 p-4 rounded-2xl text-center">
                                <span class="text-xs font-bold text-green-300">✓ Tugas Selesai Dikerjakan</span>
                            </div>
                        @endif
                    </div>
                @endif

                @if(Auth::user()->role === 'mitra' && ($task->status === 'waiting_for_bid' || $task->status === 'bid_received'))
                    @php
                        $myBid = $task->bids->where('mitra_id', Auth::id())->first();
                    @endphp

                    @if(!$myBid)
                        <div class="bg-gradient-to-br from-mtm-red to-mtm-brown p-8 rounded-3xl text-white">
                            <h4 class="font-bold mb-2 font-poppins text-white">Tarik Tugas Ini?</h4>
                            <p class="text-xs text-red-150 mb-6 font-medium">Berikan penawaran terbaik Anda untuk membantu tugas ini.</p>
                            
                            <form action="{{ route('mitra.tasks.bid', $task) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold mb-1">Budget Anda (Rp)</label>
                                    <input type="number" name="bid_amount" value="{{ $task->budget }}" min="{{ intval($task->budget * 0.8) }}" class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-red-200 focus:ring-white focus:border-white">
                                    <p class="text-[10px] text-red-200 mt-1">Minimal: Rp {{ number_format($task->budget * 0.8, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Pesan (Opsional)</label>
                                    <textarea name="message" rows="3" class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-red-200 focus:ring-white focus:border-white" placeholder="Sampaikan mengapa Anda yang terbaik..."></textarea>
                                </div>
                                <button type="submit" class="w-full py-4 bg-white text-mtm-red rounded-2xl font-bold shadow-lg hover:bg-gray-100 transition-all text-sm">
                                    Kirim Penawaran
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-green-50 dark:bg-green-950/20 p-8 rounded-3xl border border-green-100 dark:border-green-900/30">
                            <h4 class="font-bold text-green-700 dark:text-green-400 mb-2 font-poppins">Penawaran Anda Terkirim</h4>
                            <p class="text-xs text-green-600 dark:text-green-500 mb-4">Anda menawarkan Rp {{ number_format($myBid->bid_amount, 0, ',', '.') }}</p>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">
                                {{ $myBid->status }}
                            </span>
                        </div>
                    @endif
                @endif

                <!-- Dispute Action -->
                @if(($task->status === 'completed' || $task->status === 'cancelled') && (Auth::id() === $task->user_id || (Auth::user()->role === 'mitra' && $task->assignment && $task->assignment->mitra_id === Auth::id())))
                    @if(!$task->dispute)
                        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <h4 class="font-bold mb-2 font-poppins text-gray-900 dark:text-white">Ada Masalah?</h4>
                            <p class="text-xs text-gray-500 mb-6 font-medium">Jika Anda mengalami kendala atau ketidakpuasan, Anda dapat melaporkan masalah ini.</p>
                            <a href="{{ route('disputes.create', $task) }}" class="w-full flex items-center justify-center gap-2 py-4 border-2 border-mtm-red text-mtm-red hover:bg-mtm-red hover:text-white rounded-2xl font-bold transition-all text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Laporkan Masalah
                            </a>
                        </div>
                    @else
                        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <h4 class="font-bold mb-2 font-poppins text-gray-900 dark:text-white">Laporan Masalah</h4>
                            <div class="p-4 bg-red-50 dark:bg-red-950/20 rounded-2xl mb-6">
                                <p class="text-xs text-red-600 dark:text-red-400 font-bold uppercase tracking-widest mb-1">Status Laporan</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ ucfirst($task->dispute->status) }}</p>
                            </div>
                            <a href="{{ route('disputes.show', $task->dispute) }}" class="w-full flex items-center justify-center gap-2 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-2xl font-bold transition-all text-sm">
                                Lihat Detail Laporan
                            </a>
                        </div>
                    @endif
                @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var locationName = "{{ $task->location }}";
    var destinationName = "{{ $task->destination_location }}";
    
    var defaultLat = -6.2088;
    var defaultLng = 106.8456;
    
    var map = L.map('detail-map', {
        zoomControl: true,
        scrollWheelZoom: false,
        attributionControl: false
    }).setView([defaultLat, defaultLng], 13);
    
    var isDark = document.documentElement.classList.contains('dark');
    var tileUrl = isDark 
        ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png' 
        : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var attribution = isDark
        ? '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
        
    L.tileLayer(tileUrl, {
        maxZoom: 19,
        attribution: attribution
    }).addTo(map);

    // Custom Marker Blue (Origin)
    var originIcon = L.divIcon({
        html: `<div class="relative w-8 h-8 flex items-center justify-center">
            <div class="absolute w-8 h-8 rounded-full bg-blue-500/30 animate-ping"></div>
            <div class="w-6 h-6 bg-gradient-to-tr from-blue-600 to-indigo-500 rounded-full border-2 border-white dark:border-mtm-dark shadow-lg flex items-center justify-center">
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </div>`,
        className: 'mtm-custom-marker',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });

    // Custom Marker Red (Destination)
    var destinationIcon = L.divIcon({
        html: `<div class="relative w-8 h-8 flex items-center justify-center">
            <div class="absolute w-8 h-8 rounded-full bg-red-500/30 animate-ping"></div>
            <div class="w-6 h-6 bg-gradient-to-tr from-red-600 to-amber-500 rounded-full border-2 border-white dark:border-mtm-dark shadow-lg flex items-center justify-center">
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </div>`,
        className: 'mtm-custom-marker',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
    });
    
    var mapLoading = document.getElementById('detail-map-loading');

    function geocodeAddress(address) {
        if (!address) return Promise.resolve(null);
        return fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1&accept-language=id`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                }
                // Fallback search by simpler parts of address if long search fails
                var parts = address.split(',');
                if (parts.length > 1) {
                    var fallbackQuery = parts.slice(Math.max(parts.length - 2, 0)).join(',');
                    return fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fallbackQuery)}&limit=1&accept-language=id`)
                        .then(res => res.json())
                        .then(fallbackData => {
                            if (fallbackData && fallbackData.length > 0) {
                                return [parseFloat(fallbackData[0].lat), parseFloat(fallbackData[0].lon)];
                            }
                            return null;
                        });
                }
                return null;
            })
            .catch(err => {
                console.error('Error geocoding:', address, err);
                return null;
            });
    }

    Promise.all([
        geocodeAddress(locationName),
        geocodeAddress(destinationName)
    ]).then(([originPos, destPos]) => {
        var markerOrigin = null;
        var markerDest = null;
        
        if (originPos) {
            markerOrigin = L.marker(originPos, { icon: originIcon }).addTo(map);
            markerOrigin.bindPopup(`<b>Lokasi Asal (Mulai):</b><br>${locationName}`);
        }
        
        if (destPos) {
            markerDest = L.marker(destPos, { icon: destinationIcon }).addTo(map);
            markerDest.bindPopup(`<b>Lokasi Tujuan (Akhir):</b><br>${destinationName}`);
        }

        if (originPos && destPos) {
            // Draw route line
            var polyline = L.polyline([originPos, destPos], {
                color: '#ef4444',
                weight: 4,
                dashArray: '6, 6'
            }).addTo(map);
            
            // Fit bounds to show both
            var bounds = L.latLngBounds([originPos, destPos]);
            map.fitBounds(bounds, { padding: [50, 50] });
            
            // Open popup on origin marker
            markerOrigin.openPopup();
        } else if (originPos) {
            map.setView(originPos, 15);
            markerOrigin.openPopup();
        } else if (destPos) {
            map.setView(destPos, 15);
            markerDest.openPopup();
        }
    }).catch(err => {
        console.error('Error positioning detail map markers:', err);
    }).finally(() => {
        mapLoading.classList.add('hidden');
    });

    });

    // Periodically invalidate map size to solve partial rendering/gray box bugs caused by parent transition animations
    var invalidateInterval = setInterval(function() {
        if (map) {
            map.invalidateSize();
        }
    }, 200);
    setTimeout(function() {
        clearInterval(invalidateInterval);
    }, 2500);
});
</script>

<!-- Live Negotiation Modal -->
<div x-data="liveNegotiationConsole()"
     @open-live-negotiation.window="openModal()"
     class="relative z-50">
    
    <!-- Modal Backdrop -->
    <div x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        
        <!-- Modal Card -->
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="bg-white dark:bg-[#1a1a1a] border border-gray-250 dark:border-white/5 w-full max-w-2xl rounded-[2.5rem] p-8 md:p-10 shadow-2xl relative overflow-hidden space-y-6"
             @click.outside="closeModal()"
             x-cloak>
            
            <!-- Sleek Glow decoration -->
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-mtm-red/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-gray-100 dark:border-white/5 pb-4">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-mtm-red/10 text-mtm-red text-[10px] font-black uppercase tracking-widest rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-mtm-red animate-ping"></span>
                        Radar Negosiasi Live
                    </span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white font-poppins">Mencari & Negosiasi Mitra</h3>
                    <p class="text-xs text-gray-500">Task: {{ $task->title }} • Budget Maks: Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                </div>
                <button @click="closeModal()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-white rounded-full hover:bg-gray-100 dark:hover:bg-white/5 transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Radar / Sonar Search Status Animation -->
            <div class="flex flex-col items-center justify-center py-6 text-center space-y-3">
                <div class="relative w-20 h-20 flex items-center justify-center">
                    <div class="absolute w-20 h-20 rounded-full bg-mtm-red/10 animate-ping"></div>
                    <div class="absolute w-14 h-14 rounded-full bg-mtm-red/20 animate-pulse"></div>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-mtm-red to-mtm-red-dark flex items-center justify-center shadow-lg text-white">
                        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-800 dark:text-white" x-text="statusText"></h4>
                    <p class="text-[10px] text-gray-400">Menghubungi Mitra terdekat di sekitar lokasi asal tugas...</p>
                </div>
            </div>

            <!-- Modal Content - Bids list -->
            <div class="max-h-[300px] overflow-y-auto space-y-4 pr-2">
                <template x-for="bid in bids" :key="bid.id">
                    <div class="bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-gray-800 p-5 rounded-3xl flex items-center justify-between gap-4 animate-slide-down">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-11 h-11 rounded-full overflow-hidden border border-gray-200/50 dark:border-white/5 flex-shrink-0">
                                <img :src="bid.mitra_photo" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <h5 class="font-bold text-sm text-gray-900 dark:text-white truncate" x-text="bid.mitra_name"></h5>
                                    <span class="px-2 py-0.5 rounded-full text-[6px] font-black uppercase tracking-widest border border-gray-300 dark:border-white/10" :class="bid.mitra_level_badge" x-text="bid.mitra_level"></span>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5 text-[10px] text-gray-500 font-bold">
                                    <span class="text-amber-500" x-text="'★ ' + bid.mitra_rating"></span>
                                    <span>•</span>
                                    <span class="text-gray-400 italic truncate max-w-[200px]" x-text="bid.message || 'Tanpa catatan'"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right flex-shrink-0 flex flex-col items-end gap-1.5">
                            <span class="text-base font-black text-mtm-red font-poppins" x-text="'Rp ' + parseInt(bid.bid_amount).toLocaleString('id-ID')"></span>
                            <div class="flex gap-2">
                                <button @click="rejectBid(bid)" class="px-3 py-1.5 bg-gray-100 dark:bg-white/5 hover:bg-red-500/10 hover:text-red-500 text-gray-600 dark:text-gray-300 rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer">
                                    Tolak
                                </button>
                                <button @click="acceptBid(bid)" class="px-3 py-1.5 bg-gradient-to-r from-mtm-red to-mtm-red-dark hover:from-mtm-red-dark hover:to-mtm-red text-white rounded-full text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer">
                                    Terima
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="bids.length === 0" class="py-8 text-center text-gray-400 text-xs font-bold bg-gray-50 dark:bg-black/10 rounded-3xl border border-dashed border-gray-200 dark:border-white/5 animate-pulse">
                    Menunggu penawaran harga masuk dari Mitra...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function liveNegotiationConsole() {
    return {
        showModal: false,
        bids: [],
        statusText: 'Mencari Mitra Terdekat...',
        pollingInterval: null,
        taskId: "{{ $task->id }}",
        initialized: false,

        init() {
            // Auto open if task was just created (session success message checks)
            @if(session('success') && (str_contains(session('success'), 'dibuat') || str_contains(session('success'), 'created')))
                setTimeout(() => {
                    this.openModal();
                }, 800);
            @endif
        },

        openModal() {
            this.showModal = true;
            this.pollBids();
            this.pollingInterval = setInterval(() => {
                this.pollBids();
            }, 3000); // poll every 3 seconds for fast negotiation response
        },

        closeModal() {
            this.showModal = false;
            this.initialized = false;
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
            }
        },

        playNotificationSound() {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();
                const now = ctx.currentTime;

                // Note 1: High crisp frequency (A5 note, 880Hz)
                const osc1 = ctx.createOscillator();
                const gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(880, now);
                gain1.gain.setValueAtTime(0, now);
                gain1.gain.linearRampToValueAtTime(0.3, now + 0.05);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.5);

                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(now);
                osc1.stop(now + 0.5);

                // Note 2: Harmonious high note (C6 note, 1046.5Hz) at 0.15s
                const osc2 = ctx.createOscillator();
                const gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(1046.5, now + 0.15);
                gain2.gain.setValueAtTime(0, now + 0.15);
                gain2.gain.linearRampToValueAtTime(0.3, now + 0.2);
                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.8);

                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(now + 0.15);
                osc2.stop(now + 0.8);
            } catch (e) {
                console.warn('Audio play blocked or unsupported:', e);
            }
        },

        pollBids() {
            fetch(`/tasks/${this.taskId}/bids-data`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const previousCount = this.bids.length;
                        this.bids = data.bids;
                        if (data.task_status !== 'waiting_for_bid' && data.task_status !== 'bid_received') {
                            // If task is no longer waiting for bids (accepted / completed), reload/close modal
                            window.location.reload();
                        }
                        
                        if (this.bids.length > 0) {
                            this.statusText = `${this.bids.length} Penawaran Masuk`;
                            if (this.initialized && this.bids.length > previousCount) {
                                this.playNotificationSound();
                            }
                        } else {
                            this.statusText = 'Mencari Mitra Terdekat...';
                        }
                        this.initialized = true;
                    }
                })
                .catch(err => console.error('Error polling bids:', err));
        },

        acceptBid(bid) {
            if (!confirm(`Terima penawaran dari ${bid.mitra_name} sebesar Rp ${bid.bid_amount.toLocaleString('id-ID')}?`)) {
                return;
            }
            
            fetch(bid.accept_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            })
            .then(res => {
                window.location.reload();
            })
            .catch(err => console.error('Error accepting bid:', err));
        },

        rejectBid(bid) {
            fetch(bid.reject_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.pollBids(); // Refresh instantly
                }
            })
            .catch(err => console.error('Error rejecting bid:', err));
        }
    }
}
</script>
</x-app-layout>
