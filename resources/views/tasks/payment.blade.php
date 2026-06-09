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
                Deal harga sudah disepakati. Lakukan pembayaran di bawah ini agar Mitra dapat segera memulai tugas Anda.
            </p>
        </div>

        <form method="POST" action="{{ route('tasks.pay.process', $task) }}" class="space-y-8" enctype="multipart/form-data" 
            x-data="{ selectedMethod: 'qris', previewUrl: null, errorMessage: '' }"
            @submit="if (selectedMethod === 'qris' && !$refs.proofInput.files.length) { $event.preventDefault(); errorMessage = 'Silakan pilih gambar bukti transfer terlebih dahulu.'; }">
            @csrf

            <!-- Client-Side Validation Error Alert -->
            <div x-show="errorMessage" x-cloak class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 text-sm font-bold text-red-650 dark:text-red-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span x-text="errorMessage"></span>
            </div>

            <!-- Server-Side Validation Error Alert -->
            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 text-sm font-bold text-red-650 dark:text-red-400">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
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
            <div class="glass-card rounded-[2.5rem] p-6 md:p-8 border border-gray-150 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 shadow-xl space-y-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pilih Metode Pembayaran</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <!-- QRIS -->
                    <label class="flex items-center justify-between p-5 rounded-2xl border transition-all cursor-pointer bg-gray-50/50 dark:bg-black/10 hover:border-mtm-red/50"
                        :class="selectedMethod === 'qris' ? 'border-mtm-red shadow-sm' : 'border-gray-250 dark:border-white/5'">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="qris" class="text-mtm-red focus:ring-mtm-red border-gray-300 dark:border-white/10 dark:bg-black/20" x-model="selectedMethod">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">QRIS DANA Bisnis (Otomatis & Mudah)</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-amber-500 tracking-wider">Disarankan</span>
                    </label>

                    <!-- COD -->
                    <label class="flex items-center justify-between p-5 rounded-2xl border transition-all cursor-pointer bg-gray-50/50 dark:bg-black/10 hover:border-mtm-red/50"
                        :class="selectedMethod === 'cod' ? 'border-mtm-red shadow-sm' : 'border-gray-250 dark:border-white/5'">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="cod" class="text-mtm-red focus:ring-mtm-red border-gray-300 dark:border-white/10 dark:bg-black/20" x-model="selectedMethod">
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">COD (Bayar Tunai Langsung ke Mitra)</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-emerald-500 tracking-wider">Bayar di Tempat</span>
                    </label>
                </div>
            </div>

            <!-- Upload Bukti (Only if QRIS) -->
            <div x-show="selectedMethod === 'qris'" x-collapse x-cloak class="glass-card rounded-[2.5rem] p-6 md:p-8 border border-gray-150 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 shadow-xl space-y-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Scan QRIS & Upload Bukti</h3>
                
                <div class="flex flex-col items-center justify-center space-y-4">
                    <!-- QRIS Image Box -->
                    <div class="w-64 h-64 bg-white p-3 rounded-3xl border border-gray-250 dark:border-white/10 flex items-center justify-center overflow-hidden shadow-md">
                        <img src="{{ asset('qris-dana-placeholder.png') }}" alt="QRIS DANA Bisnis" class="w-full h-full object-contain">
                    </div>
                    
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center max-w-sm">
                        Silakan scan kode QR di atas menggunakan aplikasi DANA / M-Banking Anda. Jika sudah, wajib unggah *screenshot* bukti transfer di bawah ini.
                    </p>

                    <!-- Upload Input -->
                    <div class="w-full">
                        <label class="block w-full text-center p-4 border-2 border-dashed border-mtm-red/50 rounded-2xl cursor-pointer hover:bg-mtm-red/5 transition-all">
                            <input type="file" name="proof" x-ref="proofInput" class="hidden" accept="image/*" @change="previewUrl = URL.createObjectURL($event.target.files[0]); errorMessage = '';">
                            
                            <div x-show="!previewUrl" class="space-y-1">
                                <svg class="w-8 h-8 text-mtm-red mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-sm font-bold text-mtm-red block">Pilih Gambar Bukti Transfer</span>
                                <span class="text-xs text-gray-400">JPG, PNG, maksimal 2MB</span>
                            </div>

                            <div x-show="previewUrl" class="space-y-2">
                                <img :src="previewUrl" class="max-h-32 mx-auto rounded-xl shadow-sm">
                                <span class="text-xs font-bold text-mtm-red block underline">Ganti Gambar</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-2xl font-bold shadow-lg hover:shadow-mtm-red/25 transition-all cursor-pointer text-sm">
                Selesaikan Pembayaran
            </button>
        </form>
    </div>
</x-app-layout>
