<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
            {{ __('Mitra Favorit Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($partners->isEmpty())
                <div class="bg-white dark:bg-mtm-dark-surface p-12 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm text-center">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-mtm-red/20">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-900 dark:text-white mb-2 font-poppins">Belum ada mitra favorit</h4>
                    <p class="text-gray-500 max-w-md mx-auto mb-8">Simpan mitra yang pernah bekerja sama dengan Anda atau yang memiliki reputasi baik di sini.</p>
                    <a href="{{ route('partners.index') }}" class="inline-flex items-center px-8 py-4 bg-mtm-red text-white rounded-2xl font-black text-sm shadow-lg hover:shadow-mtm-red/20 transition-all">
                        Cari Mitra Sekarang
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($partners as $partner)
                        <div class="bg-white dark:bg-mtm-dark-surface rounded-[2.5rem] p-8 border border-gray-100 dark:border-white/5 shadow-sm group hover:shadow-xl transition-all duration-500 relative overflow-hidden">
                            <!-- Remove Favorite -->
                            <form action="{{ route('partners.favorite', $partner) }}" method="POST" class="absolute top-6 right-6 z-10">
                                @csrf
                                <button type="submit" class="p-3 rounded-2xl bg-red-50 dark:bg-red-500/10 text-mtm-red transition-all">
                                    <svg class="w-5 h-5 fill-current" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </button>
                            </form>

                            <div class="flex items-center gap-6 mb-8">
                                <div class="w-20 h-20 rounded-[1.8rem] overflow-hidden border-4 border-gray-50 dark:border-white/5 shadow-lg group-hover:scale-105 transition-all duration-500">
                                    <img src="{{ $partner->profile_photo_url }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="text-lg font-black text-gray-900 dark:text-white mb-1 font-poppins">{{ $partner->name }}</h4>
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest border {{ $partner->level_badge }}">
                                            {{ $partner->level }}
                                        </span>
                                        <div class="flex items-center gap-1 text-xs text-yellow-500 font-bold">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            {{ number_format($partner->mitraProfile->rating, 1) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl">
                                    <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Tugas Selesai</p>
                                    <p class="text-sm font-black text-gray-900 dark:text-white">{{ $partner->completed_tasks_count }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-black/20 p-4 rounded-2xl">
                                    <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Review</p>
                                    <p class="text-sm font-black text-gray-900 dark:text-white">{{ $partner->receivedReviews->count() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="#" class="flex-1 py-4 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-300 rounded-2xl font-black text-xs uppercase tracking-widest text-center hover:bg-gray-200 transition-all">
                                    Detail Profil
                                </a>
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'mitra-portfolio-{{ $partner->id }}')" class="px-6 py-4 border border-gray-100 dark:border-white/5 rounded-2xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $partners->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
