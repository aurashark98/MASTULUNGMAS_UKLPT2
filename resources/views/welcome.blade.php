<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.4] pointer-events-none z-0"></div>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-32 pb-20 overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Content -->
                <div x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 500)" class="relative">
                    <!-- Premium Badge -->
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 scale-in" 
                         class="inline-flex items-center gap-2 px-4 py-2 bg-[#EF4444]/10 border border-[#EF4444]/20 rounded-full mb-8">
                        <svg class="w-4 h-4 text-[#DC2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"></path>
                        </svg>
                        <span class="text-xs font-black text-[#DC2626] uppercase tracking-[0.2em]">Platform Gotong Royong Digital</span>
                    </div>

                    <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" 
                        class="text-5xl md:text-7xl font-black mb-8 leading-[0.95] tracking-tighter text-gray-900 dark:text-white">
                        <span class="heading-gradient">Bantuan Apa Pun,</span> <br>
                        <span class="heading-gradient">Kini Dalam Satu Klik</span>
                    </h2>

                    <!-- Description -->
                    <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-400 fade-up" 
                       class="text-xl text-gray-600 dark:text-gray-300 mb-12 leading-relaxed max-w-lg font-medium">
                        Mas Tulung Mas menghubungkan masyarakat dengan mitra terpercaya untuk membantu kebutuhan sehari-hari secara cepat, aman, dan profesional.
                    </p>

                    <!-- CTA Buttons -->
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-600 fade-up" 
                         class="flex flex-col sm:flex-row gap-6">
                        <a href="{{ route('tasks.create') }}" class="btn-premium">
                            Pesan Bantuan
                            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Content (Visual) -->
                <div class="relative perspective-2000 hidden md:block" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 800)">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1500 rotate-y-12" class="relative z-10 animate-float">
                        <!-- Phone Mockup -->
                        <div class="mx-auto w-[340px] aspect-[9/18.5] bg-[#0F0F0F] rounded-[3.5rem] p-4 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.7)] border-4 border-white/5 relative overflow-hidden">
                            <!-- Inner Glow -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-mtm-red/20 to-transparent pointer-events-none"></div>
                            
                            <!-- Screen Content -->
                            <div class="w-full h-full bg-[#050505] rounded-[2.8rem] overflow-hidden relative">
                                <!-- Status Bar -->
                                <div class="h-8 flex items-center justify-between px-8 pt-4">
                                    <div class="w-12 h-4 bg-white/5 rounded-full"></div>
                                    <div class="flex gap-1.5">
                                        <div class="w-4 h-4 rounded-full bg-white/5"></div>
                                        <div class="w-4 h-4 rounded-full bg-white/5"></div>
                                    </div>
                                </div>

                                <!-- App Layout -->
                                <div class="p-6 pt-12 space-y-6">
                                    <div class="grid grid-cols-2 gap-4">
                                        @php
                                            $mockupServices = ['Kurir', 'Asisten', 'Antre', 'Teknis'];
                                        @endphp
                                        @foreach($mockupServices as $service)
                                            <div class="aspect-square bg-white/5 border border-white/5 rounded-[2rem] p-4 flex flex-col items-center justify-center gap-3 group hover:bg-mtm-red/20 transition-all">
                                                <div class="w-10 h-10 bg-mtm-red/20 rounded-2xl flex items-center justify-center text-mtm-red">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                </div>
                                                <span class="text-[10px] font-bold text-mtm-red uppercase tracking-widest">{{ $service }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="h-32 bg-white/5 border border-white/5 rounded-[2rem] p-6 space-y-3">
                                        <div class="w-2/3 h-4 bg-white/10 rounded-full"></div>
                                        <div class="w-full h-4 bg-white/5 rounded-full"></div>
                                        <div class="w-1/2 h-4 bg-white/5 rounded-full"></div>
                                    </div>
                                </div>

                                <!-- App Bottom Nav -->
                                <div class="absolute bottom-0 left-0 right-0 h-20 bg-black/80 backdrop-blur-md border-t border-white/5 flex items-center justify-around px-6 pb-2">
                                    <div class="w-10 h-10 rounded-full bg-mtm-red shadow-lg shadow-mtm-red/40 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-white/5"></div>
                                    <div class="w-10 h-10 rounded-full bg-white/5"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Success Card -->
                        <div class="absolute -right-16 top-1/4 bg-white dark:bg-[#252525] p-5 rounded-[2rem] shadow-2xl animate-bounce-slow border border-[#E5E7EB] dark:border-white/10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 border border-green-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-[#111827] dark:text-white">Tugas Selesai</p>
                                    <p class="text-xs text-[#6B7280] font-bold tracking-tight">+1.200 hari ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-20 relative z-10">
        <div class="container mx-auto px-6">

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($categories as $category)
                    <a href="{{ route('tasks.create', ['category_id' => $category->id]) }}" class="block group bg-white dark:bg-[#252525] p-10 rounded-[3rem] border border-[#E5E7EB] dark:border-white/5 hover:shadow-2xl hover:shadow-red-500/20 dark:hover:shadow-red-500/40 hover:-translate-y-2 transition-all duration-500"
                         x-data="{ shown: false }" x-intersect="shown = true"
                         x-show="shown" x-transition:enter="transition ease-out duration-700 delay-{{ $loop->index * 100 }} fade-up">
                        
                        <div class="w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-3xl flex items-center justify-center text-[#374151] dark:text-white mb-10 group-hover:bg-gradient-to-r group-hover:from-[#EF4444] group-hover:to-[#F59E0B] group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-sm border border-[#E5E7EB] dark:border-white/5">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        
                        <h4 class="text-2xl font-black mb-4 text-[#111827] dark:text-white group-hover:text-[#DC2626] transition-colors">{{ $category->name }}</h4>
                        <p class="text-[#374151] dark:text-gray-300 font-medium text-sm leading-relaxed mb-8">
                            {{ $category->description }}
                        </p>
                        
                        <div class="flex items-center gap-3 text-transparent bg-clip-text bg-gradient-to-r from-[#EF4444] to-[#F59E0B] font-black text-xs uppercase tracking-[0.2em] opacity-0 group-hover:opacity-100 translate-x-[-20px] group-hover:translate-x-0 transition-all duration-500">
                            Pesan Sekarang
                            <svg class="w-4 h-4 text-[#EA580C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Bantuan Cepat Section (Hanya untuk user yang sudah login) -->
    @auth
        @if(Auth::user()->role === 'user')
        <section id="bantuan-cepat" class="py-20 relative z-10" x-data="quickHelpConsole()">
            <div class="container mx-auto px-6">

                <!-- Section Header -->
                <div class="max-w-4xl mx-auto text-center mb-12" x-data="{ shown: false }" x-intersect="shown = true">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-700 fade-up"
                         class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-full mb-6">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        <span class="text-xs font-black text-red-500 uppercase tracking-[0.2em]">Fitur Darurat</span>
                    </div>
                    <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up"
                        class="text-4xl md:text-6xl font-black mb-6 leading-tight tracking-tighter text-[#111827] dark:text-white">
                        <span class="heading-gradient">Bantuan Cepat</span>
                    </h2>
                    <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up"
                       class="text-lg text-[#374151] dark:text-gray-300 font-medium max-w-2xl mx-auto">
                        Kehabisan bensin? Butuh obat mendesak? Perlu angkut barang sekarang? Mitra terdekat siap datang 
                        <strong class="text-red-500">tanpa proses tawar-menawar</strong>.
                    </p>
                </div>

                <!-- Main Bantuan Cepat Card -->
                <div class="max-w-4xl mx-auto">
                    <div class="relative bg-gradient-to-br from-[#0F0F0F] to-[#1a1a1a] rounded-[3rem] p-10 md:p-14 border border-red-500/20 shadow-2xl shadow-red-500/10 overflow-hidden">
                        <!-- Glow bg -->
                        <div class="absolute -top-20 -right-20 w-64 h-64 bg-red-500/10 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col lg:flex-row items-center gap-10">
                            <!-- Left: Info -->
                            <div class="flex-1 text-center lg:text-left space-y-6">
                                <div class="inline-flex items-center gap-3">
                                    <div class="w-16 h-16 rounded-3xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-500 animate-pulse">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-red-500/20">Darurat & Mendesak</span>
                                </div>

                                <div class="space-y-3">
                                    <h3 class="text-3xl font-black text-white font-poppins">Butuh Bantuan <span class="text-red-400">Sekarang?</span></h3>
                                    <p class="text-gray-400 text-sm leading-relaxed font-medium">
                                        Tidak perlu menunggu penawaran. Sistem kami langsung mencarikan Mitra aktif terdekat dan menugaskan mereka pada Anda dalam hitungan menit.
                                    </p>
                                </div>

                                <!-- Quota Display -->
                                <div class="inline-flex items-center gap-2.5 px-4 py-2.5 bg-white/5 border border-white/10 rounded-2xl text-sm font-bold text-gray-300">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Kuota minggu ini: <span class="text-red-400 font-black" x-text="quotaText">Memuat...</span>
                                </div>

                                <!-- Use Cases -->
                                <div class="flex flex-wrap gap-2 justify-center lg:justify-start">
                                    @foreach(['Kehabisan Bensin', 'Beli Obat', 'Angkut Barang', 'Antar Dokumen', 'Lainnya'] as $useCase)
                                        <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[11px] font-bold text-gray-400">{{ $useCase }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Right: CTA Button -->
                            <div class="flex flex-col items-center gap-5">
                                <button @click="openQuickHelp()"
                                        :disabled="quotaCount >= 2"
                                        :class="quotaCount >= 2
                                            ? 'bg-gray-700 text-gray-500 cursor-not-allowed'
                                            : 'bg-gradient-to-br from-red-500 to-rose-600 hover:from-rose-500 hover:to-red-600 text-white shadow-2xl shadow-red-500/30 hover:shadow-red-500/50 hover:scale-105 active:scale-95 cursor-pointer'"
                                        class="relative w-48 h-48 rounded-full font-black text-sm uppercase tracking-wider transition-all duration-300 flex flex-col items-center justify-center gap-3 border-4 border-red-500/30">
                                    <template x-if="quotaCount < 2">
                                        <span class="absolute inset-0 rounded-full border-4 border-red-500/30 animate-ping"></span>
                                    </template>
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <span class="text-center leading-tight">Butuh<br>Bantuan<br>Sekarang</span>
                                </button>
                                <p class="text-[11px] text-gray-500 text-center max-w-[180px]">Maks 2x per minggu. Respon rata-rata &lt; 5 menit.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bantuan Cepat Modal -->
            <div x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-[60]"
                 x-cloak>

                <div x-show="showModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                     class="bg-white dark:bg-[#1a1a1a] border border-gray-200 dark:border-white/5 w-full max-w-lg rounded-[2.5rem] p-8 md:p-10 shadow-2xl relative overflow-hidden space-y-6 text-left"
                     @click.outside="closeModal()"
                     x-cloak>

                    <div class="absolute -top-20 -right-20 w-48 h-48 bg-red-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between border-b border-gray-100 dark:border-white/5 pb-4">
                        <div class="space-y-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-500/10 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span>
                                Konfirmasi Bantuan Cepat
                            </span>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white font-poppins">Kirim Permintaan Darurat</h3>
                        </div>
                        <button type="button" @click="closeModal()" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-white rounded-full hover:bg-gray-100 dark:hover:bg-white/5 transition-all cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- GPS Indicator -->
                    <div class="bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-gray-800 rounded-2xl p-4 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full" :class="gpsActive ? 'bg-green-500 animate-pulse' : 'bg-amber-500 animate-ping'"></div>
                            <span class="font-bold text-gray-700 dark:text-gray-300" x-text="gpsText">Mendeteksi lokasi Anda...</span>
                        </div>
                        <button type="button" @click="detectGPS()" class="text-red-500 font-bold hover:underline">GPS Ulang</button>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submitRequest()" class="space-y-4">


                        <div>
                            <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wider">Tingkat Kedaruratan (Estimasi Harga)</label>
                            <select x-model="formData.urgency_level" required
                                    class="block w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#1a1a1a] text-gray-900 dark:text-gray-100 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm px-4 py-3 text-sm">
                                <option value="low">Rendah (Harga Normal 1x)</option>
                                <option value="medium">Sedang (Prioritas, Harga 1.5x)</option>
                                <option value="high">Tinggi (Sangat Darurat, Harga 2x)</option>
                            </select>
                        </div>



                        <div>
                            <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wider">Alamat Lokasi Penjemputan / Bantuan</label>
                            <input type="text" x-model="formData.location" required
                                   class="block w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#1a1a1a] text-gray-900 dark:text-gray-100 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm px-4 py-3 text-sm"
                                   placeholder="Memuat alamat Anda..." />
                        </div>

                        <button type="submit"
                                :disabled="submitting || !gpsActive"
                                :class="submitting || !gpsActive
                                    ? 'bg-gray-200 dark:bg-gray-800 text-gray-400 dark:text-gray-600 cursor-not-allowed'
                                    : 'bg-gradient-to-r from-red-500 to-rose-600 hover:from-rose-600 hover:to-red-500 text-white shadow-lg hover:shadow-red-500/25 active:scale-[0.98] cursor-pointer'"
                                class="w-full py-4 rounded-2xl font-black text-sm uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                            <svg x-show="submitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="buttonText">Kirim Permintaan Darurat</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sonar Radar Waiting Screen -->
            <div x-show="searching"
                 class="fixed inset-0 bg-black/90 backdrop-blur-md flex flex-col items-center justify-center p-4 z-[60] text-white text-center space-y-8"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
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
                    <h4 class="text-2xl font-black font-poppins">Mencari Mitra Terdekat...</h4>
                    <p class="text-sm text-red-200 leading-relaxed">Permintaan Bantuan Cepat Anda sedang disiarkan ke para Mitra aktif terdekat. Mitra pertama yang menerima akan langsung ditugaskan untuk Anda.</p>
                </div>

                <button type="button" @click="cancelSearch()"
                        class="py-3 px-8 bg-white/10 hover:bg-white/20 text-white rounded-2xl text-sm font-bold transition-all cursor-pointer border border-white/10">
                    Batalkan Permintaan
                </button>
            </div>
        </section>
        @endif
    @endauth

    <!-- Stats Section -->
    <section class="py-32 relative overflow-hidden z-10">
        <div class="bg-gradient-to-r from-[#EF4444] to-[#F59E0B] relative py-28 shadow-2xl">
            <!-- Plus Pattern Overlay -->
            <div class="absolute inset-0 plus-pattern opacity-30"></div>
            
            <div class="container mx-auto px-4 relative z-10">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                    @php
                        $stats = [
                            ['label' => 'Pengguna', 'value' => $totalUsers ?? 10, 'suffix' => '+'],
                            ['label' => 'Mitra', 'value' => $totalMitra ?? 1, 'suffix' => '+'],
                            ['label' => 'Tugas Selesai', 'value' => $totalCompletedTasks ?? 25, 'suffix' => '+'],
                            ['label' => 'Kepuasan', 'value' => $satisfactionRate ?? 98, 'suffix' => '%'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                        <div class="text-center text-white space-y-2" x-data="{ count: 0 }" x-intersect="let interval = setInterval(() => { if(count < {{ $stat['value'] }}) { count += 1 } else { count = {{ $stat['value'] }}; clearInterval(interval) } }, 50)">
                            <h3 class="text-6xl md:text-8xl font-black tracking-tighter" x-text="count + '{{ $stat['suffix'] }}'">0</h3>
                            <p class="text-sm font-black uppercase tracking-[0.2em] opacity-80">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section id="testimoni" class="py-40 relative z-10 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center mb-20" x-data="{ shown: false }" x-intersect="shown = true">
                <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" 
                    class="text-5xl md:text-7xl font-black mb-8 leading-tight tracking-tighter text-[#111827] dark:text-white">
                    <span class="heading-gradient">Testimoni Pengguna</span>
                </h2>
                <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                   class="text-xl text-[#374151] dark:text-gray-300 font-medium">
                    Apa kata mereka yang telah menggunakan MTM
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $testimonials = [
                        [
                            'name' => 'Budi Santoso',
                            'role' => 'Mahasiswa',
                            'initials' => 'BS',
                            'text' => 'MTM sangat membantu saya saat sibuk kuliah. Mitra yang datang selalu profesional dan tepat waktu!',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Siti Nurhaliza',
                            'role' => 'Pengusaha UMKM',
                            'initials' => 'SN',
                            'text' => 'Layanan kurir MTM sangat membantu bisnis saya. Pengiriman cepat dan harga terjangkau.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Andi Wijaya',
                            'role' => 'Pekerja Kantoran',
                            'initials' => 'AW',
                            'text' => 'Tidak ada lagi stress antre! Jasa antre MTM benar-benar menghemat waktu saya.',
                            'rating' => 5
                        ]
                    ];
                @endphp

                @foreach($testimonials as $testi)
                    <div class="bg-white dark:bg-[#252525] p-10 rounded-[3rem] border border-[#E5E7EB] dark:border-white/5 relative group hover:-translate-y-2 transition-all duration-500 shadow-lg hover:shadow-2xl hover:shadow-red-500/20">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-14 h-14 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-md">
                                {{ $testi['initials'] }}
                            </div>
                            <div>
                                <h4 class="font-black text-lg leading-tight text-[#111827] dark:text-white">{{ $testi['name'] }}</h4>
                                <p class="text-[#374151] dark:text-gray-300 text-sm font-bold">{{ $testi['role'] }}</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-1 mb-6 text-amber-500">
                            @for($i=0; $i<$testi['rating']; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>

                        <p class="text-[#374151] dark:text-gray-300 font-medium leading-relaxed italic">
                            "{{ $testi['text'] }}"
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-40 relative z-10">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center mb-20">
                 <h2 class="text-5xl md:text-7xl font-black mb-8 leading-tight tracking-tighter text-[#111827] dark:text-white">
                     <span class="heading-gradient">Pertanyaan Umum</span>
                 </h2>
                 <p class="text-xl text-[#374151] dark:text-gray-300 font-medium">
                     Temukan jawaban untuk pertanyaan yang sering ditanyakan
                 </p>
             </div>

            <div class="max-w-3xl mx-auto space-y-4" x-data="{ active: null }">
                @php
                    $faqs = [
                        [
                            'q' => 'Bagaimana cara memesan layanan MTM?',
                            'a' => 'Anda dapat memesan melalui website kami dengan memilih layanan yang dibutuhkan, mengisi detail pesanan, dan melakukan pembayaran.'
                        ],
                        [
                            'q' => 'Apakah mitra MTM sudah terverifikasi?',
                            'a' => 'Ya, seluruh mitra kami telah melalui proses verifikasi identitas and seleksi ketat untuk menjamin keamanan dan kualitas layanan.'
                        ],
                        [
                            'q' => 'Bagaimana sistem pembayaran di MTM?',
                            'a' => 'Kami mendukung berbagai metode pembayaran mulai dari transfer bank, e-wallet, hingga QRIS yang terjamin keamanannya.'
                        ]
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="bg-white dark:bg-[#252525] rounded-2xl border border-[#E5E7EB] dark:border-white/5 overflow-hidden shadow-sm hover:shadow-md transition-all">
                        <button @click="active = (active === {{ $index }} ? null : {{ $index }})" 
                                class="w-full px-8 py-6 flex items-center justify-between text-left group">
                            <span class="text-lg font-bold transition-colors text-[#111827] dark:text-white group-hover:text-[#DC2626]" 
                                  :class="active === {{ $index }} ? 'text-[#DC2626]' : ''">
                                {{ $faq['q'] }}
                            </span>
                            <div class="w-8 h-8 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center transition-all duration-300"
                                 :class="active === {{ $index }} ? 'rotate-180 bg-gradient-to-r from-[#EF4444] to-[#F59E0B]' : ''">
                                <svg class="w-4 h-4 transition-colors" :class="active === {{ $index }} ? 'text-white' : 'text-[#374151] dark:text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="active === {{ $index }}" 
                             x-collapse
                             x-cloak>
                            <div class="px-8 pb-6 text-[#374151] dark:text-gray-300 leading-relaxed font-medium">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-40 relative z-10">
        <div class="container mx-auto px-6">
            <div class="bg-[#0F0F0F] rounded-[5rem] p-16 md:p-32 text-center relative overflow-hidden border border-white/5 shadow-3xl">
                <!-- Background Decoration -->
                <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                    <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-mtm-red/10 rounded-full blur-[120px]"></div>
                    <div class="absolute -bottom-1/2 -right-1/2 w-full h-full bg-mtm-brown/10 rounded-full blur-[120px]"></div>
                </div>

                <div class="relative z-10 max-w-4xl mx-auto" x-data="{ shown: false }" x-intersect="shown = true">
                    @auth
                        <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" 
                            class="text-5xl md:text-8xl font-black text-white mb-6 leading-none tracking-tighter">
                            Halo, <br> <span class="heading-gradient">{{ Auth::user()->name }}</span>
                        </h2>
                        
                        @if(Auth::user()->role === 'mitra')
                            <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                               class="text-xl text-gray-300 mb-12 leading-relaxed font-medium">
                                Siap membantu sesama hari ini? Cari tugas aktif di sekitar Anda sekarang atau pantau orderan Anda melalui konsol mitra.
                            </p>
                            <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-400 fade-up" 
                                 class="flex flex-col sm:flex-row justify-center gap-8">
                                <a href="{{ route('mitra.dashboard') }}" class="px-14 py-6 bg-white text-[#1A1A1A] rounded-full font-black text-xl hover:scale-105 active:scale-95 transition-all shadow-2xl">Buka Konsol Mitra</a>
                                <a href="{{ route('tasks.index') }}" class="px-14 py-6 border-2 border-white/10 text-white rounded-full font-black text-xl hover:bg-white hover:text-[#1A1A1A] transition-all">Cari Tugas Aktif</a>
                            </div>
                        @elseif(Auth::user()->role === 'admin')
                            <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                               class="text-xl text-gray-300 mb-12 leading-relaxed font-medium">
                                Masuk ke control panel untuk mengelola pengguna, memverifikasi mitra baru, dan memantau transaksi platform.
                            </p>
                            <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-400 fade-up" 
                                 class="flex flex-col sm:flex-row justify-center gap-8">
                                <a href="{{ route('admin.dashboard') }}" class="px-14 py-6 bg-white text-[#1A1A1A] rounded-full font-black text-xl hover:scale-105 active:scale-95 transition-all shadow-2xl">Admin Control Panel</a>
                            </div>
                        @else
                            <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                               class="text-xl text-gray-300 mb-12 leading-relaxed font-medium">
                                Mulai perjalanan gotong royong Anda hari ini. Butuh bantuan cepat, aman, dan profesional?
                            </p>
                            <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-400 fade-up" 
                                 class="flex flex-col sm:flex-row justify-center gap-8">
                                <a href="{{ route('tasks.create') }}" class="px-14 py-6 bg-white text-[#1A1A1A] rounded-full font-black text-xl hover:scale-105 active:scale-95 transition-all shadow-2xl">Pesan Bantuan</a>
                                <a href="{{ route('dashboard') }}" class="px-14 py-6 border-2 border-white/10 text-white rounded-full font-black text-xl hover:bg-white hover:text-[#1A1A1A] transition-all">Lihat Tugas Saya</a>
                            </div>
                        @endif
                    @else
                        <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" 
                            class="text-5xl md:text-8xl font-black text-white mb-10 leading-none tracking-tighter">
                            Siap Memulai <br> <span class="heading-gradient">Perubahan?</span>
                        </h2>
                        <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                           class="text-xl text-gray-300 mb-16 leading-relaxed font-medium">
                            Bergabunglah dengan ekosistem gotong royong digital terbesar di Indonesia. <br class="hidden md:block"> Bantuan kini lebih dekat dari yang Anda bayangkan.
                        </p>
                        <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-400 fade-up" 
                             class="flex flex-col sm:flex-row justify-center gap-8">
                            <a href="{{ route('register') }}" @click.prevent="$dispatch('open-modal', 'auth-modal'); setTimeout(() => $dispatch('open-auth-modal', { tab: 'register', role: 'user' }), 50)" class="px-14 py-6 bg-white text-[#1A1A1A] rounded-full font-black text-xl hover:scale-105 active:scale-95 transition-all shadow-2xl">Daftar Sekarang</a>
                            <a href="{{ route('tentang-kami') }}" class="px-14 py-6 border-2 border-white/10 text-white rounded-full font-black text-xl hover:bg-white hover:text-[#1A1A1A] transition-all">Tentang Kami</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- GSAP Initialization -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);
            
            // Smooth reveal for all glass-cards
            gsap.utils.toArray('.glass-card').forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top bottom-=100',
                        toggleActions: 'play none none none'
                    },
                    opacity: 0,
                    y: 50,
                    duration: 1,
                    ease: 'power4.out',
                    delay: i % 4 * 0.1
                });
            });
        });
    </script>

    @auth
    @if(Auth::user()->role === 'user')
    <script>
    function quickHelpConsole() {
        return {
            showModal: false,
            searching: false,
            gpsActive: false,
            gpsText: 'Mendeteksi lokasi Anda...',
            quotaCount: 0,
            quotaText: 'Memuat...',
            submitting: false,
            buttonText: 'Kirim Permintaan Darurat',
            taskId: null,
            statusInterval: null,
            formData: {
                category_id: '',
                urgency_level: 'medium',
                description: '',
                location: '',
                latitude: null,
                longitude: null
            },

            init() {
                this.fetchQuota();
            },

            fetchQuota() {
                fetch("{{ route('quick-help.check-quota') }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.quotaCount = data.quota_count;
                            this.quotaText = `${data.quota_count} / 2 digunakan minggu ini`;
                        }
                    })
                    .catch(() => { this.quotaText = 'Gagal memuat kuota'; });
            },

            openQuickHelp() {
                if (this.quotaCount >= 2) {
                    alert('Kuota mingguan Bantuan Cepat Anda sudah habis (maks 2x per minggu).');
                    return;
                }
                this.showModal = true;
                this.detectGPS();
            },

            closeModal() {
                this.showModal = false;
                this.formData.description = '';
                this.formData.category_id = '';
                this.formData.urgency_level = 'medium';
            },

            detectGPS() {
                this.gpsActive = false;
                this.gpsText = 'Mengakses GPS...';
                if (!navigator.geolocation) {
                    this.gpsText = 'Geolocation tidak didukung. Isi lokasi secara manual.';
                    this.gpsActive = true;
                    return;
                }
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.formData.latitude = pos.coords.latitude;
                        this.formData.longitude = pos.coords.longitude;
                        this.gpsText = 'Koordinat GPS terdeteksi!';
                        this.reverseGeocode(pos.coords.latitude, pos.coords.longitude);
                    },
                    (err) => {
                        console.error(err);
                        this.gpsText = 'Gagal mendapatkan GPS. Isi lokasi secara manual.';
                        this.gpsActive = true;
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            },

            reverseGeocode(lat, lng) {
                this.gpsText = 'Menerjemahkan alamat lokasi...';
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=id`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name) {
                            this.formData.location = data.display_name;
                            this.gpsText = 'Lokasi siap digunakan!';
                        } else {
                            this.gpsText = 'GPS aktif. Tulis lokasi manual di bawah.';
                        }
                        this.gpsActive = true;
                    })
                    .catch(() => {
                        this.gpsText = 'GPS aktif. Tulis lokasi manual di bawah.';
                        this.gpsActive = true;
                    });
            },

            submitRequest() {
                this.submitting = true;
                this.buttonText = 'Mengirim Permintaan...';

                fetch("{{ route('quick-help.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(this.formData)
                })
                .then(res => res.json())
                .then(data => {
                    this.submitting = false;
                    this.buttonText = 'Kirim Permintaan Darurat';
                    if (data.success) {
                        this.taskId = data.task_id;
                        this.showModal = false;
                        this.searching = true;
                        this.fetchQuota();
                        this.statusInterval = setInterval(() => this.checkTaskStatus(), 2000);
                    } else {
                        alert(data.message || 'Gagal mengirim permintaan.');
                    }
                })
                .catch(err => {
                    this.submitting = false;
                    this.buttonText = 'Kirim Permintaan Darurat';
                    console.error(err);
                    alert('Terjadi kesalahan jaringan.');
                });
            },

            checkTaskStatus() {
                if (!this.taskId) return;
                fetch(`/quick-help/${this.taskId}/status`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (data.status === 'assigned') {
                                this.searching = false;
                                clearInterval(this.statusInterval);
                                alert('Mitra ditemukan! Menghubungkan Anda ke ruang chat...');
                                if (data.chat_room_id) {
                                    window.location.href = `/chat/${data.chat_room_id}`;
                                } else {
                                    window.location.reload();
                                }
                            } else if (data.status === 'cancelled') {
                                this.searching = false;
                                clearInterval(this.statusInterval);
                                alert('Permintaan dibatalkan.');
                            }
                        }
                    })
                    .catch(err => console.error('Error checking status:', err));
            },

            cancelSearch() {
                if (!this.taskId) return;
                if (!confirm('Apakah Anda yakin ingin membatalkan permintaan bantuan cepat ini?')) return;

                fetch(`/quick-help/${this.taskId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.searching = false;
                        clearInterval(this.statusInterval);
                        this.taskId = null;
                        this.fetchQuota();
                        alert('Permintaan berhasil dibatalkan.');
                    } else {
                        alert(data.message || 'Gagal membatalkan permintaan.');
                    }
                })
                .catch(() => alert('Gagal membatalkan permintaan karena kendala koneksi.'));
            }
        }
    }
    </script>
    @endif
    @endauth
</x-app-layout>

