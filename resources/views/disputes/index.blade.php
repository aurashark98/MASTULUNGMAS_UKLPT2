<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
            {{ __('Daftar Laporan Masalah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($disputes->isEmpty())
                <div class="bg-white dark:bg-mtm-dark-surface p-12 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-sm text-center">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-900 dark:text-white mb-2 font-poppins">Tidak Ada Laporan</h4>
                    <p class="text-gray-500">Seluruh tugas Anda berjalan dengan lancar sejauh ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($disputes as $dispute)
                        <a href="{{ route('disputes.show', $dispute) }}" class="bg-white dark:bg-mtm-dark-surface p-8 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:shadow-md transition-all group">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-gray-50 dark:bg-black/20 flex items-center justify-center text-gray-400 group-hover:text-mtm-red transition-colors">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-black text-gray-900 dark:text-white mb-1 font-poppins">{{ $dispute->task->title }}</h4>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $dispute->reason }}</span>
                                        <span class="text-gray-200 dark:text-white/5">•</span>
                                        <span class="text-xs text-gray-500">{{ $dispute->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                @php
                                    $statusClasses = match($dispute->status) {
                                        'open' => 'bg-blue-100 text-blue-700',
                                        'investigating' => 'bg-yellow-100 text-yellow-700',
                                        'resolved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    };
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusClasses }}">
                                    {{ $dispute->status }}
                                </span>
                                <svg class="w-5 h-5 text-gray-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $disputes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
