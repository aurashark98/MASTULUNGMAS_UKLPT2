<div x-data="{ 
        progress: 0, 
        isVisible: !sessionStorage.getItem('mtm_navigating'),
        init() {
            if (!this.isVisible) {
                document.body.style.overflow = 'auto';
                return;
            }

            let interval = setInterval(() => {
                this.progress += 2;
                if (this.progress >= 100) {
                    this.progress = 100;
                    clearInterval(interval);
                    setTimeout(() => {
                        this.isVisible = false;
                        document.body.style.overflow = 'auto';
                    }, 600);
                }
            }, 30);
            document.body.style.overflow = 'hidden';
        }
     }" 
     x-show="isVisible"
     x-transition:leave="transition ease-in duration-700"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-110"
     class="fixed inset-0 z-[100] flex items-center justify-center bg-background text-foreground overflow-hidden"
     x-cloak>
    
    <!-- Premium Animated Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Radial Glows -->
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-mtm-red/10 blur-[120px] animate-pulse"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-mtm-brown/10 blur-[120px] animate-pulse" style="animation-delay: 1s"></div>
        
        <!-- Sidoarjo Batik Signature Pattern Background -->
        <svg class="absolute inset-0 w-full h-full text-mtm-brown/40 dark:text-amber-500/25 opacity-40 pointer-events-none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="batik-sidoarjo" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                    <!-- Traditional Sidoarjo Batik Motif: Udang (Shrimp) & Bandeng (Milkfish) -->
                    <!-- Udang (Shrimp) -->
                    <path d="M25,12 C18,14 15,22 18,28 C20,32 28,30 32,25 C36,21 42,32 45,35 C48,38 52,32 50,28 C47,23 38,19 32,15 Z" fill="none" stroke="currentColor" stroke-width="1.2" />
                    <path d="M18,28 C12,30 10,25 15,21 M18,28 C15,33 10,35 13,29" fill="none" stroke="currentColor" stroke-width="0.8" />
                    <!-- Bandeng (Milkfish) -->
                    <path d="M75,38 C62,35 56,44 60,53 C63,58 71,57 75,50 C80,44 86,57 91,61 C95,64 99,57 95,53 C91,48 86,40 75,38 Z" fill="none" stroke="currentColor" stroke-width="1.2" />
                    <path d="M91,61 L96,66 M91,61 L99,60 M60,53 C56,57 52,53 56,49" fill="none" stroke="currentColor" stroke-width="0.8" />
                    <!-- Traditional Batik Flowers / Accents -->
                    <path d="M12,62 C18,60 22,65 25,68 C22,72 15,75 12,62 Z" fill="none" stroke="currentColor" stroke-width="0.6" />
                    <path d="M62,18 C68,14 72,21 75,24 C72,28 65,30 62,18 Z" fill="none" stroke="currentColor" stroke-width="0.6" />
                    <!-- Diagonal wavy background lines (Batik Parang style) -->
                    <path d="M0,100 L100,0 M15,115 L115,15 M-15,85 L85,-15" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="3,3" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#batik-sidoarjo)" />
        </svg>

        <!-- Floating Particles/Icons -->
        <div class="absolute inset-0">
            @php
                $icons = [
                    // Motor (Motorcycle)
                    ['path' => 'M5 18c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm14 0c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3 M12 18v-8h4l2 4h1.5 M5 18l3.5-8h7l3.5 8 M16 10l-2-4h-3', 'pos' => 'top: 15%; left: 10%', 'delay' => '0s', 'size' => 'w-10 h-10'],
                    // Helm (Helmet)
                    ['path' => 'M12 4a8 8 0 0 0-8 8c0 1.25.3 2.45.8 3.5a2 2 0 0 0 1.7 1.1h11a2 2 0 0 0 1.7-1.1c.5-1.05.8-2.25.8-3.5a8 8 0 0 0-8-8z M5 12h14 M7 12a5 5 0 0 0 10 0', 'pos' => 'top: 25%; right: 15%', 'delay' => '1.5s', 'size' => 'w-10 h-10'],
                    // Petir (SOS/Quick Help)
                    ['path' => 'M13 10V3L4 14h7v7l9-11h-7z', 'pos' => 'bottom: 20%; left: 20%', 'delay' => '3s', 'size' => 'w-8 h-8'],
                    // Kunci Inggris (Wrench / Repair)
                    ['path' => 'M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z', 'pos' => 'bottom: 15%; right: 10%', 'delay' => '2s', 'size' => 'w-8 h-8'],
                ];
            @endphp
            @foreach($icons as $icon)
                <div class="absolute animate-float opacity-50 dark:opacity-40" style="{{ $icon['pos'] }}; animation-delay: {{ $icon['delay'] }}">
                    <svg class="{{ $icon['size'] }} text-mtm-red dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon['path'] }}"></path>
                    </svg>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col items-center gap-12 relative z-10">
        <!-- Logo Container with Animated Rings -->
        <div class="relative">
            <!-- Rotating Rings -->
            <div class="absolute inset-[-20px] border border-dashed border-mtm-red/20 rounded-full animate-[spin_10s_linear_infinite]"></div>
            <div class="absolute inset-[-35px] border border-dashed border-mtm-brown/10 rounded-full animate-[spin_15s_linear_infinite_reverse]"></div>
            
            <div class="relative bg-white dark:bg-white/5 p-8 rounded-[2.5rem] shadow-2xl border border-white/10 backdrop-blur-sm animate-scale-in overflow-hidden">
                <img src="{{ asset('images/logomtm.png') }}" alt="MTM Logo" class="w-20 h-auto object-contain relative z-10">
                <!-- Glossy Overlay Effect -->
                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent skew-x-[-20deg] translate-x-[-200%] animate-[gloss_3s_infinite] pointer-events-none"></div>
            </div>
        </div>

        <!-- Brand Name -->
        <div class="text-center space-y-4">
            <div class="animate-fade-up" style="animation-delay: 0.4s">
                <h1 class="text-5xl font-black tracking-tighter flex items-center justify-center gap-2">
                    <span class="text-mtm-red drop-shadow-sm">Mas</span>
                    <span class="text-foreground">Tulung</span>
                    <span class="text-mtm-brown drop-shadow-sm">Mas</span>
                </h1>
            </div>
            <div class="animate-fade-up" style="animation-delay: 0.6s">
                <p class="text-[10px] font-black text-mtm-brown/60 dark:text-mtm-brown-light/40 uppercase tracking-[0.5em]">
                    Bantuan Apa Pun, Kini Dalam Satu Klik
                </p>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="w-64 space-y-3 animate-fade-up" style="animation-delay: 0.8s">
            <div class="h-1.5 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden relative shadow-inner">
                <div class="h-full bg-gradient-premium transition-all duration-300 ease-out relative"
                     :style="`width: ${progress}%`">
                    <!-- Progress Shine -->
                    <div class="absolute top-0 right-0 bottom-0 w-12 bg-white/30 blur-md"></div>
                </div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest animate-pulse">Sistem Sedang Memuat</span>
                <span class="text-[10px] font-black text-mtm-red tabular-nums" x-text="`${Math.round(progress)}%`"></span>
            </div>
        </div>
    </div>

    <style>
        @keyframes gloss {
            0% { transform: skewX(-20deg) translateX(-150%); }
            100% { transform: skewX(-20deg) translateX(150%); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        .animate-scale-in {
            animation: scaleIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes scaleIn {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-fade-up {
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes fadeUp {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
    </style>
</div>
