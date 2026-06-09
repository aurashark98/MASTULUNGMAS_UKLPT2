<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">

        {{-- Mitra Welcome Banner --}}
        @if(Auth::user()->mitraProfile && Auth::user()->mitraProfile->is_verified)
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-3xl p-6 text-white shadow-xl border border-amber-400/20 animate-fade-in">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4 flex-col sm:flex-row text-center sm:text-left">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-black font-poppins">Selamat! Akun Mitra Anda Disetujui</h4>
                            <p class="text-xs text-amber-100 mt-0.5">Beralihlah ke mode kerja untuk mulai menerima tawaran tugas.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.switch-role') }}">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-white text-amber-600 rounded-full font-bold text-xs uppercase tracking-wider shadow-lg hover:bg-amber-50 transition-all cursor-pointer whitespace-nowrap">
                            Beralih ke Mode Mitra
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-2xl p-4 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Welcome Hero Card --}}
        <div class="bg-gradient-to-br from-mtm-red via-mtm-orange to-mtm-brown rounded-[2.5rem] p-8 md:p-10 text-white relative overflow-hidden shadow-2xl">
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                <div class="shrink-0">
                    <div class="w-28 h-28 md:w-32 md:h-32 rounded-[2rem] overflow-hidden border-4 border-white/25 shadow-2xl">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover" data-no-dim>
                    </div>
                </div>
                <div class="text-center md:text-left flex-1">
                    <p class="text-white/70 text-sm font-medium mb-1">Selamat datang kembali 👋</p>
                    <h3 class="text-3xl md:text-4xl font-black mb-2 font-poppins">{{ Auth::user()->name }}</h3>
                    <p class="text-red-100 font-medium text-sm max-w-md">Butuh bantuan apa hari ini? Ratusan mitra kami siap membantu Anda.</p>
                    <div class="mt-6 flex flex-wrap gap-3 justify-center md:justify-start">
                        <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-mtm-red rounded-2xl font-black text-sm shadow-lg hover:shadow-white/20 hover:scale-105 active:scale-95 transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Buat Tugas Baru
                        </a>
                        <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white rounded-2xl font-bold text-sm transition-all">
                            Lihat Semua Tugas
                        </a>
                    </div>
                </div>
            </div>
            {{-- Decorative background --}}
            <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/></svg>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Active Tasks --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="flex items-center justify-between">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Tugas Aktif</h4>
                    <a href="{{ route('tasks.index') }}" class="text-sm text-mtm-red hover:text-mtm-orange font-semibold transition-colors">Lihat Semua →</a>
                </div>

                @forelse($active_tasks as $task)
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
                            'bid_accepted'    => 'Bayar Sekarang',
                            'assigned'        => 'Menunggu Mitra',
                            'in_progress'     => 'Sedang Dikerjakan',
                            'completed'       => 'Selesai',
                            'paid'            => 'Sudah Dibayar',
                            default           => ucfirst(str_replace('_', ' ', $task->status)),
                        };
                    @endphp
                    <a href="{{ route('tasks.show', $task) }}" class="block bg-white dark:bg-[#1E1E1E] p-5 md:p-6 rounded-2xl border border-gray-100 dark:border-white/[0.07] shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-start justify-between mb-3 gap-3">
                            <div class="min-w-0 flex-1">
                                <span class="inline-block px-2.5 py-0.5 bg-red-50 dark:bg-red-950/30 text-mtm-red text-[10px] font-bold rounded-full mb-2 uppercase tracking-wider">
                                    {{ $task->category->name }}
                                </span>
                                <h5 class="font-bold text-base text-gray-900 dark:text-white truncate">{{ $task->title }}</h5>
                            </div>
                            <span class="{{ $statusClass }} shrink-0">{{ $statusLabel }}</span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-white/[0.05]">
                            <div class="text-sm font-black text-mtm-red">
                                Rp {{ number_format($task->budget, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-400 dark:text-gray-500 font-medium">
                                {{ $task->bids->count() }} Penawaran
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="bg-gray-50 dark:bg-white/[0.03] p-12 rounded-2xl text-center border-2 border-dashed border-gray-200 dark:border-white/10">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada tugas aktif.</p>
                        <a href="{{ route('tasks.create') }}" class="mt-4 inline-flex items-center text-sm text-mtm-red font-bold hover:underline">+ Buat Tugas Pertama</a>
                    </div>
                @endforelse
            </div>

            {{-- Sidebar: History --}}
            <div class="space-y-5">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Riwayat Terakhir</h4>
                <div class="bg-white dark:bg-[#1E1E1E] p-5 rounded-2xl border border-gray-100 dark:border-white/[0.07] shadow-sm">
                    <div class="space-y-4">
                        @forelse($task_history as $history)
                            @php
                                $needsReview = $history->status === 'completed' && !$history->review;
                                $hColor = $needsReview ? 'text-amber-500' : ($history->status === 'completed' || $history->status === 'paid' ? 'text-green-500' : 'text-gray-400 dark:text-gray-500');
                                $hLabel = $needsReview ? 'BERIKAN ULASAN' : strtoupper(str_replace('_', ' ', $history->status));
                            @endphp
                            <a href="{{ route('tasks.show', $history) }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity group">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-white/5 group-hover:bg-mtm-red/10 rounded-xl flex items-center justify-center text-gray-400 group-hover:text-mtm-red transition-colors shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $history->title }}</p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $history->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="text-[10px] font-black {{ $hColor }} shrink-0 px-2 py-1 {{ $needsReview ? 'bg-amber-500/10 rounded-full' : '' }}">{{ $hLabel }}</span>
                            </a>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-6">Belum ada riwayat tugas.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
