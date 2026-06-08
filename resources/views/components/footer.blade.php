<footer class="bg-[#F8FAFC] dark:bg-[#0F0F0F] border-t border-[#E5E7EB] dark:border-white/5 pt-32 pb-16 relative overflow-hidden">
    <!-- Decoration -->
    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#EF4444] to-[#F59E0B]"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col items-center text-center mb-24 space-y-8">
            <a href="{{ url('/') }}" class="flex items-center gap-4 group">
                <img src="{{ asset('images/logomtm.png') }}" alt="MTM Logo" class="h-16 w-auto object-contain transition-transform duration-500 group-hover:scale-110">
            </a>
            <p class="text-[#374151] dark:text-gray-400 max-w-lg leading-relaxed text-lg">
                Platform digital gotong royong yang menghubungkan masyarakat dengan mitra terpercaya untuk segala jenis bantuan dalam satu klik.
            </p>
            <div class="flex items-center gap-5">
                @php
                    $socials = [
                        ['icon' => 'instagram', 'url' => '#', 'label' => 'Instagram'],
                        ['icon' => 'whatsapp',  'url' => '#', 'label' => 'WhatsApp'],
                        ['icon' => 'tiktok',    'url' => '#', 'label' => 'TikTok'],
                    ];
                @endphp
                @foreach($socials as $social)
                    <a href="{{ $social['url'] }}" aria-label="{{ $social['label'] }}" class="w-14 h-14 rounded-2xl bg-white dark:bg-white/5 flex items-center justify-center text-[#374151] dark:text-gray-400 hover:bg-gradient-to-r hover:from-[#EF4444] hover:to-[#F59E0B] hover:text-white hover:scale-110 transition-all duration-300 shadow-sm border border-[#E5E7EB] dark:border-white/5">
                        <i class="fab fa-{{ $social['icon'] }} text-2xl"></i>
                    </a>
                @endforeach
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
