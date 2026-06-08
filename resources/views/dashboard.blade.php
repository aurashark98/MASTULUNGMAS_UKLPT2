<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Congratulations Banner for Accepted Mitra -->
            @if(Auth::user()->mitraProfile && Auth::user()->mitraProfile->is_verified)
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 overflow-hidden shadow-xl sm:rounded-3xl p-6 text-white animate-fade-in border border-amber-400/20">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4 text-center sm:text-left flex-col sm:flex-row">
                            <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white border border-white/20 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-black font-poppins">Selamat bergabung menjadi mitra mtm!</h4>
                                <p class="text-xs text-amber-100 font-medium">Akun kemitraan Anda telah disetujui. Beralihlah ke mode kerja untuk mulai menerima tawaran tugas.</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('profile.switch-role') }}">
                            @csrf
                            <button type="submit" class="px-6 py-2.5 bg-white text-amber-600 rounded-full font-bold text-xs uppercase tracking-wider shadow-lg hover:bg-gray-100 transition-all cursor-pointer">
                                Beralih ke Mode Mitra
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-mtm-red to-mtm-brown overflow-hidden shadow-xl sm:rounded-[2.5rem] p-8 md:p-10 text-white relative">
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <!-- Profile Photo in Dashboard -->
                    <div class="flex-shrink-0">
                        <div class="w-32 h-32 rounded-[2.2rem] overflow-hidden border-4 border-white/20 shadow-2xl">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="text-center md:text-left">
                        <h3 class="text-3xl font-black mb-2 font-poppins">Halo, {{ Auth::user()->name }}!</h3>
                        <p class="text-red-100 opacity-90 font-medium">Butuh bantuan apa hari ini? Mitra kami siap membantu Anda.</p>
                        <div class="mt-8">
                            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-8 py-4 bg-white text-mtm-red rounded-2xl font-black shadow-lg hover:shadow-white/10 hover:scale-105 active:scale-95 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Buat Tugas Baru
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Background Pattern -->
                <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-10 translate-y-10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"></path></svg>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Active Tasks -->
                <div class="md:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Tugas Aktif</h4>
                        <a href="{{ route('tasks.index') }}" class="text-sm text-mtm-red hover:underline">Lihat Semua</a>
                    </div>

                    @forelse($active_tasks as $task)
                        <a href="{{ route('tasks.show', $task) }}" class="block bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md hover:scale-[1.005] transition-all">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-red-50 dark:bg-red-950/20 text-mtm-red text-[10px] font-bold rounded-full mb-2 uppercase">
                                        {{ $task->category->name }}
                                    </span>
                                    <h5 class="font-bold text-lg text-gray-900 dark:text-white">{{ $task->title }}</h5>
                                </div>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-650 dark:text-gray-400 mb-4 line-clamp-2">{{ $task->description }}</p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-800">
                                <div class="text-sm font-bold text-mtm-red">
                                    Rp {{ number_format($task->budget, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-550 dark:text-gray-450">
                                    {{ $task->bids->count() }} Penawaran
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="bg-gray-50 dark:bg-mtm-dark/50 p-12 rounded-3xl text-center border-2 border-dashed border-gray-200 dark:border-gray-800">
                            <p class="text-gray-500">Belum ada tugas aktif.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Task History -->
                <div class="space-y-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Riwayat Terakhir</h4>
                    <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                        <div class="space-y-6">
                            @forelse($task_history as $history)
                                <a href="{{ route('tasks.show', $history) }}" class="flex gap-4 hover:opacity-85 transition-opacity">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate w-40">{{ $history->title }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $history->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-[10px] font-bold {{ $history->status === 'completed' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ strtoupper($history->status) }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
