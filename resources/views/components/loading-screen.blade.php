<div x-data="{ 
        progress: 0, 
        isVisible: !sessionStorage.getItem('mtm_navigating'),
        init() {
            if (!this.isVisible) {
                document.body.style.overflow = 'auto';
                return;
            }

            let interval = setInterval(() => {
                this.progress += 5;
                if (this.progress >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        this.isVisible = false;
                        document.body.style.overflow = 'auto';
                    }, 400);
                }
            }, 30);
            document.body.style.overflow = 'hidden';
        }
     }" 
     x-show="isVisible"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center bg-background text-foreground"
     x-cloak>
    
    <div class="flex flex-col items-center gap-12">
        <!-- MTM Logo Animation -->
        <div class="relative scale-150 md:scale-[2]">
            <div class="w-20 h-20 bg-gradient-premium rounded-3xl flex items-center justify-center shadow-2xl animate-scale-in relative overflow-hidden">
                <!-- Glossy Effect -->
                <div class="absolute inset-0 bg-white/10 skew-x-[-20deg] translate-x-[-100%] animate-[gloss_3s_infinite]"></div>
                <span class="text-white font-black text-4xl relative z-10">M</span>
            </div>
        </div>

        <!-- Brand Name -->
        <div class="text-center animate-fade-up" style="animation-delay: 0.3s">
            <h1 class="text-4xl font-black tracking-tighter mb-2">
                <span class="text-mtm-red">Mas</span> Tulung <span class="text-mtm-brown">Mas</span>
            </h1>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.3em]">
                Bantuan Apa Pun, Kini Dalam Satu Klik
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="w-48 h-1 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden relative">
            <div class="h-full bg-gradient-premium transition-all duration-150 ease-out shadow-lg shadow-mtm-red/20"
                 :style="`width: ${progress}%`"></div>
        </div>
    </div>

    <style>
        @keyframes gloss {
            0% { transform: skewX(-20deg) translateX(-150%); }
            50%, 100% { transform: skewX(-20deg) translateX(150%); }
        }
    </style>
</div>
