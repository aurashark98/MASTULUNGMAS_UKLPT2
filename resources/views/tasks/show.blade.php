<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Tugas') }}
            </h2>
            <div class="flex items-center gap-4">
                @if(Auth::id() === $task->user_id && ($task->status === 'waiting_for_bid' || $task->status === 'bid_received'))
                    <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-1.5 bg-gray-150 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-full transition-all">
                        Edit Tugas
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-full transition-all">
                            Hapus Tugas
                        </button>
                    </form>
                @endif
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full uppercase">
                    {{ str_replace('_', ' ', $task->status) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
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
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1 font-poppins">Total Biaya (Budget)</p>
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
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Penawaran Masuk ({{ $task->bids->count() }})</h4>
                            @forelse($task->bids as $bid)
                            <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full flex-shrink-0 overflow-hidden border border-gray-100 dark:border-white/5">
                                        <img src="{{ $bid->mitra->profile_photo_url }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                            <h5 class="font-bold text-sm">{{ $bid->mitra->name }}</h5>
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
                                                <h3 class="text-xl font-black text-gray-900 dark:text-white font-poppins">{{ $bid->mitra->name }}</h3>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <div class="flex items-center gap-1 text-xs text-yellow-500 font-bold">
                                                        ★ {{ number_format($bid->mitra->mitraProfile->rating, 1) }}
                                                    </div>
                                                    <span class="text-gray-300 dark:text-white/10 text-xs">•</span>
                                                    <span class="text-xs text-gray-500 font-bold uppercase tracking-widest">{{ $bid->mitra->portfolios->count() }} Portfolio</span>
                                                </div>
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
                    @if($task->status === 'completed' && $task->payment && $task->payment->status === 'completed')
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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Buka Chat Room
                        </a>
                    </div>
                @endif

                <!-- Payment Panel -->
                @if(Auth::id() === $task->user_id && $task->status === 'completed' && (!$task->payment || $task->payment->status !== 'completed'))
                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-8 rounded-3xl text-white shadow-xl">
                        <h4 class="font-bold mb-2 font-poppins text-white">Selesaikan Pembayaran</h4>
                        <p class="text-xs text-amber-100 mb-6 font-medium">Tugas telah diselesaikan oleh Mitra. Silakan lakukan pembayaran sebesar Rp {{ number_format($task->budget, 0, ',', '.') }} untuk menyelesaikan transaksi.</p>
                        <a href="{{ route('tasks.pay', $task) }}" class="w-full flex items-center justify-center py-4 bg-white text-amber-600 hover:bg-amber-50 rounded-2xl font-bold shadow-lg transition-all text-sm">
                            Bayar Sekarang
                        </a>
                    </div>
                @endif

                <!-- Mitra Panel Action -->
                @if(Auth::user()->role === 'mitra' && $task->assignment && $task->assignment->mitra_id === Auth::id())
                    <div class="bg-gradient-to-br from-mtm-red to-mtm-brown p-8 rounded-3xl text-white shadow-xl space-y-6">
                        <div>
                            <h4 class="font-bold text-lg font-poppins text-white">Panel Aksi Mitra</h4>
                            <p class="text-xs text-red-150 font-medium">Kelola status pengerjaan tugas ini.</p>
                        </div>
                        @if($task->status === 'bid_accepted')
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
                                    <input type="number" name="bid_amount" value="{{ $task->budget }}" class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-red-200 focus:ring-white focus:border-white">
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
        </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var locationName = "{{ $task->location }}";
    var destinationName = "{{ $task->destination_location }}";
    
    var defaultLat = -6.2088;
    var defaultLng = 106.8456;
    
    var map = L.map('detail-map', {
        zoomControl: true,
        scrollWheelZoom: false
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
</x-app-layout>
