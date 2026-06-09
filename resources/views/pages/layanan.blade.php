<x-app-layout>
    <div class="fixed inset-0 dot-grid opacity-30 pointer-events-none z-0"></div>

    <section class="relative pt-16 pb-24">
        <div class="section-container relative z-10">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-red-50 dark:bg-red-950/40 text-mtm-red text-xs font-black rounded-full uppercase tracking-widest mb-6">Layanan Kami</span>
                <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight tracking-tighter text-gray-900 dark:text-white">
                    Layanan <span class="heading-gradient">MTM</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 font-medium max-w-2xl mx-auto">
                    Temukan berbagai kategori bantuan yang kami sediakan untuk mempermudah hidup Anda.
                </p>
            </div>

            @if($categories->isEmpty())
                <div class="glass-card p-16 rounded-[3rem] text-center max-w-lg mx-auto">
                    <div class="w-20 h-20 bg-gray-100 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-500 dark:text-gray-400 mb-3">Belum Ada Layanan</h3>
                    <p class="text-gray-400 dark:text-gray-500 text-sm">Kami sedang mempersiapkan mitra terbaik. Cek kembali nanti!</p>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categories as $category)
                        <a href="{{ route('tasks.create', ['category_id' => $category->id]) }}"
                           class="block group glass-card p-8 rounded-[2.5rem] hover:border-mtm-red/40 transition-all"
                           x-data="{ shown: false }" x-init="setTimeout(() => shown = true, {{ $loop->index * 80 + 150 }})">

                            <div x-show="shown" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                <div class="w-16 h-16 bg-red-50 dark:bg-red-950/30 rounded-2xl flex items-center justify-center text-mtm-red mb-8 group-hover:bg-mtm-red group-hover:text-white group-hover:rotate-6 transition-all duration-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-mtm-red transition-colors">{{ $category->name }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-6">{{ $category->description }}</p>
                                <div class="flex items-center gap-2 text-mtm-red font-bold text-xs uppercase tracking-wider opacity-0 group-hover:opacity-100 -translate-x-3 group-hover:translate-x-0 transition-all duration-300">
                                    Pesan Sekarang
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>


</x-app-layout>
