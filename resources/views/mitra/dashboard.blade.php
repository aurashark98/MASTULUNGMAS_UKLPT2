<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8 animate-fade-in">
        
        <!-- Status Messages -->
        @if(session('success'))
            <div class="p-4 bg-green-500/10 border border-green-500/20 text-green-500 rounded-2xl text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Driver Console Header Card -->
        <div class="glass-card rounded-[2.5rem] p-8 md:p-10 border border-gray-200/50 dark:border-white/5 bg-white/40 dark:bg-[#1a1a1a]/40 backdrop-blur-md shadow-xl flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-6 text-center md:text-left flex-col md:flex-row">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white dark:border-white/10 shadow-lg">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover" />
                    </div>
                    <!-- Online indicator dot -->
                    <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full border-4 border-white dark:border-[#1a1a1a] {{ $profile->is_online ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></div>
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-center md:justify-start gap-3 flex-wrap">
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white font-poppins">{{ Auth::user()->name }}</h2>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ Auth::user()->level_badge }}">
                            {{ Auth::user()->level }}
                        </span>
                        <span class="px-3 py-1 text-[10px] font-bold tracking-wider uppercase rounded-full {{ $profile->is_online ? 'bg-green-500/10 text-green-500' : 'bg-gray-500/10 text-gray-500' }}">
                            {{ $profile->is_online ? 'Online' : 'Offline' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Mitra Terverifikasi • ID Mitra #{{ $profile->id }}</p>
                    <div class="flex flex-wrap gap-1.5 pt-1.5 justify-center md:justify-start">
                        @foreach($profile->skills ?? [] as $skill)
                            <span class="px-2.5 py-0.5 bg-red-500/5 text-mtm-red border border-mtm-red/10 rounded-full text-[10px] font-bold uppercase tracking-wider">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Controls & Status Switcher -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full md:w-auto">
                <!-- Quick Actions (Edit Profil) -->
                <div class="flex flex-row flex-wrap gap-3 justify-center">
                    <!-- Edit Profil Button -->
                    <button onclick="openEditModal()"
                            class="h-14 flex-1 sm:flex-initial sm:w-auto px-5 rounded-3xl bg-blue-500/10 hover:bg-blue-500/20 text-blue-500 font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 border border-blue-500/10 active:scale-95 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <!-- Wallet & Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Income Card -->
            <div class="glass-card rounded-3xl p-6 md:p-8 border border-gray-200/50 dark:border-white/5 bg-white/40 dark:bg-[#1a1a1a]/40 backdrop-blur-md shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="text-3xl font-black text-mtm-red font-poppins mt-2">Rp {{ number_format($profile->earnings, 0, ',', '.') }}</h3>
                </div>
                <div class="p-4 rounded-2xl bg-mtm-red/10 text-mtm-red">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Rating Card -->
            <div class="glass-card rounded-3xl p-6 md:p-8 border border-gray-200/50 dark:border-white/5 bg-white/40 dark:bg-[#1a1a1a]/40 backdrop-blur-md shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rating Pelayanan</p>
                    <div class="flex items-center gap-3 mt-2">
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white font-poppins">{{ number_format($profile->rating, 1) }}</h3>
                        <div class="flex text-amber-500">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($profile->rating) ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-2xl bg-amber-500/10 text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>

            <!-- Jobs Completed Card -->
            <div class="glass-card rounded-3xl p-6 md:p-8 border border-gray-200/50 dark:border-white/5 bg-white/40 dark:bg-[#1a1a1a]/40 backdrop-blur-md shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tugas Selesai</p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white font-poppins mt-2">{{ $completed_tasks_count }} Pekerjaan</h3>
                </div>
                <div class="p-4 rounded-2xl bg-blue-500/10 text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left & Middle: Active Jobs & Available Jobs -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Section 1: Active Assignments (Pekerjaan Sedang Berjalan) -->
                <div class="space-y-4">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wider font-poppins flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-mtm-red"></span>
                        Pekerjaan Aktif Saat Ini
                    </h3>

                    @forelse($active_assignments as $assignment)
                        <div class="bg-white dark:bg-mtm-dark-surface p-6 md:p-8 rounded-[2rem] border border-gray-200 dark:border-white/5 shadow-md space-y-6 animate-pulse-subtle">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-gray-100 dark:border-white/5 pb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-red-500/10 text-mtm-red text-[10px] font-bold rounded-full uppercase tracking-wider mb-2">
                                        {{ $assignment->task->category->name }}
                                    </span>
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $assignment->task->title }}</h4>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Pemberi Tugas: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $assignment->task->user->name }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-black text-mtm-red font-poppins">Rp {{ number_format($assignment->task->budget, 0, ',', '.') }}</p>
                                    @php
                                        $badgeClass = match($assignment->task->status) {
                                            'assigned' => 'bg-amber-500/10 text-amber-500',
                                            'in_progress' => 'bg-blue-500/10 text-blue-500',
                                            'completed' => 'bg-green-500/10 text-green-500',
                                            'paid' => 'bg-green-500/10 text-green-500',
                                            default => 'bg-gray-500/10 text-gray-500',
                                        };
                                        $badgeText = match($assignment->task->status) {
                                            'assigned' => 'Belum Mulai',
                                            'in_progress' => 'Sedang Dikerjakan',
                                            'completed' => $assignment->task->is_quick_help ? 'Selesai & Lunas' : 'Selesai (Menunggu Bayaran)',
                                            'paid' => 'Selesai & Lunas',
                                            default => 'Status: ' . $assignment->task->status,
                                        };
                                    @endphp
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mt-1.5 {{ $badgeClass }}">
                                        {{ $badgeText }}
                                    </span>
                                </div>
                            </div>

                            <!-- Job details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-medium text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-mtm-red flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>Lokasi: {{ $assignment->task->location }}</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-mtm-red flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>Hubungi Pelanggan: <a href="tel:{{ $assignment->task->user->phone_number ?? '' }}" class="text-mtm-red hover:underline font-bold">{{ $assignment->task->user->phone_number ?? 'Hubungi via Profil' }}</a></span>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed font-medium bg-gray-50 dark:bg-black/10 p-4 rounded-2xl">
                                {{ $assignment->task->description }}
                            </p>

                            <!-- Control Buttons -->
                            <div class="flex gap-4 pt-2">
                                @if($assignment->task->status === 'bid_accepted' || $assignment->task->status === 'assigned')
                                    <form method="POST" action="{{ route('mitra.tasks.start', $assignment->task) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl font-bold text-sm shadow-lg hover:shadow-blue-500/20 active:scale-[0.98] transition-all">
                                            Mulai Kerjakan Tugas Ini
                                        </button>
                                    </form>
                                @elseif($assignment->task->status === 'in_progress')
                                    <form method="POST" action="{{ route('mitra.tasks.complete', $assignment->task) }}" class="flex-1 space-y-3">
                                        @csrf
                                        @if($assignment->task->is_quick_help)
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nominal Dibayar (Min: Rp {{ number_format($assignment->task->budget, 0, ',', '.') }})</label>
                                                <div class="flex items-center">
                                                    <span class="px-3 py-2.5 bg-gray-100 dark:bg-white/5 border border-r-0 border-gray-200 dark:border-white/10 rounded-l-xl text-gray-500 text-sm font-bold">Rp</span>
                                                    <input type="number" name="final_price" required min="{{ $assignment->task->budget }}" value="{{ (int)$assignment->task->budget }}"
                                                           class="w-full border border-gray-200 dark:border-white/10 bg-white dark:bg-black/20 rounded-r-xl px-3 py-2.5 text-sm font-bold text-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500">
                                                </div>
                                            </div>
                                            <button type="submit" 
                                                    class="w-full py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold text-sm shadow-lg hover:shadow-green-500/20 active:scale-[0.98] transition-all">
                                                Selesaikan & Konfirmasi Pembayaran
                                            </button>
                                        @else
                                            <button type="submit" 
                                                    class="w-full py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold text-sm shadow-lg hover:shadow-green-500/20 active:scale-[0.98] transition-all">
                                                Selesaikan Pekerjaan
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white/40 dark:bg-mtm-dark-surface/40 p-10 rounded-[2rem] text-center border border-dashed border-gray-200 dark:border-white/5 shadow-sm">
                            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Tidak ada pekerjaan aktif yang sedang berjalan.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Section 2: Available Tasks (Tugas Tersedia / Peluang Kerja) -->
                <div class="space-y-4">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wider font-poppins flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        Tugas Baru Tersedia
                    </h3>

                    @if(!$profile->is_online)
                        <div class="bg-amber-500/5 dark:bg-amber-500/5 p-10 rounded-[2rem] text-center border border-amber-500/20 shadow-sm space-y-3">
                            <div class="inline-flex p-3 rounded-full bg-amber-500/10 text-amber-500">
                                <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            </div>
                            <h4 class="font-bold text-lg text-amber-600 dark:text-amber-500">Status Anda Sedang Offline</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 max-w-sm mx-auto font-medium">Aktifkan status bekerja Anda di card atas untuk mulai mencari dan menerima pesanan pekerjaan di sekitar Anda.</p>
                        </div>
                    @else
                        @forelse($available_tasks as $task)
                            <div x-data="{ openBid: false }" class="bg-white dark:bg-mtm-dark-surface p-6 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm space-y-4 hover:shadow-md transition-all">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-gray-50 dark:border-white/5 pb-3">
                                    <div>
                                        <span class="inline-block px-2.5 py-0.5 bg-red-500/10 text-mtm-red text-[9px] font-bold rounded-full uppercase tracking-wider">
                                            {{ $task->category->name }}
                                        </span>
                                        <h5 class="font-bold text-lg text-gray-900 dark:text-white mt-1">{{ $task->title }}</h5>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Oleh {{ $task->user->name }} • {{ $task->location }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-mtm-red font-poppins">Anggaran Maks:</p>
                                        <p class="text-lg font-black text-gray-900 dark:text-white font-poppins">Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">{{ $task->description }}</p>
                                
                                <div class="flex gap-3 pt-2">
                                    <button @click="openBid = !openBid" 
                                            class="flex-1 py-3.5 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-2xl font-bold text-xs shadow-lg hover:shadow-mtm-red/20 active:scale-[0.98] transition-all">
                                        Ambil / Berikan Tawaran Harga
                                    </button>
                                </div>

                                <!-- Bid Submitting Form -->
                                <div x-show="openBid" x-collapse x-cloak class="mt-4 p-5 bg-gray-50 dark:bg-black/10 rounded-2xl border border-gray-100 dark:border-white/5 animate-slide-down">
                                    <form method="POST" action="{{ route('mitra.tasks.bid', $task) }}" class="space-y-4">
                                        @csrf
                                        <div class="space-y-1.5">
                                            <label for="bid_amount_{{ $task->id }}" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Harga Penawaran Anda (Rp) *</label>
                                            <input type="number" 
                                                   id="bid_amount_{{ $task->id }}" 
                                                   name="bid_amount" 
                                                   value="{{ intval($task->budget) }}"
                                                   min="{{ intval($task->budget * 0.8) }}"
                                                   required 
                                                   class="block w-full bg-white dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-xl text-sm p-3.5 focus:ring-mtm-red focus:border-mtm-red font-bold text-gray-800 dark:text-white" />
                                            <p class="text-[9px] text-gray-400 mt-1">Minimum: Rp {{ number_format($task->budget * 0.8, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label for="message_{{ $task->id }}" class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Catatan / Pesan Pengantar (Opsional)</label>
                                            <textarea id="message_{{ $task->id }}" 
                                                      name="message" 
                                                      rows="2" 
                                                      placeholder="Jelaskan secara singkat mengenai keahlian Anda untuk memenangkan tugas ini..." 
                                                      class="block w-full bg-white dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-xl text-xs p-3.5 focus:ring-mtm-red focus:border-mtm-red text-gray-700 dark:text-gray-300"></textarea>
                                        </div>
                                        <button type="submit" 
                                                class="w-full py-3 bg-gradient-to-r from-red-500 to-amber-500 text-white rounded-xl font-bold text-xs shadow-md active:scale-95 transition-all">
                                            Kirim Tawaran Harga
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white/40 dark:bg-mtm-dark-surface/40 p-10 rounded-[2rem] text-center border border-dashed border-gray-200 dark:border-white/5 shadow-sm">
                                <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Belum ada tugas baru yang tersedia untuk keahlian Anda saat ini.</p>
                            </div>
                        @endforelse
                    @endif
                </div>

            </div>

            <!-- Right Sidebar: Placed Bids History -->
            <div class="space-y-6">
                <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wider font-poppins flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    Penawaran Saya
                </h3>

                <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-[2rem] border border-gray-200 dark:border-white/5 shadow-sm space-y-6">
                    @forelse($my_bids as $bid)
                        <div class="flex gap-4 items-start border-b border-gray-50 dark:border-white/5 pb-4 last:border-b-0 last:pb-0">
                            <div class="w-10 h-10 bg-gray-50 dark:bg-[#121212]/20 border border-gray-100 dark:border-white/5 rounded-2xl flex items-center justify-center text-mtm-red flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex-1 space-y-1 min-w-0">
                                <h6 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $bid->task->title }}</h6>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium">Tawaran Anda: <span class="font-bold text-mtm-red">Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}</span></p>
                                <div class="flex items-center justify-between pt-1">
                                    @php
                                        $bidBadgeColor = match($bid->status) {
                                            'pending' => 'bg-amber-500/10 text-amber-500',
                                            'accepted' => 'bg-emerald-500/10 text-emerald-500',
                                            default => 'bg-red-500/10 text-red-500',
                                        };
                                        $bidBadgeLabel = match($bid->status) {
                                            'pending' => 'Pending',
                                            'accepted' => 'Belum Dibayar',
                                            default => 'Ditolak',
                                        };
                                    @endphp
                                    <span class="text-[9px] px-2 py-0.5 font-bold uppercase rounded-full {{ $bidBadgeColor }}">
                                        {{ $bidBadgeLabel }}
                                    </span>
                                    <span class="text-[9px] text-gray-400">{{ $bid->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center py-4 font-medium">Belum ada penawaran aktif yang Anda kirimkan.</p>
                    @endforelse
                </div>

                <!-- Section 4: Riwayat Pekerjaan -->
                <div class="mt-8 space-y-4">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wider font-poppins flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-gray-500"></span>
                        Riwayat Pekerjaan
                    </h3>

                    <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-[2rem] border border-gray-200 dark:border-white/5 shadow-sm space-y-4">
                        @forelse($task_history as $history)
                            @php
                                $hColor = ($history->status === 'completed' || $history->status === 'paid') ? 'text-green-500' : 'text-gray-400 dark:text-gray-500';
                                $hLabel = strtoupper(str_replace('_', ' ', $history->status));
                                if ($history->status === 'paid') $hLabel = 'SELESAI & LUNAS';
                                if ($history->status === 'completed') $hLabel = $history->is_quick_help ? 'SELESAI & LUNAS' : 'SELESAI';
                            @endphp
                            <a href="{{ route('tasks.show', $history) }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity group border-b border-gray-50 dark:border-white/5 pb-4 last:border-b-0 last:pb-0">
                                <div class="w-10 h-10 bg-gray-50 dark:bg-[#121212]/20 border border-gray-100 dark:border-white/5 group-hover:border-mtm-red/20 group-hover:bg-mtm-red/5 rounded-xl flex items-center justify-center text-gray-400 group-hover:text-mtm-red transition-all shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $history->title }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-0.5">Pendapatan: <span class="font-bold text-mtm-red">Rp {{ number_format($history->budget, 0, ',', '.') }}</span></p>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-[9px] px-2 py-0.5 font-bold uppercase rounded-full {{ str_replace('text-', 'bg-', $hColor) }}/10 {{ $hColor }} block mb-1">
                                        {{ $hLabel }}
                                    </span>
                                    <span class="text-[9px] text-gray-400">{{ $history->updated_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center py-4 font-medium">Belum ada riwayat tugas yang Anda kerjakan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Real-time Location Tracking and Incoming Tasks Modal Console -->
    <div x-data="incomingTaskConsole()" class="relative z-[100]">
        <!-- Modal Backdrop -->
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-start justify-center p-4 pt-32"
             x-cloak>
            
            <!-- Modal Card -->
            <div x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white dark:bg-[#1a1a1a] border border-gray-250 dark:border-white/5 w-full max-w-[320px] rounded-2xl p-4 shadow-2xl relative overflow-hidden space-y-2.5"
                 @click.outside="closeModal()"
                 x-cloak>
                
                <!-- Sleek Glow decoration -->
                <div class="absolute -top-10 -right-10 w-28 h-28 bg-mtm-red/10 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Modal Header -->
                <div class="flex items-start justify-between border-b border-gray-100 dark:border-white/5 pb-2">
                    <div class="space-y-0.5">
                        <template x-if="currentTask.is_quick_help">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-red-500/10 text-red-500 text-[9px] font-black uppercase tracking-wider rounded-full animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span>
                                Darurat: Bantuan Cepat
                            </span>
                        </template>
                        <template x-if="!currentTask.is_quick_help">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-mtm-red/10 text-mtm-red text-[8px] font-black uppercase tracking-widest rounded-full">
                                <span class="w-1 h-1 rounded-full bg-mtm-red animate-ping"></span>
                                Tugas Baru Terdeteksi
                            </span>
                        </template>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white font-poppins leading-tight line-clamp-1" x-text="currentTask.title"></h3>
                    </div>
                    <button @click="closeModal()" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-white rounded-full hover:bg-gray-100 dark:hover:bg-white/5 transition-all mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="space-y-2.5">
                    <!-- Specs Row -->
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-gray-800/50 rounded-xl p-2">
                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-wider">Jarak Anda</span>
                            <p class="text-xs font-black text-gray-850 dark:text-white mt-0.5" x-text="currentTask.distance_to_mitra + ' Km'"></p>
                        </div>
                        <div class="bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-gray-800/50 rounded-xl p-2">
                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-wider">Jarak Tempuh</span>
                            <p class="text-xs font-black text-gray-850 dark:text-white mt-0.5" x-text="currentTask.distance_between + ' Km'"></p>
                        </div>
                    </div>

                    <!-- Locations Info -->
                    <div class="space-y-1.5 bg-gray-50/50 dark:bg-[#121212]/30 p-2.5 rounded-xl border border-gray-150 dark:border-white/5">
                        <div class="flex gap-2 text-xs items-center">
                            <div class="w-4 h-4 rounded-full bg-blue-500/10 text-blue-500 flex items-center justify-center flex-shrink-0 font-bold text-[9px]">A</div>
                            <p class="text-gray-700 dark:text-gray-300 font-medium text-[10px] truncate" x-text="currentTask.location"></p>
                        </div>
                        <div class="border-t border-gray-200/50 dark:border-white/5"></div>
                        <div class="flex gap-2 text-xs items-center">
                            <div class="w-4 h-4 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center flex-shrink-0 font-bold text-[9px]">B</div>
                            <p class="text-gray-700 dark:text-gray-300 font-medium text-[10px] truncate" x-text="currentTask.destination_location || '-'"></p>
                        </div>
                    </div>

                    <!-- Bidding Form (Regular Tasks) -->
                    <template x-if="!currentTask.is_quick_help">
                        <form :action="currentTask.bid_url" method="POST" class="space-y-2.5">
                            @csrf
                            <div>
                                <label class="block text-[8px] font-bold text-gray-500 uppercase tracking-widest mb-1">Tawaran (Rp) *</label>
                                <div class="relative">
                                    <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-[10px]">Rp</span>
                                    <input type="number" 
                                           name="bid_amount" 
                                           :value="currentTask.budget"
                                           :min="parseInt(currentTask.budget * 0.8)"
                                           required 
                                           class="block w-full bg-gray-50 dark:bg-black/20 border border-gray-250 dark:border-white/5 rounded-xl text-xs p-2.5 pl-7 focus:ring-mtm-red focus:border-mtm-red font-black text-gray-800 dark:text-white" />
                                </div>
                            </div>

                            <div>
                                <input type="text"
                                       name="message" 
                                       placeholder="Catatan penawaran (opsional)..." 
                                       class="block w-full bg-gray-50 dark:bg-black/20 border border-gray-250 dark:border-white/5 rounded-xl text-[10px] p-2.5 focus:ring-mtm-red focus:border-mtm-red text-gray-700 dark:text-gray-300" />
                            </div>

                            <div class="flex gap-2 pt-1">
                                <button type="button" @click="closeModal()" class="flex-1 py-2 border border-gray-200 dark:border-white/10 hover:bg-gray-100 dark:hover:bg-white/5 text-gray-600 dark:text-gray-300 rounded-xl font-bold text-[10px] uppercase tracking-wider transition-all cursor-pointer">
                                    Tolak
                                </button>
                                <button type="submit" class="flex-1 py-2 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-xl font-bold text-[10px] uppercase tracking-wider shadow-md hover:shadow-mtm-red/20 transition-all cursor-pointer">
                                    Kirim Tawaran
                                </button>
                            </div>
                        </form>
                    </template>

                    <!-- Instant Claim Form (Quick Help Tasks) -->
                    <template x-if="currentTask.is_quick_help">
                        <div class="space-y-2.5">
                            <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 rounded-xl p-2.5 text-[10px] font-medium text-red-800 dark:text-red-300 leading-tight">
                                Tugas ini bersifat langsung. Anda akan langsung ditugaskan dengan estimasi tarif ini.
                            </div>
                            <div class="flex justify-between items-center bg-gray-50 dark:bg-black/20 p-2.5 rounded-xl border border-gray-150 dark:border-white/5">
                                <span class="text-[9px] text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">Estimasi Tarif:</span>
                                <span class="text-sm font-black text-red-500 dark:text-red-400 font-poppins" x-text="'Rp ' + parseInt(currentTask.budget).toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex gap-2 pt-1">
                                <button type="button" @click="closeModal()" class="flex-1 py-2 border border-gray-200 dark:border-white/10 hover:bg-gray-100 dark:hover:bg-white/5 text-gray-600 dark:text-gray-300 rounded-xl font-bold text-[10px] uppercase tracking-wider transition-all cursor-pointer">
                                    Tolak
                                </button>
                                <button type="button" @click="acceptQuickHelp(currentTask)" class="flex-1 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-xl font-bold text-[10px] uppercase tracking-wider shadow-md hover:shadow-red-500/25 transition-all cursor-pointer flex items-center justify-center gap-1.5">
                                    Terima & Bantu
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Re-Bid / Negotiation Form Modal -->
        <div x-show="showRebidModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-start justify-center p-4 pt-32"
             x-cloak>
            
            <!-- Modal Card -->
            <div x-show="showRebidModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white dark:bg-[#1a1a1a] border border-gray-250 dark:border-white/5 w-full max-w-[320px] rounded-2xl p-4 shadow-2xl relative overflow-hidden space-y-2.5"
                 @click.outside="closeRebidModal()"
                 x-cloak>
                
                <!-- Glow decoration -->
                <div class="absolute -top-10 -right-10 w-28 h-28 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Modal Header -->
                <div class="flex items-start justify-between border-b border-gray-100 dark:border-white/5 pb-2">
                    <div class="space-y-0.5">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-amber-500/10 text-amber-500 text-[9px] font-black uppercase tracking-widest rounded-full">
                            Tawaran Ditolak
                        </span>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white font-poppins leading-tight line-clamp-1" x-text="currentRebid.task_title"></h3>
                    </div>
                    <button @click="closeRebidModal()" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-white rounded-full hover:bg-gray-100 dark:hover:bg-white/5 transition-all mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="space-y-2.5">
                    <p class="text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed">
                        Tawaran ditolak. Ajukan harga baru yang lebih kompetitif. Budget: <span class="font-bold text-mtm-red" x-text="'Rp ' + parseInt(currentRebid.task_budget).toLocaleString('id-ID')"></span>
                    </p>

                    <!-- Re-Bidding Form -->
                    <form :action="currentRebid.bid_url" method="POST" class="space-y-2.5">
                        @csrf
                        <div>
                            <label class="block text-[8px] font-bold text-gray-500 uppercase tracking-widest mb-1">Tawaran Baru (Rp) *</label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-[10px]">Rp</span>
                                <input type="number" 
                                       name="bid_amount" 
                                       :value="currentRebid.bid_amount"
                                       :min="parseInt(currentRebid.task_budget * 0.8)"
                                       required 
                                       class="block w-full bg-gray-50 dark:bg-black/20 border border-gray-250 dark:border-white/5 rounded-xl text-xs p-2.5 pl-7 focus:ring-mtm-red focus:border-mtm-red font-black text-gray-800 dark:text-white" />
                            </div>
                        </div>

                        <div>
                            <input type="text"
                                   name="message" 
                                   placeholder="Catatan penyesuaian harga..." 
                                   class="block w-full bg-gray-50 dark:bg-black/20 border border-gray-250 dark:border-white/5 rounded-xl text-[10px] p-2.5 focus:ring-mtm-red focus:border-mtm-red text-gray-700 dark:text-gray-300" />
                        </div>

                        <div class="flex gap-2 pt-1">
                            <button type="button" @click="closeRebidModal()" class="flex-1 py-2 border border-gray-200 dark:border-white/10 hover:bg-gray-100 dark:hover:bg-white/5 text-gray-600 dark:text-gray-300 rounded-xl font-bold text-[10px] uppercase tracking-wider transition-all cursor-pointer">
                                Abaikan
                            </button>
                            <button type="submit" class="flex-1 py-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl font-bold text-[10px] uppercase tracking-wider shadow-md hover:shadow-amber-500/25 transition-all cursor-pointer">
                                Kirim Tawaran Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function incomingTaskConsole() {
        return {
            showModal: false,
            currentTask: {},
            viewedTaskIds: new Set(),
            isOnline: {{ $profile->is_online ? 'true' : 'false' }},
            watchId: null,
            pollingInterval: null,
            
            // Re-bidding notification state
            showRebidModal: false,
            currentRebid: {},
            viewedRebidIds: new Set(),

            init() {
                if (this.isOnline) {
                    this.startTracking();
                    this.startPolling();
                }
            },

            startTracking() {
                if (!navigator.geolocation) {
                    console.warn('Geolocation is not supported by this browser.');
                    this.clearLocation();
                    return;
                }

                // Get initial position
                navigator.geolocation.getCurrentPosition(
                    (pos) => this.sendLocation(pos.coords.latitude, pos.coords.longitude),
                    (err) => {
                        console.error('Error getting initial location:', err);
                        this.clearLocation();
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );

                // Watch position updates
                this.watchId = navigator.geolocation.watchPosition(
                    (pos) => this.sendLocation(pos.coords.latitude, pos.coords.longitude),
                    (err) => {
                        console.error('Error watching location:', err);
                    },
                    { enableHighAccuracy: true, timeout: 20000, maximumAge: 10000 }
                );
            },

            clearLocation() {
                fetch("{{ route('mitra.update-location') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ latitude: null, longitude: null })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log('Location cleared successfully (using fallback skills-only matching)');
                        this.pollIncomingTasks(); // Instant polling on location update!
                    }
                })
                .catch(err => console.error('Error clearing location:', err));
            },

            sendLocation(lat, lng) {
                fetch("{{ route('mitra.update-location') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ latitude: lat, longitude: lng })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log('Location updated successfully:', lat, lng);
                        this.pollIncomingTasks(); // Instant polling on location update!
                    }
                })
                .catch(err => console.error('Error sending location:', err));
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

            startPolling() {
                // Poll tasks immediately, then every 8 seconds
                this.pollIncomingTasks();
                this.pollingInterval = setInterval(() => {
                    this.pollIncomingTasks();
                }, 8000);
            },

            pollIncomingTasks() {
                fetch("{{ route('mitra.check-incoming-tasks') }}")
                    .then(res => res.json())
                    .then(data => {
                        console.log('pollIncomingTasks data:', data);
                        if (data.success) {
                            // 1. Check for incoming matching tasks
                            if (data.tasks && data.tasks.length > 0) {
                                // Find any task that we haven't bid on or dismissed in this session
                                const newTasks = data.tasks.filter(t => !this.viewedTaskIds.has(t.id));
                                if (newTasks.length > 0 && !this.showModal && !this.showRebidModal) {
                                    // Show the first unviewed task
                                    this.currentTask = newTasks[0];
                                    this.showModal = true;
                                    this.playNotificationSound();
                                }
                            }

                            // 2. Check for rejected bids (for re-bidding notification modal)
                            if (data.bids && data.bids.length > 0) {
                                const rejectedBids = data.bids.filter(b => b.status === 'rejected' && !this.viewedRebidIds.has(b.id));
                                if (rejectedBids.length > 0 && !this.showModal && !this.showRebidModal) {
                                    this.currentRebid = rejectedBids[0];
                                    this.showRebidModal = true;
                                    this.playNotificationSound();
                                }
                            }
                        }
                    })
                    .catch(err => console.error('Error polling tasks:', err));
            },

            submittingQuickHelp: false,

            closeModal() {
                if (this.currentTask && this.currentTask.id) {
                    this.viewedTaskIds.add(this.currentTask.id);
                }
                this.showModal = false;
                this.currentTask = {};
            },

            closeRebidModal() {
                if (this.currentRebid && this.currentRebid.id) {
                    this.viewedRebidIds.add(this.currentRebid.id);
                }
                this.showRebidModal = false;
                this.currentRebid = {};
            },

            acceptQuickHelp(task) {
                if (this.submittingQuickHelp) return;
                this.submittingQuickHelp = true;

                fetch(task.accept_quick_help_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.submittingQuickHelp = false;
                    if (data.success) {
                        this.closeModal();
                        alert('Bantuan cepat diterima! Membuka ruang chat...');
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Gagal menerima bantuan cepat.');
                    }
                })
                .catch(err => {
                    this.submittingQuickHelp = false;
                    console.error(err);
                    alert('Terjadi kesalahan jaringan.');
                });
            }
        }
    }
    </script>

    <!-- ==================== MODAL EDIT PROFIL MITRA ==================== -->
    <div id="editProfileModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-start justify-center p-4 pt-16 z-[60] hidden" onclick="if(event.target===this)closeEditModal()">
        <div class="bg-white dark:bg-[#1a1a1a] border border-gray-200 dark:border-white/5 w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden">

            <!-- Modal Header -->
            <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100 dark:border-white/5">
                <div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white font-poppins">Edit Profil Mitra</h3>
                    <p class="text-xs text-gray-500 mt-1">Perbarui info, skill, dan detail layanan Anda</p>
                </div>
                <button onclick="closeEditModal()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-white/5 text-gray-400 hover:text-gray-600 dark:hover:text-white transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('profile.mitra.update') }}" class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
                @csrf
                @method('PATCH')

                <!-- Bio -->
                <div>
                    <label class="block text-xs font-black text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">Bio / Deskripsi Diri</label>
                    <textarea name="bio" rows="4" required minlength="10"
                              class="block w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#111] text-gray-900 dark:text-gray-100 focus:border-red-500 focus:ring-red-500 rounded-xl px-4 py-3 text-sm"
                              placeholder="Ceritakan pengalaman dan keahlian Anda...">{{ $profile->bio }}</textarea>
                </div>

                <!-- Skills -->
                <div>
                    <label class="block text-xs font-black text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">Keahlian / Layanan yang Ditawarkan</label>
                    <p class="text-[11px] text-gray-400 mb-3">Pilih semua kategori layanan yang bisa Anda tangani</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($categories as $category)
                            <label class="flex items-center gap-3 p-3 border border-gray-200 dark:border-white/10 rounded-xl cursor-pointer hover:border-red-400 hover:bg-red-500/5 transition-all group">
                                <input type="checkbox" name="skills[]" value="{{ $category->name }}"
                                       {{ in_array($category->name, $profile->skills ?? []) ? 'checked' : '' }}
                                       class="w-4 h-4 accent-red-500 rounded">
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300 group-hover:text-red-500 transition-colors">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Area Layanan -->
                <div>
                    <label class="block text-xs font-black text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">Area Layanan</label>
                    <input type="text" name="service_area" value="{{ $profile->service_area }}"
                           class="block w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#111] text-gray-900 dark:text-gray-100 focus:border-red-500 focus:ring-red-500 rounded-xl px-4 py-3 text-sm"
                           placeholder="Contoh: Surabaya Selatan">
                </div>

                <!-- Operational Hours -->
                <div>
                    <label class="block text-xs font-black text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">Jam Operasional</label>
                    <input type="text" name="operational_hours" value="{{ $profile->operational_hours }}"
                           class="block w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#111] text-gray-900 dark:text-gray-100 focus:border-red-500 focus:ring-red-500 rounded-xl px-4 py-3 text-sm"
                           placeholder="Contoh: Senin–Jumat 08.00–17.00">
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 py-4 bg-gradient-to-r from-red-500 to-rose-600 hover:from-rose-600 hover:to-red-500 text-white rounded-2xl font-black text-sm uppercase tracking-wider transition-all active:scale-[0.98] shadow-lg hover:shadow-red-500/25 cursor-pointer">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()"
                            class="px-6 py-4 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10 rounded-2xl font-bold text-sm transition-all cursor-pointer">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeEditModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        // Auto-open if profile update had errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', () => openEditModal());
        @endif
    </script>
</x-app-layout>
