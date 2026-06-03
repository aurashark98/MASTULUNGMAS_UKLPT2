<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Tugas') }}
            </h2>
            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full uppercase">
                {{ str_replace('_', ' ', $task->status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid md:grid-cols-3 gap-8">
            <!-- Task Details -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white dark:bg-mtm-dark-surface overflow-hidden shadow-xl sm:rounded-3xl p-8">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-red-50 dark:bg-red-950/20 text-mtm-red text-[10px] font-bold rounded-full uppercase">
                            {{ $task->category->name }}
                        </span>
                        <span class="text-xs text-gray-500">• Diposting {{ $task->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-poppins">{{ $task->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">{{ $task->description }}</p>

                    <div class="grid grid-cols-2 gap-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Budget</p>
                            <p class="text-xl font-bold text-mtm-red">Rp {{ number_format($task->budget, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Lokasi</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $task->location }}</p>
                        </div>
                    </div>

                    @if($task->images)
                        <div class="mt-8">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-4">Foto Lampiran</p>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach($task->images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-32 object-cover rounded-2xl" alt="Task Image">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Bids Section (Visible to User/Owner) -->
                @if(Auth::id() === $task->user_id)
                    <div class="space-y-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Penawaran Masuk ({{ $task->bids->count() }})</h4>
                        @forelse($task->bids as $bid)
                            <div class="bg-white dark:bg-mtm-dark-surface p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex-shrink-0">
                                        @if($bid->mitra->mitraProfile->profile_photo_path)
                                            <img src="{{ asset('storage/' . $bid->mitra->mitraProfile->profile_photo_path) }}" class="w-full h-full rounded-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-sm">{{ $bid->mitra->name }}</h5>
                                        <div class="flex items-center gap-1 text-xs text-yellow-500">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span class="font-bold">{{ number_format($bid->mitra->mitraProfile->rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-lg text-mtm-red mb-2">Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}</p>
                                    @if($task->status === 'bid_received' || $task->status === 'waiting_for_bid')
                                        <form action="{{ route('bids.accept', $bid) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-full text-xs font-bold hover:shadow-lg transition-all">
                                                Terima Penawaran
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-50 dark:bg-mtm-dark/50 p-12 rounded-3xl text-center">
                                <p class="text-gray-500">Belum ada penawaran masuk.</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <div class="bg-white dark:bg-mtm-dark-surface p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <h4 class="font-bold mb-4 font-poppins">Pembuat Tugas</h4>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm">{{ $task->user->name }}</p>
                            <p class="text-xs text-gray-500">Anggota sejak {{ $task->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->role === 'mitra' && ($task->status === 'waiting_for_bid' || $task->status === 'bid_received'))
                    @php
                        $myBid = $task->bids->where('mitra_id', Auth::id())->first();
                    @endphp

                    @if(!$myBid)
                        <div class="bg-gradient-to-br from-mtm-red to-mtm-brown p-8 rounded-3xl text-white">
                            <h4 class="font-bold mb-2 font-poppins">Tarik Tugas Ini?</h4>
                            <p class="text-xs text-red-100 mb-6">Berikan penawaran terbaik Anda untuk membantu tugas ini.</p>
                            
                            <form action="{{ route('mitra.tasks.bid', $task) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold mb-1">Budget Anda (Rp)</label>
                                    <input type="number" name="bid_amount" value="{{ $task->budget }}" class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-red-200 focus:ring-white focus:border-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold mb-1">Pesan (Opsional)</label>
                                    <textarea name="message" rows="3" class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-red-200 focus:ring-white focus:border-white" placeholder="Sampaikan mengapa Anda yang terbaik..."></textarea>
                                </div>
                                <button type="submit" class="w-full py-4 bg-white text-mtm-red rounded-2xl font-bold shadow-lg hover:bg-gray-100 transition-all">
                                    Kirim Penawaran
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-green-50 dark:bg-green-950/20 p-8 rounded-3xl border border-green-100 dark:border-green-900/30">
                            <h4 class="font-bold text-green-700 dark:text-green-400 mb-2 font-poppins">Penawaran Anda Terkirim</h4>
                            <p class="text-xs text-green-600 dark:text-green-500 mb-4">Anda menawarkan Rp {{ number_format($myBid->bid_amount, 0, ',', '.') }}</p>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">
                                {{ $myBid->status }}
                            </span>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
