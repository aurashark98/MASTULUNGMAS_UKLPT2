<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.reviews.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Edit Ulasan #{{ $review->id }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui rating, komentar, atau klien/mitra terkait ulasan ini.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Task ID -->
                <div class="space-y-2">
                    <x-input-label for="task_id" :value="__('Pilih Tugas *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="task_id" name="task_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" {{ old('task_id', $review->task_id) == $task->id ? 'selected' : '' }}>
                                #{{ $task->id }} - {{ $task->title }} (Klien: {{ $task->user->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('task_id')" class="mt-1" />
                </div>

                <!-- User ID -->
                <div class="space-y-2">
                    <x-input-label for="user_id" :value="__('Klien Penulis Ulasan *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="user_id" name="user_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $review->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                </div>

                <!-- Mitra ID -->
                <div class="space-y-2">
                    <x-input-label for="mitra_id" :value="__('Mitra Penerima Ulasan *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="mitra_id" name="mitra_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        @foreach($mitras as $mitra)
                            <option value="{{ $mitra->id }}" {{ old('mitra_id', $review->mitra_id) == $mitra->id ? 'selected' : '' }}>
                                {{ $mitra->name }} ({{ $mitra->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('mitra_id')" class="mt-1" />
                </div>

                <!-- Rating -->
                <div class="space-y-2">
                    <x-input-label for="rating" :value="__('Rating * (1 - 5)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="rating" name="rating" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="5" {{ old('rating', $review->rating) == '5' ? 'selected' : '' }}>5 - Sangat Puas</option>
                        <option value="4" {{ old('rating', $review->rating) == '4' ? 'selected' : '' }}>4 - Puas</option>
                        <option value="3" {{ old('rating', $review->rating) == '3' ? 'selected' : '' }}>3 - Cukup</option>
                        <option value="2" {{ old('rating', $review->rating) == '2' ? 'selected' : '' }}>2 - Kurang Puas</option>
                        <option value="1" {{ old('rating', $review->rating) == '1' ? 'selected' : '' }}>1 - Kecewa</option>
                    </select>
                    <x-input-error :messages="$errors->get('rating')" class="mt-1" />
                </div>

                <!-- Comment -->
                <div class="space-y-2">
                    <x-input-label for="comment" :value="__('Komentar / Ulasan')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <textarea id="comment" name="comment" rows="4" placeholder="Tuliskan ulasan detail mengenai kinerja mitra..." class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">{{ old('comment', $review->comment) }}</textarea>
                    <x-input-error :messages="$errors->get('comment')" class="mt-1" />
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
