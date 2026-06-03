<footer class="bg-white dark:bg-mtm-dark border-t border-gray-100 dark:border-white/5 pt-32 pb-16 relative overflow-hidden">
    <!-- Decoration -->
    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-mtm-red via-mtm-brown to-mtm-red"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-4 gap-16 mb-24">
            <div class="lg:col-span-2 space-y-8">
                <a href="{{ url('/') }}" class="flex items-center gap-4 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-mtm-red to-mtm-brown rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-500">
                        <span class="text-white font-bold text-xl">M</span>
                    </div>
                    <div>
                        <span class="font-bold text-2xl text-mtm-red dark:text-mtm-red-light font-poppins tracking-tight">MTM</span>
                        <p class="text-[10px] text-mtm-brown dark:text-mtm-brown-light font-bold uppercase tracking-[0.2em] -mt-1">Mas Tulung Mas</p>
                    </div>
                </a>
                <p class="text-gray-500 dark:text-gray-400 max-w-md leading-relaxed text-lg">
                    Platform digital gotong royong yang menghubungkan masyarakat dengan mitra terpercaya untuk segala jenis bantuan dalam satu klik.
                </p>
                <div class="flex items-center gap-4">
                    @php
                        $socials = [
                            ['icon' => 'facebook', 'url' => '#'],
                            ['icon' => 'instagram', 'url' => '#'],
                            ['icon' => 'twitter', 'url' => '#'],
                            ['icon' => 'linkedin', 'url' => '#'],
                        ];
                    @endphp
                    @foreach($socials as $social)
                        <a href="{{ $social['url'] }}" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400 hover:bg-mtm-red hover:text-white hover:scale-110 transition-all duration-300">
                            <i class="fab fa-{{ $social['icon'] }} text-xl"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-8 font-poppins text-lg uppercase tracking-widest">Layanan</h4>
                <ul class="space-y-4">
                    @foreach(['Kurir Express', 'Asisten Pribadi', 'Jasa Antre', 'Bantuan Teknis', 'Kebersihan Rumah'] as $item)
                        <li>
                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-mtm-red dark:hover:text-mtm-red-light transition-colors flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-700 group-hover:bg-mtm-red transition-colors"></span>
                                {{ $item }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-8 font-poppins text-lg uppercase tracking-widest">Perusahaan</h4>
                <ul class="space-y-4">
                    @foreach(['Tentang Kami', 'Karir', 'Syarat & Ketentuan', 'Kebijakan Privasi', 'Pusat Bantuan'] as $item)
                        <li>
                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-mtm-red dark:hover:text-mtm-red-light transition-colors flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-700 group-hover:bg-mtm-red transition-colors"></span>
                                {{ $item }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="pt-12 border-t border-gray-100 dark:border-white/5 flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                &copy; {{ date('Y') }} <span class="text-mtm-red font-bold">Mas Tulung Mas</span>. Seluruh hak cipta dilindungi.
            </p>
            <div class="flex items-center gap-6 text-sm text-gray-500 dark:text-gray-400 font-medium">
                <span>Dibuat dengan <span class="text-mtm-red animate-pulse">♥</span> untuk Indonesia</span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span>v1.0.0</span>
            </div>
        </div>
    </div>
</footer>
