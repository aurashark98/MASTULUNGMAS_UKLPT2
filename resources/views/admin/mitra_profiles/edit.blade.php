<x-admin-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.mitra-profiles.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Edit Profil Mitra: {{ $mitraProfile->user->name ?? 'User Terhapus' }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui keahlian, status verifikasi, dokumen, dan statistik mitra.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <form method="POST" action="{{ route('admin.mitra-profiles.update', $mitraProfile) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- User ID -->
                <div class="space-y-2">
                    <x-input-label for="user_id" :value="__('Pilih Pengguna *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="user_id" name="user_id" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $mitraProfile->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                </div>

                <!-- KTP Photo -->
                <div class="space-y-2">
                    <x-input-label for="ktp_photo" :value="__('Foto KTP (Kosongkan jika tidak diubah)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    @if($mitraProfile->ktp_path)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $mitraProfile->ktp_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-100 dark:bg-white/5 text-xs font-bold text-gray-700 dark:text-gray-300 hover:text-mtm-red transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat KTP Saat Ini
                            </a>
                        </div>
                    @endif
                    <input id="ktp_photo" name="ktp_photo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-mtm-red/10 file:text-mtm-red hover:file:bg-mtm-red/20 file:cursor-pointer" />
                    <x-input-error :messages="$errors->get('ktp_photo')" class="mt-1" />
                </div>

                <!-- Profile Photo -->
                <div class="space-y-2">
                    <x-input-label for="profile_photo" :value="__('Foto Profil (Kosongkan jika tidak diubah)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    @if($mitraProfile->profile_photo_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $mitraProfile->profile_photo_path) }}" alt="Foto Profile" class="w-20 h-20 rounded-full object-cover border border-gray-200 dark:border-white/10 shadow-sm" />
                        </div>
                    @endif
                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-mtm-red/10 file:text-mtm-red hover:file:bg-mtm-red/20 file:cursor-pointer" />
                    <x-input-error :messages="$errors->get('profile_photo')" class="mt-1" />
                </div>

                <!-- Skills (Chips input) -->
                <div class="space-y-2">
                    <x-input-label :value="__('Keahlian / Skills * (Tekan Enter atau tombol tambah)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    
                    <div class="flex gap-2">
                        <x-text-input id="skill_input" class="block flex-1 !py-3 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="text" placeholder="Contoh: Listrik, Pipa, Cat" />
                        <button type="button" id="add_skill_btn" class="px-5 py-3 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-white font-bold text-sm rounded-2xl hover:bg-gray-200 dark:hover:bg-white/10 active:scale-95 transition-all">Tambah</button>
                    </div>

                    <!-- Chips Container -->
                    <div id="skills_container" class="flex flex-wrap gap-2 pt-2">
                        @php
                            $skills = old('skills', is_array($mitraProfile->skills) ? $mitraProfile->skills : []);
                        @endphp
                        @foreach($skills as $skill)
                            <div class="skill-chip inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-mtm-red/10 text-mtm-red">
                                <span>{{ $skill }}</span>
                                <button type="button" class="remove-chip-btn focus:outline-none text-red-500 hover:text-red-700">&times;</button>
                                <input type="hidden" name="skills[]" value="{{ $skill }}">
                            </div>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('skills')" class="mt-1" />
                </div>

                <!-- Bio -->
                <div class="space-y-2">
                    <x-input-label for="bio" :value="__('Biografi / Bio * (Min. 10 Karakter)')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <textarea id="bio" name="bio" rows="4" required placeholder="Tuliskan biografi singkat mengenai keahlian dan pengalaman kerja..." class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">{{ old('bio', $mitraProfile->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-1" />
                </div>

                <!-- Rating -->
                <div class="space-y-2">
                    <x-input-label for="rating" :value="__('Rating *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="rating" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="number" step="0.1" min="0" max="5" name="rating" :value="old('rating', $mitraProfile->rating)" required />
                    <x-input-error :messages="$errors->get('rating')" class="mt-1" />
                </div>

                <!-- Earnings -->
                <div class="space-y-2">
                    <x-input-label for="earnings" :value="__('Pendapatan (Rp) *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <x-text-input id="earnings" class="block w-full !py-3.5 bg-gray-50/50 dark:bg-[#121212]/30 border-gray-100 dark:border-white/5 rounded-2xl" type="number" name="earnings" :value="old('earnings', intval($mitraProfile->earnings))" required />
                    <x-input-error :messages="$errors->get('earnings')" class="mt-1" />
                </div>

                <!-- Verification Status -->
                <div class="space-y-2">
                    <x-input-label for="is_verified" :value="__('Status Verifikasi *')" class="text-xs font-bold uppercase tracking-widest text-gray-500" />
                    <select id="is_verified" name="is_verified" required class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-mtm-red focus:border-mtm-red text-sm p-4 text-gray-700 dark:text-gray-300">
                        <option value="0" {{ old('is_verified', $mitraProfile->is_verified ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Terverifikasi</option>
                        <option value="1" {{ old('is_verified', $mitraProfile->is_verified ? '1' : '0') == '1' ? 'selected' : '' }}>Terverifikasi</option>
                    </select>
                    <x-input-error :messages="$errors->get('is_verified')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <x-primary-button class="bg-gradient-to-r from-red-500 to-amber-500 hover:shadow-red-500/25 px-8 py-3.5 !text-sm">
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts for dynamic chips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const skillInput = document.getElementById('skill_input');
            const addSkillBtn = document.getElementById('add_skill_btn');
            const skillsContainer = document.getElementById('skills_container');

            function addSkill(value) {
                const trimmed = value.trim();
                if (!trimmed) return;

                // Check if already added
                const existingInputs = skillsContainer.querySelectorAll('input[type="hidden"]');
                for (let input of existingInputs) {
                    if (input.value.toLowerCase() === trimmed.toLowerCase()) {
                        skillInput.value = '';
                        return;
                    }
                }

                // Create Chip Element
                const chip = document.createElement('div');
                chip.className = 'skill-chip inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-mtm-red/10 text-mtm-red animate-fade-in';
                chip.innerHTML = `
                    <span>${trimmed}</span>
                    <button type="button" class="remove-chip-btn focus:outline-none text-red-500 hover:text-red-700">&times;</button>
                    <input type="hidden" name="skills[]" value="${trimmed}">
                `;

                // Add remove listener
                chip.querySelector('.remove-chip-btn').addEventListener('click', function() {
                    chip.remove();
                });

                skillsContainer.appendChild(chip);
                skillInput.value = '';
            }

            // Handle Add Button Click
            addSkillBtn.addEventListener('click', function() {
                addSkill(skillInput.value);
            });

            // Handle Enter Key inside Skill Input
            skillInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addSkill(skillInput.value);
                }
            });

            // Re-bind click event to existing chips
            skillsContainer.querySelectorAll('.remove-chip-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.closest('.skill-chip').remove();
                });
            });
        });
    </script>
</x-admin-layout>
