<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto animate-fade-in">
        
        <!-- Header -->
        <div class="text-center space-y-3 mb-10">
            <div class="inline-flex p-4 rounded-3xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white font-poppins">Pendaftaran Mitra Kerja</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium max-w-md mx-auto">Ikuti langkah-langkah di bawah ini untuk mendaftarkan keahlian Anda di MTM.</p>
        </div>

        <!-- Wizard Multi-Step Form Wrapper -->
        <div x-data="{ 
            step: {{ $errors->has('bio') ? 3 : ($errors->has('skills') ? 2 : 1) }},
            ktpPreview: null,
            profilePreview: null,
            ktpSelected: false,
            profileSelected: false,
            skillsSelected: {{ count(old('skills', [])) > 0 ? 'true' : 'false' }},
            bioText: '{{ old('bio', '') }}',
            
            checkStep1() {
                // If edits, we might not have files again on validation fail but let's allow moving next if old input present
                return (this.ktpSelected && this.profileSelected) || {{ old('ktp_photo') || old('profile_photo') ? 'true' : 'false' }};
            },
            checkStep2() {
                const checked = document.querySelectorAll('input[name=\'skills[]\']:checked').length;
                return checked > 0;
            },
            checkStep3() {
                return this.bioText.trim().length >= 10;
            }
        }" class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-2xl border border-gray-200 dark:border-white/5 bg-white dark:bg-[#1a1a1a]/40 backdrop-blur-md">

            <!-- Progress/Step Indicators -->
            <div class="relative flex items-center justify-between mb-12">
                <!-- Line background -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 bg-gray-200 dark:bg-white/10 z-0"></div>
                <!-- Dynamic progress line -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-amber-500 transition-all duration-500 z-0"
                     :style="`width: ${ (step - 1) * 50 }%`"></div>

                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300"
                         :class="step >= 1 ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-gray-100 dark:bg-gray-800 text-gray-400'">
                        1
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider transition-colors duration-300"
                          :class="step >= 1 ? 'text-amber-500' : 'text-gray-400'">Berkas Foto</span>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300"
                         :class="step >= 2 ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-gray-100 dark:bg-gray-800 text-gray-400'">
                        2
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider transition-colors duration-300"
                          :class="step >= 2 ? 'text-amber-500' : 'text-gray-400'">Keahlian</span>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-sm transition-all duration-300"
                         :class="step >= 3 ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-gray-100 dark:bg-gray-800 text-gray-400'">
                        3
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider transition-colors duration-300"
                          :class="step >= 3 ? 'text-amber-500' : 'text-gray-400'">Deskripsi Diri</span>
                </div>
            </div>

            <!-- Main Form -->
            <form method="POST" action="{{ route('profile.upgrade') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- STEP 1 CONTENT -->
                <div x-show="step === 1" class="space-y-6 animate-slide-down">
                    <div class="border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Langkah 1: Unggah Foto Berkas</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Unggah foto KTP asli dan foto profil terbaru Anda untuk proses verifikasi admin.</p>
                    </div>

                    <!-- KTP Photo Input -->
                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Foto Kartu Tanda Penduduk (KTP) <span class="text-red-500">*</span></label>
                        <div class="flex flex-col gap-3">
                            <div class="relative group">
                                <input type="file" name="ktp_photo" accept="image/*" 
                                       @change="
                                            const file = $event.target.files[0]; 
                                            if (file) { 
                                                ktpPreview = URL.createObjectURL(file); 
                                                ktpSelected = true; 
                                            }
                                       "
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-amber-500/10 file:text-amber-600 dark:file:text-amber-400 hover:file:bg-amber-500/20 transition-all border border-gray-200 dark:border-white/5 rounded-2xl p-2.5 bg-gray-50/50 dark:bg-black/20" 
                                       {{ !old('ktp_photo') ? 'required' : '' }} />
                            </div>
                            <p class="text-[10px] text-gray-400">Gunakan format gambar JPG atau PNG. Ukuran maksimal 2MB.</p>
                            
                            <!-- KTP Preview Frame -->
                            <div x-show="ktpPreview" class="relative mt-2 rounded-2xl overflow-hidden border border-gray-200 dark:border-white/10 max-w-xs aspect-[1.586/1] bg-black/5" x-cloak>
                                <img :src="ktpPreview" class="w-full h-full object-cover" alt="KTP Preview" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-3">
                                    <span class="text-[10px] font-bold text-white uppercase tracking-wider">Preview KTP Anda</span>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('ktp_photo')" class="mt-1" />
                    </div>

                    <!-- Profile Photo Input -->
                    <div class="space-y-3 pt-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Foto Profil Mitra Kerja <span class="text-red-500">*</span></label>
                        <div class="flex flex-col gap-3">
                            <div class="relative group">
                                <input type="file" name="profile_photo" accept="image/*" 
                                       @change="
                                            const file = $event.target.files[0]; 
                                            if (file) { 
                                                profilePreview = URL.createObjectURL(file); 
                                                profileSelected = true; 
                                            }
                                       "
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-amber-500/10 file:text-amber-600 dark:file:text-amber-400 hover:file:bg-amber-500/20 transition-all border border-gray-200 dark:border-white/5 rounded-2xl p-2.5 bg-gray-50/50 dark:bg-black/20" 
                                       {{ !old('profile_photo') ? 'required' : '' }} />
                            </div>
                            <p class="text-[10px] text-gray-400">Foto wajah formal/semi-formal yang jelas untuk dipajang di profil Mitra Anda.</p>
                            
                            <!-- Profile Photo Preview -->
                            <div x-show="profilePreview" class="relative mt-2 rounded-full overflow-hidden border border-gray-200 dark:border-white/10 w-24 h-24 bg-black/5" x-cloak>
                                <img :src="profilePreview" class="w-full h-full object-cover" alt="Profile Preview" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('profile_photo')" class="mt-1" />
                    </div>
                </div>

                <!-- STEP 2 CONTENT -->
                <div x-show="step === 2" class="space-y-6 animate-slide-down" x-cloak>
                    <div class="border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Langkah 2: Pilih Bidang Keahlian</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Pilih satu atau lebih kategori jasa yang sesuai dengan keterampilan yang Anda miliki.</p>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Pilih Bidang Jasa Keahlian <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($categories as $category)
                                <label class="flex items-center gap-3 p-4 bg-gray-55/30 dark:bg-[#121212]/20 border border-gray-200 dark:border-white/5 rounded-2xl cursor-pointer hover:bg-amber-500/5 dark:hover:bg-amber-500/5 transition-all group">
                                    <input type="checkbox" name="skills[]" value="{{ $category->name }}" 
                                           @change="skillsSelected = document.querySelectorAll('input[name=\'skills[]\']:checked').length > 0"
                                           {{ in_array($category->name, old('skills', [])) ? 'checked' : '' }}
                                           class="rounded text-amber-500 focus:ring-amber-500 border-gray-300 dark:border-white/10" />
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300 group-hover:text-amber-500 transition-colors">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('skills')" class="mt-1" />
                    </div>
                </div>

                <!-- STEP 3 CONTENT -->
                <div x-show="step === 3" class="space-y-6 animate-slide-down" x-cloak>
                    <div class="border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Langkah 3: Deskripsi Profil & Bio</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Jelaskan deskripsi keahlian, rekam jejak, atau kelebihan Anda secara singkat untuk menarik minat konsumen.</p>
                    </div>

                    <div class="space-y-3">
                        <label for="bio" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Deskripsi Diri / Bio Keahlian <span class="text-red-500">*</span></label>
                        <textarea id="bio" name="bio" rows="5" required 
                                  x-model="bioText"
                                  placeholder="Contoh: Saya adalah teknisi listrik bersertifikasi dengan pengalaman lebih dari 5 tahun menangani instalasi rumah, gedung, dan perbaikan AC..." 
                                  class="block w-full bg-gray-50/50 dark:bg-[#121212]/30 border-gray-200 dark:border-white/5 rounded-2xl focus:ring-amber-500 focus:border-amber-500 text-sm p-4 text-gray-700 dark:text-gray-300 font-medium"></textarea>
                        <div class="flex justify-between items-center text-[10px] text-gray-400 font-bold tracking-wider">
                            <span>Minimal 10 karakter</span>
                            <span :class="bioText.trim().length >= 10 ? 'text-green-500' : 'text-red-500'" x-text="`${bioText.trim().length} karakter`"></span>
                        </div>
                        <x-input-error :messages="$errors->get('bio')" class="mt-1" />
                    </div>
                </div>

                <!-- Footer Navigation Buttons inside Wizard -->
                <div class="flex items-center justify-between border-t border-gray-100 dark:border-white/5 pt-6 mt-8">
                    <!-- Cancel or Back Button -->
                    <div>
                        <button type="button" x-show="step > 1" @click="step--" 
                                class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 dark:border-white/10 rounded-full text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-all cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </button>
                        <a href="{{ route('profile.edit') }}" x-show="step === 1" 
                           class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 dark:border-white/10 rounded-full text-xs font-bold text-gray-500 hover:text-red-500 hover:border-red-500/20 transition-all cursor-pointer">
                            Batal
                        </a>
                    </div>

                    <!-- Next or Submit Button -->
                    <div>
                        <!-- Next Button (Step 1) -->
                        <button type="button" x-show="step === 1" @click="if (checkStep1()) { step = 2 } else { alert('Mohon pilih/unggah kedua foto berkas terlebih dahulu!') }"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-full font-bold text-xs hover:shadow-lg hover:shadow-amber-500/25 transition-all cursor-pointer">
                            Lanjut
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>

                        <!-- Next Button (Step 2) -->
                        <button type="button" x-show="step === 2" @click="if (checkStep2()) { step = 3 } else { alert('Mohon pilih minimal satu bidang keahlian Anda!') }"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-full font-bold text-xs hover:shadow-lg hover:shadow-amber-500/25 transition-all cursor-pointer" x-cloak>
                            Lanjut
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>

                        <!-- Submit Button (Step 3) -->
                        <button type="submit" x-show="step === 3" :disabled="!checkStep3()"
                                class="inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-full font-bold text-xs hover:shadow-lg hover:shadow-amber-500/25 transition-all cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed" x-cloak>
                            Kirim Pendaftaran
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
