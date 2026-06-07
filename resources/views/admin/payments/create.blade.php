<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Tambah Transaksi Baru</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Catat transaksi pembayaran baru secara manual.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.payments.store') }}" class="space-y-6">
                @csrf

                <!-- Task ID -->
                <div class="space-y-2">
                    <x-input-label for="task_id" :value="__('Pilih Tugas *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="task_id" name="task_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Tugas --</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                                #{{ $task->id }} - {{ $task->title }} (Anggaran: Rp {{ number_format($task->budget, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('task_id')" class="mt-1" />
                </div>

                <!-- User ID -->
                <div class="space-y-2">
                    <x-input-label for="user_id" :value="__('Klien Pembayar *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="user_id" name="user_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Klien --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                </div>

                <!-- Amount -->
                <div class="space-y-2">
                    <x-input-label for="amount" :value="__('Nominal Pembayaran (Rp) *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="amount" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="number" name="amount" :value="old('amount')" required placeholder="Masukkan jumlah nominal transaksi" />
                    <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                </div>

                <!-- Payment Method -->
                <div class="space-y-2">
                    <x-input-label for="payment_method" :value="__('Metode Pembayaran *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="payment_method" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="payment_method" :value="old('payment_method', 'Transfer Bank')" required placeholder="Contoh: Transfer Bank, E-Wallet, Qris" />
                    <x-input-error :messages="$errors->get('payment_method')" class="mt-1" />
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <x-input-label for="status" :value="__('Status Pembayaran *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="status" name="status" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed (Sukses)</option>
                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed (Gagal)</option>
                        <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Refunded (Dikembalikan)</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-1" />
                </div>

                <!-- Transaction ID -->
                <div class="space-y-2">
                    <x-input-label for="transaction_id" :value="__('ID Transaksi (Kosongkan untuk auto-generate)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="transaction_id" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" name="transaction_id" :value="old('transaction_id')" placeholder="Contoh: MTM-123456789" />
                    <x-input-error :messages="$errors->get('transaction_id')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Simpan Transaksi') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
