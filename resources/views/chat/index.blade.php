<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.3] pointer-events-none z-0"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 max-w-4xl pt-8 pb-16">
        <!-- Header -->
        <div class="mb-10 text-center md:text-left animate-fade-in">
            <h1 class="text-4xl font-black heading-gradient mb-2">
                {{ __('Kotak Masuk') }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium">
                Hubungi konsumen dan mitra kerja Anda secara langsung di platform MTM.
            </p>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="mb-8 p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Conversation List -->
        <div class="glass-card rounded-[2.5rem] p-6 md:p-8 shadow-xl border border-gray-200 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 backdrop-blur-md space-y-4">
            @forelse($chatRooms as $room)
                @php
                    $partner = Auth::id() === $room->user_id ? $room->mitra : $room->user;
                    $lastMessage = $room->messages->first();
                    $unreadCount = $room->messages()->where('sender_id', '!=', Auth::id())->where('is_read', false)->count();
                @endphp
                <a href="{{ route('chat.show', $room) }}" class="block p-5 bg-gray-50 dark:bg-black/20 hover:bg-gray-100 dark:hover:bg-white/5 rounded-3xl border border-gray-100 dark:border-white/5 transition-all duration-300 transform hover:scale-[1.01] hover:shadow-md">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 min-w-0">
                            <!-- Partner Avatar -->
                            <div class="w-12 h-12 bg-white dark:bg-white/10 rounded-full flex-shrink-0 flex items-center justify-center text-mtm-red text-sm font-black shadow-inner border border-gray-200 dark:border-white/5 overflow-hidden">
                                @if($partner->mitraProfile && $partner->mitraProfile->profile_photo_path)
                                    <img src="{{ asset('storage/' . $partner->mitraProfile->profile_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                                @endif
                            </div>
                            
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $partner->name }}</h4>
                                <p class="text-xs text-gray-400 font-medium mt-0.5 truncate">Tugas: {{ $room->task->title }}</p>
                                <p class="text-xs text-gray-650 dark:text-gray-400 mt-2 truncate font-medium">
                                    @if($lastMessage)
                                        @if($lastMessage->sender_id === Auth::id())
                                            <span class="text-gray-405 dark:text-gray-505 font-bold">Anda: </span>
                                        @endif
                                        {{ $lastMessage->message ?? 'Mengirim gambar...' }}
                                    @else
                                        <span class="text-gray-400 italic">Belum ada pesan.</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-right flex-shrink-0 flex flex-col items-end gap-2">
                            <span class="text-[10px] text-gray-450 dark:text-gray-500 font-bold">
                                {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}
                            </span>
                            @if($unreadCount > 0)
                                <span class="px-2.5 py-0.5 bg-mtm-red text-white text-[10px] font-black rounded-full animate-bounce">
                                    {{ $unreadCount }} Baru
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-red-50 dark:bg-red-950/20 rounded-full flex items-center justify-center text-mtm-red mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white font-poppins">Belum Ada Percakapan</h3>
                    <p class="text-sm text-gray-500 mt-1">Percakapan otomatis dibuat ketika Anda menerima penawaran pekerjaan.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
