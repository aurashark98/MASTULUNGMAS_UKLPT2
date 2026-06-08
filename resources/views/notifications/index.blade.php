<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.3] pointer-events-none z-0"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 max-w-4xl pt-8 pb-16">
        <!-- Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
            <div>
                <h1 class="text-4xl font-black heading-gradient mb-2">
                    {{ __('Notifikasi') }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">
                    Pantau pembaruan status pengerjaan, pembayaran, ulasan, dan pesan Anda.
                </p>
            </div>
            
            @if($notifications->where('read_at', null)->count() > 0)
                <form method="POST" action="{{ route('notifications.markAllRead') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-150 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 rounded-full font-bold text-xs hover:shadow-sm transition-all cursor-pointer">
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>

        <!-- Notification List -->
        <div class="glass-card rounded-[2.5rem] p-6 md:p-8 shadow-xl border border-gray-200 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 backdrop-blur-md space-y-4">
            @forelse($notifications as $notif)
                @php
                    $isUnread = is_null($notif->read_at);
                    $data = $notif->data;
                    $type = $data['type'] ?? 'default';
                    $title = $data['title'] ?? 'Notifikasi Baru';
                    $message = $data['message'] ?? '';
                    $url = $data['url'] ?? '#';

                    // Set icon and colors based on notification type
                    $colorClasses = match($type) {
                        'payment_completed' => 'bg-green-500/10 text-green-500',
                        'bid_accepted' => 'bg-blue-500/10 text-blue-500',
                        'task_assigned' => 'bg-teal-500/10 text-teal-500',
                        'new_bid' => 'bg-amber-500/10 text-amber-500',
                        'new_message' => 'bg-indigo-500/10 text-indigo-500',
                        'new_review' => 'bg-purple-500/10 text-purple-500',
                        'task_in_progress' => 'bg-yellow-500/10 text-yellow-500',
                        'task_completed' => 'bg-emerald-500/10 text-emerald-500',
                        default => 'bg-red-500/10 text-mtm-red',
                    };
                @endphp
                
                <a href="{{ $url }}" class="block p-5 rounded-3xl border transition-all duration-300 transform hover:scale-[1.005] hover:shadow-md
                    {{ $isUnread 
                        ? 'bg-red-500/[0.03] dark:bg-red-500/[0.02] border-mtm-red/20 dark:border-mtm-red/10' 
                        : 'bg-gray-50/50 dark:bg-black/10 border-gray-100 dark:border-white/5' }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex gap-4">
                            <!-- Type Icon -->
                            <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-xs {{ $colorClasses }}">
                                @if($type === 'new_message')
                                    ✉
                                @elseif($type === 'payment_completed')
                                    $
                                @elseif($type === 'new_review')
                                    ★
                                @else
                                    !
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-bold text-gray-950 dark:text-white flex items-center gap-2">
                                    {{ $title }}
                                    @if($isUnread)
                                        <span class="w-2 h-2 rounded-full bg-mtm-red inline-block"></span>
                                    @endif
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">{{ $message }}</p>
                            </div>
                        </div>
                        
                        <span class="text-[10px] text-gray-400 dark:text-gray-500 font-bold whitespace-nowrap flex-shrink-0">
                            {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-red-50 dark:bg-red-950/20 rounded-full flex items-center justify-center text-mtm-red mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white font-poppins">Belum Ada Notifikasi</h3>
                    <p class="text-sm text-gray-500 mt-1">Aktivitas baru Anda akan ditampilkan di halaman ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
