<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.4] pointer-events-none z-0"></div>

    <section class="relative pt-40 pb-24">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center mb-24" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
                <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" 
                    class="text-5xl md:text-7xl font-black mb-8 leading-tight tracking-tighter">
                    Cara <span class="heading-gradient">Kerja</span>
                </h2>
                <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                   class="text-xl text-[#374151] dark:text-gray-300 font-medium">
                    Proses sederhana untuk mendapatkan bantuan yang Anda butuhkan dalam hitungan menit.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-12 relative">
                <!-- Step 1 -->
                <div class="relative group" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 400)">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" class="glass-card p-12 rounded-[3rem] h-full">
                        <div class="w-16 h-16 bg-mtm-red text-white rounded-2xl flex items-center justify-center text-3xl font-black mb-8 group-hover:rotate-12 transition-transform shadow-lg shadow-mtm-red/30">1</div>
                        <h4 class="text-2xl font-black mb-6">Pilih Layanan</h4>
                        <p class="text-gray-600 dark:text-gray-300 font-medium leading-relaxed">Pilih kategori bantuan yang Anda butuhkan dari aplikasi atau website kami. Berikan detail tugas dan budget yang sesuai.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative group" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 600)">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" class="glass-card p-12 rounded-[3rem] h-full">
                        <div class="w-16 h-16 bg-mtm-red text-white rounded-2xl flex items-center justify-center text-3xl font-black mb-8 group-hover:rotate-12 transition-transform shadow-lg shadow-mtm-red/30">2</div>
                        <h4 class="text-2xl font-black mb-6">Terima Penawaran</h4>
                        <p class="text-gray-600 dark:text-gray-300 font-medium leading-relaxed">Mitra Tulung kami akan memberikan penawaran terbaik mereka. Anda bisa melihat profil, rating, dan memilih mitra yang paling cocok.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative group" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 800)">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" class="glass-card p-12 rounded-[3rem] h-full">
                        <div class="w-16 h-16 bg-mtm-red text-white rounded-2xl flex items-center justify-center text-3xl font-black mb-8 group-hover:rotate-12 transition-transform shadow-lg shadow-mtm-red/30">3</div>
                        <h4 class="text-2xl font-black mb-6">Bantuan Selesai</h4>
                        <p class="text-gray-600 dark:text-gray-300 font-medium leading-relaxed">Setelah tugas selesai dikerjakan, lakukan pembayaran aman melalui platform kami dan berikan ulasan untuk mitra Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Process Section -->
    <section class="py-24 bg-mtm-red/5 dark:bg-mtm-red/10">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="glass-card p-8 rounded-[4rem] border-white/10 shadow-3xl">
                    <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?q=80&w=1000&auto=format&fit=crop" class="rounded-[3rem] w-full h-[400px] object-cover shadow-2xl" alt="Gotong Royong">
                </div>
                <div class="space-y-8">
                    <h3 class="text-4xl font-black tracking-tighter">Kenapa Menggunakan <span class="text-mtm-red">MTM?</span></h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500/20 text-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-lg">Keamanan Terjamin</h5>
                                <p class="text-gray-500 dark:text-gray-400">Semua mitra kami telah melalui proses verifikasi identitas yang ketat.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500/20 text-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-lg">Harga Transparan</h5>
                                <p class="text-gray-500 dark:text-gray-400">Sistem penawaran memastikan Anda mendapatkan harga terbaik tanpa biaya tersembunyi.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500/20 text-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-lg">Dukungan 24/7</h5>
                                <p class="text-gray-500 dark:text-gray-400">Tim kami siap membantu Anda kapan saja jika terjadi kendala.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
