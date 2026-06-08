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
                        class="text-5xl md:text-7xl font-black mb-8 leading-[0.95] tracking-tighter text-white">
                        <span class="heading-gradient">Bantuan Apa Pun,</span> <br>
                        <span class="heading-gradient">Kini Dalam Satu Klik</span>
                    </h2>

                    <!-- Description -->
                    <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-400 fade-up" 
                       class="text-xl text-black dark:text-gray-300 mb-12 leading-relaxed max-w-lg font-medium">
                        Mas Tulung Mas menghubungkan masyarakat dengan mitra terpercaya untuk membantu kebutuhan sehari-hari secara cepat, aman, dan profesional.
                    </p>

                    <!-- CTA Buttons -->
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-600 fade-up" 
                         class="flex flex-col sm:flex-row gap-6">
                        <a href="{{ route('register') }}" @click.prevent="$dispatch('open-modal', 'auth-modal'); setTimeout(() => $dispatch('open-auth-modal', { tab: 'register', role: 'user' }), 50)" class="btn-premium">
                            Pesan Bantuan
                            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="{{ route('register', ['role' => 'mitra']) }}" @click.prevent="$dispatch('open-modal', 'auth-modal'); setTimeout(() => $dispatch('open-auth-modal', { tab: 'register', role: 'mitra' }), 50)" class="btn-outline-premium">
                            Jadi Mitra Tulung
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
    <section id="layanan" class="py-40 relative z-10">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center mb-24" x-data="{ shown: false }" x-intersect="shown = true">
                <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" 
                    class="text-5xl md:text-7xl font-black mb-8 leading-tight tracking-tighter text-[#111827] dark:text-white">
                    <span class="heading-gradient">Layanan Paling Dicari</span>
                </h2>
                <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                   class="text-xl text-[#374151] dark:text-gray-300 font-medium">
                    Temukan bantuan yang tepat untuk setiap kebutuhan Anda dengan standar layanan profesional.
                </p>
            </div>

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
                        <a href="#" class="px-14 py-6 border-2 border-white/10 text-white rounded-full font-black text-xl hover:bg-white hover:text-[#1A1A1A] transition-all">Hubungi Kami</a>
                    </div>
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
</x-app-layout>
