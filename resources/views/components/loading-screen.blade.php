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
        
        <!-- Animated Pattern -->
        <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.02]">
            <div class="absolute inset-0 plus-pattern animate-[spin_120s_linear_infinite]"></div>
        </div>

        <!-- Floating Particles/Icons -->
        <div class="absolute inset-0">
            @php
                $icons = [
                    ['path' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8', 'pos' => 'top: 15%; left: 10%', 'delay' => '0s', 'size' => 'w-8 h-8'],
                    ['path' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'pos' => 'top: 25%; right: 15%', 'delay' => '1.5s', 'size' => 'w-10 h-10'],
                    ['path' => 'M13 10V3L4 14h7v7l9-11h-7z', 'pos' => 'bottom: 20%; left: 20%', 'delay' => '3s', 'size' => 'w-6 h-6'],
                    ['path' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z', 'pos' => 'bottom: 15%; right: 10%', 'delay' => '2s', 'size' => 'w-8 h-8'],
                ];
            @endphp
            @foreach($icons as $icon)
                <div class="absolute animate-float opacity-10 dark:opacity-5" style="{{ $icon['pos'] }}; animation-delay: {{ $icon['delay'] }}">
                    <svg class="{{ $icon['size'] }} text-mtm-red" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
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
            
            <div class="relative bg-white dark:bg-white/5 p-8 rounded-[2.5rem] shadow-2xl border border-white/10 backdrop-blur-sm animate-scale-in">
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
