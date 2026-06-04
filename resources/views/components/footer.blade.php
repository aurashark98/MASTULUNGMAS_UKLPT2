<footer class="bg-[#F8FAFC] dark:bg-[#0F0F0F] border-t border-[#E5E7EB] dark:border-white/5 pt-32 pb-16 relative overflow-hidden">
    <!-- Decoration -->
    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#EF4444] to-[#F59E0B]"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-4 gap-16 mb-24">
            <div class="lg:col-span-2 space-y-8">
                <a href="{{ url('/') }}" class="flex items-center gap-4 group">
                    <img src="{{ asset('images/logomtm.png') }}" alt="MTM Logo" class="h-16 w-auto object-contain transition-transform duration-500 group-hover:scale-110">
                </a>
                <p class="text-[#374151] dark:text-gray-400 max-w-md leading-relaxed text-lg">
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
                        <a href="{{ $social['url'] }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-white/5 flex items-center justify-center text-[#374151] dark:text-gray-400 hover:bg-gradient-to-r hover:from-[#EF4444] hover:to-[#F59E0B] hover:text-white hover:scale-110 transition-all duration-300 shadow-sm border border-[#E5E7EB] dark:border-white/5">
                            <i class="fab fa-{{ $social['icon'] }} text-xl"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="font-bold text-[#111827] dark:text-white mb-8 font-poppins text-lg uppercase tracking-widest">Layanan</h4>
                <ul class="space-y-4">
                    @foreach(['Kurir Express', 'Asisten Pribadi', 'Jasa Antre', 'Bantuan Teknis', 'Kebersihan Rumah'] as $item)
                        <li>
                            <a href="#" class="text-[#374151] dark:text-gray-400 hover:text-[#DC2626] transition-colors flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D1D5DB] dark:bg-gray-700 group-hover:bg-[#DC2626] transition-colors"></span>
                                {{ $item }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-[#111827] dark:text-white mb-8 font-poppins text-lg uppercase tracking-widest">Perusahaan</h4>
                <ul class="space-y-4">
                    @foreach(['Tentang Kami', 'Karir', 'Syarat & Ketentuan', 'Kebijakan Privasi', 'Pusat Bantuan'] as $item)
                        <li>
                            <a href="#" class="text-[#374151] dark:text-gray-400 hover:text-[#DC2626] transition-colors flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D1D5DB] dark:bg-gray-700 group-hover:bg-[#DC2626] transition-colors"></span>
                                {{ $item }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="pt-12 border-t border-[#E5E7EB] dark:border-white/5 flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="text-sm text-[#374151] dark:text-gray-400 font-medium">
                &copy; {{ date('Y') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#EF4444] to-[#F59E0B] font-bold">Mas Tulung Mas</span>. Seluruh hak cipta dilindungi.
            </p>
            <div class="flex items-center gap-6 text-sm text-[#374151] dark:text-gray-400 font-medium">
                <span>Dibuat dengan <span class="text-[#DC2626] animate-pulse">♥</span> untuk Indonesia</span>
                <span class="w-1 h-1 rounded-full bg-[#D1D5DB]"></span>
                <span>v1.0.0</span>
            </div>
        </div>
    </div>
</footer>
