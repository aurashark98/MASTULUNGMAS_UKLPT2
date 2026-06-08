<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
                {{ __('Portfolio Saya') }}
            </h2>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-portfolio')" class="px-6 py-3 bg-mtm-red text-white rounded-2xl font-black text-sm shadow-lg hover:bg-mtm-red-dark transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Portfolio
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Total Portfolio</p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ Auth::user()->portfolios->count() }}</h3>
                </div>
            </div>

            @if($portfolios->isEmpty())
                <div class="bg-white dark:bg-mtm-dark-surface p-12 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm text-center">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-900 dark:text-white mb-2 font-poppins">Belum ada portfolio</h4>
                    <p class="text-gray-500 max-w-md mx-auto mb-8">Tunjukkan hasil kerja terbaik Anda untuk meningkatkan kepercayaan calon pelanggan.</p>
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-portfolio')" class="px-8 py-4 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-300 rounded-2xl font-black hover:bg-gray-200 dark:hover:bg-white/10 transition-all">
                        Mulai Tambah Portfolio
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($portfolios as $portfolio)
                        <div class="bg-white dark:bg-mtm-dark-surface rounded-[2rem] overflow-hidden border border-gray-100 dark:border-white/5 shadow-sm group hover:shadow-xl transition-all duration-500">
                            <!-- Image Container -->
                            <div class="relative h-56 overflow-hidden">
                                @if($portfolio->image_path)
                                    <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
                                @else
                                    <div class="w-full h-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all flex items-end p-6">
                                    <span class="text-white text-xs font-black uppercase tracking-widest">Selesai: {{ $portfolio->completed_date->format('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="p-8">
                                <h4 class="text-lg font-black text-gray-900 dark:text-white mb-3 font-poppins leading-tight">{{ $portfolio->title }}</h4>
                                <p class="text-gray-500 text-sm line-clamp-3 mb-6 leading-relaxed">{{ $portfolio->description }}</p>
                                
                                <div class="flex items-center gap-3">
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-portfolio-{{ $portfolio->id }}')" class="flex-1 py-3 bg-gray-50 dark:bg-white/5 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-white/10 transition-all">
                                        Edit
                                    </button>
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'delete-portfolio-{{ $portfolio->id }}')" class="px-4 py-3 bg-red-50 dark:bg-red-500/10 text-red-600 rounded-xl hover:bg-red-100 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <x-modal name="edit-portfolio-{{ $portfolio->id }}" focusable>
                            <form method="post" action="{{ route('mitra.portfolios.update', $portfolio) }}" class="p-8" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6 font-poppins">Edit Portfolio</h2>
                                
                                <div class="space-y-6">
                                    <div>
                                        <x-input-label for="title" value="Judul Proyek" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                                        <x-text-input id="title" name="title" type="text" class="w-full" :value="$portfolio->title" required />
                                    </div>
                                    <div>
                                        <x-input-label for="description" value="Deskripsi Pekerjaan" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                                        <textarea id="description" name="description" rows="4" class="w-full border-gray-100 dark:border-white/5 dark:bg-[#121212] focus:border-mtm-red focus:ring-mtm-red rounded-2xl shadow-sm text-sm" required>{{ $portfolio->description }}</textarea>
                                    </div>
                                    <div>
                                        <x-input-label for="completed_date" value="Tanggal Selesai" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                                        <x-text-input id="completed_date" name="completed_date" type="date" class="w-full" :value="$portfolio->completed_date->format('Y-m-d')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="image" value="Ganti Foto (Opsional)" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                                        <input type="file" id="image" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-mtm-red hover:file:bg-red-100" />
                                    </div>
                                </div>

                                <div class="mt-8 flex justify-end gap-3">
                                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                    <x-danger-button class="bg-mtm-red hover:bg-mtm-red-dark">Simpan Perubahan</x-danger-button>
                                </div>
                            </form>
                        </x-modal>

                        <!-- Delete Modal -->
                        <x-modal name="delete-portfolio-{{ $portfolio->id }}" focusable>
                            <form method="post" action="{{ route('mitra.portfolios.destroy', $portfolio) }}" class="p-8">
                                @csrf
                                @method('delete')
                                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-4 font-poppins">Hapus Portfolio?</h2>
                                <p class="text-gray-500 mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus portfolio <span class="font-bold text-gray-900 dark:text-white">"{{ $portfolio->title }}"</span>? Tindakan ini tidak dapat dibatalkan.</p>
                                <div class="flex justify-end gap-3">
                                    <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                    <x-danger-button>Ya, Hapus Portfolio</x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Modal -->
    <x-modal name="add-portfolio" focusable>
        <form method="post" action="{{ route('mitra.portfolios.store') }}" class="p-8" enctype="multipart/form-data">
            @csrf
            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6 font-poppins">Tambah Portfolio Baru</h2>
            
            <div class="space-y-6">
                <div>
                    <x-input-label for="title" value="Judul Proyek" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                    <x-text-input id="title" name="title" type="text" class="w-full" placeholder="Contoh: Perbaikan Instalasi Listrik Ruko" required />
                </div>
                <div>
                    <x-input-label for="description" value="Deskripsi Pekerjaan" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                    <textarea id="description" name="description" rows="4" class="w-full border-gray-100 dark:border-white/5 dark:bg-[#121212] focus:border-mtm-red focus:ring-mtm-red rounded-2xl shadow-sm text-sm" placeholder="Jelaskan apa yang Anda kerjakan..." required></textarea>
                </div>
                <div>
                    <x-input-label for="completed_date" value="Tanggal Selesai" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                    <x-text-input id="completed_date" name="completed_date" type="date" class="w-full" required />
                </div>
                <div>
                    <x-input-label for="image" value="Foto Hasil Kerja (Opsional)" class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2" />
                    <input type="file" id="image" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-mtm-red hover:file:bg-red-100" />
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button class="bg-mtm-red hover:bg-mtm-red-dark">Tambah Portfolio</x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
