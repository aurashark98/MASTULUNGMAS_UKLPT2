<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.4] pointer-events-none z-0"></div>

    <section class="relative pt-40 pb-24">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center mb-20" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
                <h2 x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up" 
                    class="text-5xl md:text-7xl font-black mb-8 leading-tight tracking-tighter">
                    Layanan <span class="heading-gradient">MTM</span>
                </h2>
                <p x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-200 fade-up" 
                   class="text-xl text-[#374151] dark:text-gray-300 font-medium">
                    Temukan berbagai kategori bantuan yang kami sediakan untuk mempermudah hidup Anda.
                </p>
            </div>

            @if($categories->isEmpty())
                <div class="glass-card p-16 rounded-[3rem] text-center" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 300)">
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 fade-up">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-8">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-400 dark:text-gray-600 mb-4">Layanan belum tersedia untuk saat ini</h3>
                        <p class="text-gray-500 max-w-md mx-auto">Kami sedang mempersiapkan mitra terbaik untuk melayani Anda. Silakan cek kembali nanti!</p>
                    </div>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        <a href="{{ route('tasks.create', ['category_id' => $category->id]) }}" class="block group glass-card p-10 rounded-[3rem] hover:border-mtm-red/50 hover:shadow-mtm-red/10 transition-all"
                             x-data="{ shown: false }" x-init="setTimeout(() => shown = true, {{ $loop->index * 100 + 300 }})">
                            
                            <div class="w-20 h-20 bg-mtm-red/10 rounded-3xl flex items-center justify-center text-mtm-red mb-10 group-hover:bg-mtm-red group-hover:text-white group-hover:rotate-12 transition-all duration-500">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            
                            <h4 class="text-2xl font-black mb-4 text-gray-900 dark:text-white group-hover:text-mtm-red transition-colors">{{ $category->name }}</h4>
                            <p class="text-gray-650 dark:text-gray-300 font-medium text-sm leading-relaxed mb-8">
                                {{ $category->description }}
                            </p>
                            
                            <div class="flex items-center gap-3 text-mtm-red font-black text-xs uppercase tracking-[0.2em] opacity-0 group-hover:opacity-100 translate-x-[-20px] group-hover:translate-x-0 transition-all duration-500">
                                Pesan Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 relative z-10">
        <div class="container mx-auto px-4">
            <div class="bg-[#0F0F0F] rounded-[4rem] p-16 text-center relative overflow-hidden border border-white/5 shadow-3xl">
                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-4xl font-black text-white mb-6 tracking-tighter">Tidak menemukan yang Anda cari?</h2>
                    <p class="text-gray-400 mb-10 font-medium">Hubungi tim kami untuk permintaan layanan khusus atau bantuan tambahan.</p>
                    <a href="#" class="btn-premium inline-flex">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
