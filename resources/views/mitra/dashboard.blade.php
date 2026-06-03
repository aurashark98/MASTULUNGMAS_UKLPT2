<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Mitra Tulung') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-sm text-gray-500 mb-2">Total Pendapatan</p>
                    <h3 class="text-3xl font-bold text-mtm-red font-poppins">Rp {{ number_format($profile->earnings, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-sm text-gray-500 mb-2">Rating</p>
                    <div class="flex items-center gap-2">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white font-poppins">{{ number_format($profile->rating, 1) }}</h3>
                        <div class="flex text-yellow-400">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <p class="text-sm text-gray-500 mb-2">Status Verifikasi</p>
                    <span class="px-4 py-1 {{ $profile->is_verified ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs font-bold rounded-full">
                        {{ $profile->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                    </span>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Available Tasks -->
                <div class="md:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Tugas Tersedia</h4>
                        <a href="#" class="text-sm text-mtm-red hover:underline">Lihat Semua</a>
                    </div>

                    @forelse($available_tasks as $task)
                        <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-all">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 bg-red-50 dark:bg-red-950/20 text-mtm-red text-[10px] font-bold rounded-full mb-2 uppercase">
                                        {{ $task->category->name }}
                                    </span>
                                    <h5 class="font-bold text-lg">{{ $task->title }}</h5>
                                    <p class="text-xs text-gray-500 mt-1">Oleh {{ $task->user->name }} • {{ $task->location }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-mtm-red">Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $task->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 line-clamp-2">{{ $task->description }}</p>
                            <div class="flex items-center gap-4">
                                <button class="flex-1 px-6 py-3 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-xl font-bold text-sm shadow-lg hover:shadow-mtm-red/20 transition-all">
                                    Berikan Tawaran
                                </button>
                                <button class="px-6 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all">
                                    Detail
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-50 dark:bg-mtm-dark/50 p-12 rounded-3xl text-center border-2 border-dashed border-gray-200 dark:border-gray-800">
                            <p class="text-gray-500">Belum ada tugas tersedia untuk saat ini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Active Assignments -->
                <div class="space-y-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Tugas Berjalan</h4>
                    <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                        <div class="space-y-6">
                            @forelse($active_assignments as $assignment)
                                <div class="p-4 bg-gray-50 dark:bg-mtm-dark/30 rounded-2xl border border-gray-100 dark:border-gray-800">
                                    <h5 class="font-bold text-sm mb-1">{{ $assignment->task->title }}</h5>
                                    <p class="text-[10px] text-gray-500 mb-3">{{ $assignment->task->user->name }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-bold">
                                            {{ strtoupper($assignment->task->status) }}
                                        </span>
                                        <a href="#" class="text-[10px] font-bold text-mtm-red">Update Progress</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada tugas berjalan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
