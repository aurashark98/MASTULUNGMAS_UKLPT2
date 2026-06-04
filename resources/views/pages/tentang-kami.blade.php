<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.4] pointer-events-none z-0"></div>

    <section class="relative pt-40 pb-24">
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 scale-in" 
                         class="inline-flex items-center gap-2 px-4 py-2 bg-mtm-red/10 border border-mtm-red/20 rounded-full mb-8">
                        <span class="text-xs font-black text-mtm-red uppercase tracking-[0.2em]">Visi Kami</span>
                    </div>
                    <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                        class="text-5xl md:text-7xl font-black mb-8 leading-tight tracking-tighter">
                        Digitalisasi <br> <span class="heading-gradient">Gotong Royong</span>
                    </h2>
                    <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-400 fade-up" 
                       class="text-xl text-[#374151] dark:text-gray-300 mb-10 leading-relaxed font-medium">
                        Mas Tulung Mas (MTM) lahir dari nilai luhur bangsa Indonesia, yaitu gotong royong. Kami percaya bahwa teknologi dapat mempererat ikatan sosial dan membantu masyarakat saling menolong dengan cara yang lebih efisien dan modern.
                    </p>
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-600 fade-up" class="grid grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-3xl font-black text-mtm-red mb-2">2026</h4>
                            <p class="text-[#374151] dark:text-gray-300 font-bold uppercase text-xs tracking-widest">Didirikan</p>
                        </div>
                        <div>
                            <h4 class="text-3xl font-black text-mtm-red mb-2">100%</h4>
                            <p class="text-[#374151] dark:text-gray-300 font-bold uppercase text-xs tracking-widest">Karya Anak Bangsa</p>
                        </div>
                    </div>
                </div>
                <div class="relative" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1500 fade-in" class="relative">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1000&auto=format&fit=crop" class="rounded-[4rem] shadow-3xl grayscale hover:grayscale-0 transition-all duration-1000" alt="Team MTM">
                        <div class="absolute -bottom-10 -right-10 glass p-8 rounded-[3rem] shadow-3xl max-w-[240px]">
                            <p class="text-lg font-bold italic leading-tight">"Menghubungkan kebaikan dalam satu klik."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-24 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h3 class="text-4xl font-black tracking-tighter mb-6">Nilai Utama <span class="text-mtm-red">MTM</span></h3>
                <p class="text-gray-600 dark:text-gray-300 font-medium">Budaya kerja dan komitmen kami kepada seluruh pengguna dan mitra.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass-card p-12 rounded-[3rem] text-center group hover:bg-mtm-red transition-all duration-500">
                    <div class="w-16 h-16 bg-mtm-red/10 rounded-2xl flex items-center justify-center text-mtm-red mx-auto mb-8 group-hover:bg-white group-hover:text-mtm-red transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h5 class="text-2xl font-black mb-4 group-hover:text-white transition-colors">Integritas</h5>
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-white/80 transition-colors">Kejujuran dan transparansi adalah pondasi dari setiap transaksi di platform kami.</p>
                </div>
                <div class="glass-card p-12 rounded-[3rem] text-center group hover:bg-mtm-red transition-all duration-500">
                    <div class="w-16 h-16 bg-mtm-red/10 rounded-2xl flex items-center justify-center text-mtm-red mx-auto mb-8 group-hover:bg-white group-hover:text-mtm-red transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h5 class="text-2xl font-black mb-4 group-hover:text-white transition-colors">Empati</h5>
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-white/80 transition-colors">Kami memahami kebutuhan Anda dan berusaha memberikan solusi yang paling manusiawi.</p>
                </div>
                <div class="glass-card p-12 rounded-[3rem] text-center group hover:bg-mtm-red transition-all duration-500">
                    <div class="w-16 h-16 bg-mtm-red/10 rounded-2xl flex items-center justify-center text-mtm-red mx-auto mb-8 group-hover:bg-white group-hover:text-mtm-red transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h5 class="text-2xl font-black mb-4 group-hover:text-white transition-colors">Inovasi</h5>
                    <p class="text-gray-600 dark:text-gray-300 group-hover:text-white/80 transition-colors">Terus mengembangkan teknologi terbaik untuk menghubungkan kebaikan di seluruh pelosok negeri.</p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
