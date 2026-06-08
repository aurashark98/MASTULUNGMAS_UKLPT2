<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-800 dark:text-gray-200 leading-tight font-poppins">
                {{ __('Manajemen Laporan Masalah') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-sm sm:rounded-[2.5rem] border border-gray-100 dark:border-white/5">
                <div class="p-8 md:p-12">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em] border-b border-gray-50 dark:border-white/5">
                                    <th class="pb-6 px-4">Tugas</th>
                                    <th class="pb-6 px-4">Pelapor</th>
                                    <th class="pb-6 px-4">Terlapor</th>
                                    <th class="pb-6 px-4">Alasan</th>
                                    <th class="pb-6 px-4">Status</th>
                                    <th class="pb-6 px-4">Tanggal</th>
                                    <th class="pb-6 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                                @foreach($disputes as $dispute)
                                    <tr class="group hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                                        <td class="py-6 px-4">
                                            <p class="font-black text-sm text-gray-900 dark:text-white">{{ $dispute->task->title }}</p>
                                        </td>
                                        <td class="py-6 px-4">
                                            <p class="text-sm font-bold">{{ $dispute->reporter->name }}</p>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $dispute->reporter->role }}</p>
                                        </td>
                                        <td class="py-6 px-4">
                                            <p class="text-sm font-bold">{{ $dispute->reportedUser->name }}</p>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $dispute->reportedUser->role }}</p>
                                        </td>
                                        <td class="py-6 px-4">
                                            <span class="text-xs font-medium text-gray-500">{{ $dispute->reason }}</span>
                                        </td>
                                        <td class="py-6 px-4">
                                            @php
                                                $statusClasses = match($dispute->status) {
                                                    'open' => 'bg-blue-100 text-blue-700',
                                                    'investigating' => 'bg-yellow-100 text-yellow-700',
                                                    'resolved' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                };
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusClasses }}">
                                                {{ $dispute->status }}
                                            </span>
                                        </td>
                                        <td class="py-6 px-4">
                                            <p class="text-xs text-gray-500">{{ $dispute->created_at->format('d/m/y H:i') }}</p>
                                        </td>
                                        <td class="py-6 px-4">
                                            <a href="{{ route('admin.disputes.show', $dispute) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all">
                                                Tinjau
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8">
                        {{ $disputes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
