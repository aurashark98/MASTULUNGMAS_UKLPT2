<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.task-assignments.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Tambah Penugasan Baru</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tugaskan mitra ke tugas tertentu secara manual.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.task-assignments.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Task ID -->
                <div class="space-y-2">
                    <x-input-label for="task_id" :value="__('Pilih Tugas *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="task_id" name="task_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Tugas (Hanya yang belum ditugaskan) --</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                                #{{ $task->id }} - {{ $task->title }} (Anggaran: Rp {{ number_format($task->budget, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('task_id')" class="mt-1" />
                </div>

                <!-- Mitra ID -->
                <div class="space-y-2">
                    <x-input-label for="mitra_id" :value="__('Pilih Mitra Penerima Tugas *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="mitra_id" name="mitra_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="">-- Pilih Mitra --</option>
                        @foreach($mitras as $mitra)
                            <option value="{{ $mitra->id }}" {{ old('mitra_id') == $mitra->id ? 'selected' : '' }}>
                                {{ $mitra->name }} ({{ $mitra->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('mitra_id')" class="mt-1" />
                </div>

                <!-- Assigned At -->
                <div class="space-y-2">
                    <x-input-label for="assigned_at" :value="__('Tanggal Ditugaskan')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="assigned_at" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="datetime-local" name="assigned_at" :value="old('assigned_at')" />
                    <p class="text-[10px] text-gray-400">Kosongkan jika ingin menggunakan waktu saat ini.</p>
                    <x-input-error :messages="$errors->get('assigned_at')" class="mt-1" />
                </div>

                <!-- Completed At -->
                <div class="space-y-2">
                    <x-input-label for="completed_at" :value="__('Tanggal Selesai (Jika sudah selesai)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="completed_at" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="datetime-local" name="completed_at" :value="old('completed_at')" />
                    <x-input-error :messages="$errors->get('completed_at')" class="mt-1" />
                </div>

                <!-- Evidence Photo -->
                <div class="space-y-2">
                    <x-input-label for="evidence_photo" :value="__('Bukti Pekerjaan Selesai (Foto)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <input id="evidence_photo" name="evidence_photo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-mtm-red/10 file:text-mtm-red hover:file:bg-mtm-red/20 file:cursor-pointer" />
                    <x-input-error :messages="$errors->get('evidence_photo')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Simpan Penugasan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
