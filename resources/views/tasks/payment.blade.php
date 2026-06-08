<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.3] pointer-events-none z-0"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 max-w-2xl pt-8 pb-16">
        <!-- Header -->
        <div class="mb-8 text-center md:text-left">
            <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Detail Tugas
            </a>
            <h1 class="text-3xl font-black heading-gradient mb-2">
                {{ __('Pembayaran Tugas') }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                Pilih metode pembayaran simulasi di bawah ini untuk mengirim dana hasil kesepakatan ke Mitra.
            </p>
        </div>

        <form method="POST" action="{{ route('tasks.pay.process', $task) }}" class="space-y-8">
            @csrf
            
            <!-- Summary Card -->
            <div class="glass-card rounded-[2.5rem] p-6 md:p-8 border border-gray-150 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 shadow-xl space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Rincian Pembayaran</h3>
                
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-white/5">
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $task->title }}</h4>
                        <p class="text-xs text-gray-500 mt-1">Kategori: {{ $task->category->name }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-sm font-bold text-gray-600 dark:text-gray-400">Total Pembayaran</span>
                    <span class="text-2xl font-black text-mtm-red">Rp {{ number_format($task->budget, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="glass-card rounded-[2.5rem] p-6 md:p-8 border border-gray-150 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 shadow-xl space-y-6" x-data="{ selectedMethod: 'qris' }">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pilih Metode Pembayaran</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <!-- QRIS -->
                    <label class="flex items-center justify-between p-5 rounded-2xl border transition-all cursor-pointer bg-gray-50/50 dark:bg-black/10 hover:border-mtm-red/50"
                        :class="selectedMethod === 'qris' ? 'border-mtm-red shadow-sm' : 'border-gray-250 dark:border-white/5'">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="qris" class="text-mtm-red focus:ring-mtm-red border-gray-300 dark:border-white/10 dark:bg-black/20" x-model="selectedMethod" checked>
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">QRIS (Otomatis & Mudah)</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-amber-500 tracking-wider">Simulasi QR</span>
                    </label>

                    <!-- DANA -->
                    <label class="flex items-center justify-between p-5 rounded-2xl border transition-all cursor-pointer bg-gray-50/50 dark:bg-black/10 hover:border-mtm-red/50"
                        :class="selectedMethod === 'dana' ? 'border-mtm-red shadow-sm' : 'border-gray-250 dark:border-white/5'">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="dana" class="text-mtm-red focus:ring-mtm-red border-gray-300 dark:border-white/10 dark:bg-black/20" x-model="selectedMethod">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">DANA</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-blue-500 tracking-wider">Dompet Digital</span>
                    </label>

                    <!-- OVO -->
                    <label class="flex items-center justify-between p-5 rounded-2xl border transition-all cursor-pointer bg-gray-50/50 dark:bg-black/10 hover:border-mtm-red/50"
                        :class="selectedMethod === 'ovo' ? 'border-mtm-red shadow-sm' : 'border-gray-250 dark:border-white/5'">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="ovo" class="text-mtm-red focus:ring-mtm-red border-gray-300 dark:border-white/10 dark:bg-black/20" x-model="selectedMethod">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">OVO</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-purple-500 tracking-wider">Dompet Digital</span>
                    </label>

                    <!-- GoPay -->
                    <label class="flex items-center justify-between p-5 rounded-2xl border transition-all cursor-pointer bg-gray-50/50 dark:bg-black/10 hover:border-mtm-red/50"
                        :class="selectedMethod === 'gopay' ? 'border-mtm-red shadow-sm' : 'border-gray-250 dark:border-white/5'">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="gopay" class="text-mtm-red focus:ring-mtm-red border-gray-300 dark:border-white/10 dark:bg-black/20" x-model="selectedMethod">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">GoPay</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-green-500 tracking-wider">Dompet Digital</span>
                    </label>

                    <!-- Bank Transfer -->
                    <label class="flex items-center justify-between p-5 rounded-2xl border transition-all cursor-pointer bg-gray-50/50 dark:bg-black/10 hover:border-mtm-red/50"
                        :class="selectedMethod === 'bank_transfer' ? 'border-mtm-red shadow-sm' : 'border-gray-250 dark:border-white/5'">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="bank_transfer" class="text-mtm-red focus:ring-mtm-red border-gray-300 dark:border-white/10 dark:bg-black/20" x-model="selectedMethod">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Bank Transfer</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-red-500 tracking-wider">Virtual Account</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-2xl font-bold shadow-lg hover:shadow-mtm-red/25 transition-all cursor-pointer text-sm">
                Proses Pembayaran Simulasi
            </button>
        </form>
    </div>
</x-app-layout>
