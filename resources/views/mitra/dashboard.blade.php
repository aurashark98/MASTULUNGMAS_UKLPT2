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
                <!-- Driver Status Switcher -->
                <div class="bg-gray-100/50 dark:bg-black/20 p-4 rounded-3xl border border-gray-200/50 dark:border-white/5 flex items-center justify-between gap-6 flex-1 sm:flex-initial">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Status Bekerja</p>
                        <p class="text-sm font-bold mt-0.5 {{ $profile->is_online ? 'text-green-500' : 'text-gray-500' }}">
                            {{ $profile->is_online ? 'Siap Menerima Kerja' : 'Istirahat / Off' }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('mitra.toggle-status') }}">
                        @csrf
                        <button type="submit" 
                                class="relative inline-flex h-9 w-16 items-center rounded-full transition-all duration-300 focus:outline-none {{ $profile->is_online ? 'bg-green-500 shadow-md shadow-green-500/25' : 'bg-gray-300 dark:bg-gray-800' }}">
                            <span class="sr-only">Toggle Status</span>
                            <span class="inline-block h-6 w-6 transform rounded-full bg-white transition-all duration-300 {{ $profile->is_online ? 'translate-x-9' : 'translate-x-1' }}"></span>
                        </button>
                    </form>
                </div>

                <!-- Quick Actions (Switch Mode & Logout) -->
                <div class="flex flex-row gap-3 justify-center">
                    <form method="POST" action="{{ route('profile.switch-role') }}" class="flex-1 sm:flex-initial">
                        @csrf
                        <button type="submit" 
                                class="h-14 w-full sm:w-auto px-5 rounded-3xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 border border-amber-500/10 active:scale-95 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            Mode Pengguna
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="flex-1 sm:flex-initial">
                        @csrf
                        <button type="submit" 
                                class="h-14 w-full sm:w-auto px-5 rounded-3xl bg-red-500/10 hover:bg-red-500/20 text-red-500 font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 border border-red-500/10 active:scale-95 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
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
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mt-1.5
                                        {{ $assignment->task->status === 'in_progress' ? 'bg-blue-500/10 text-blue-500' : 'bg-amber-500/10 text-amber-500' }}">
                                        {{ $assignment->task->status === 'in_progress' ? 'Sedang Dikerjakan' : 'Tawaran Diterima' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Job details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-medium text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4.5 h-4.5 text-mtm-red flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>Lokasi: {{ $assignment->task->location }}</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4.5 h-4.5 text-mtm-red flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
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
                                    <form method="POST" action="{{ route('mitra.tasks.complete', $assignment->task) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold text-sm shadow-lg hover:shadow-green-500/20 active:scale-[0.98] transition-all">
                                            Selesaikan Pekerjaan
                                        </button>
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
                                                   required 
                                                   class="block w-full bg-white dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-xl text-sm p-3.5 focus:ring-mtm-red focus:border-mtm-red font-bold text-gray-800 dark:text-white" />
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
                                    <span class="text-[9px] px-2 py-0.5 font-bold uppercase rounded-full 
                                        {{ $bid->status === 'pending' ? 'bg-amber-500/10 text-amber-500' : 'bg-red-500/10 text-red-500' }}">
                                        {{ $bid->status === 'pending' ? 'Pending' : 'Ditolak' }}
                                    </span>
                                    <span class="text-[9px] text-gray-400">{{ $bid->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center py-4 font-medium">Belum ada penawaran aktif yang Anda kirimkan.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
