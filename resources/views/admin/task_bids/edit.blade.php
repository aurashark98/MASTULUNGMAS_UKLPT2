<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.task-bids.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Edit Penawaran #{{ $taskBid->id }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui nominal penawaran, pesan, atau status penawaran mitra.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.task-bids.update', $taskBid) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Task ID -->
                <div class="space-y-2">
                    <x-input-label for="task_id" :value="__('Pilih Tugas *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="task_id" name="task_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" {{ old('task_id', $taskBid->task_id) == $task->id ? 'selected' : '' }}>
                                #{{ $task->id }} - {{ $task->title }} (Anggaran: Rp {{ number_format($task->budget, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('task_id')" class="mt-1" />
                </div>

                <!-- Mitra ID -->
                <div class="space-y-2">
                    <x-input-label for="mitra_id" :value="__('Pilih Mitra *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="mitra_id" name="mitra_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        @foreach($mitras as $mitra)
                            <option value="{{ $mitra->id }}" {{ old('mitra_id', $taskBid->mitra_id) == $mitra->id ? 'selected' : '' }}>
                                {{ $mitra->name }} ({{ $mitra->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('mitra_id')" class="mt-1" />
                </div>

                <!-- Bid Amount -->
                <div class="space-y-2">
                    <x-input-label for="bid_amount" :value="__('Jumlah Penawaran (Rp) *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="bid_amount" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="number" name="bid_amount" :value="old('bid_amount', intval($taskBid->bid_amount))" required placeholder="Masukkan nominal penawaran" />
                    <x-input-error :messages="$errors->get('bid_amount')" class="mt-1" />
                </div>

                <!-- Message -->
                <div class="space-y-2">
                    <x-input-label for="message" :value="__('Pesan Penawaran')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <textarea id="message" name="message" rows="3" placeholder="Pesan atau alasan mengapa mitra cocok untuk pekerjaan ini..." class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">{{ old('message', $taskBid->message) }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-1" />
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <x-input-label for="status" :value="__('Status Penawaran *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="status" name="status" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="pending" {{ old('status', $taskBid->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ old('status', $taskBid->status) == 'accepted' ? 'selected' : '' }}>Accepted (Diterima)</option>
                        <option value="rejected" {{ old('status', $taskBid->status) == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
