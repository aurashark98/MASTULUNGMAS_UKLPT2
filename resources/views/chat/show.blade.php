<x-app-layout>
    <!-- Dot Grid Background -->
    <div class="fixed inset-0 dot-grid opacity-[0.2] pointer-events-none z-0"></div>

    @php
        $partner = Auth::id() === $chatRoom->user_id ? $chatRoom->mitra : $chatRoom->user;
        $isPartnerOnline = $partner->mitraProfile ? $partner->mitraProfile->is_online : false;
    @endphp

    <div class="container mx-auto px-4 md:px-6 relative z-10 max-w-4xl pt-8 pb-16">
        <!-- Back Button & Header Card -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('chat.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-mtm-red transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Inbox
            </a>
            
            <a href="{{ route('tasks.show', $chatRoom->task) }}" class="px-4 py-1.5 bg-red-50 dark:bg-red-950/20 text-mtm-red hover:underline text-xs font-bold rounded-full transition-all">
                Detail Tugas: {{ Str::limit($chatRoom->task->title, 25) }}
            </a>
        </div>

        <!-- Chat Container -->
        <div class="glass-card rounded-[2.5rem] overflow-hidden shadow-xl border border-gray-200 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/40 backdrop-blur-md flex flex-col h-[600px]">
            <!-- Chat Partner Header -->
            <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative w-10 h-10 rounded-full overflow-hidden border border-gray-200 dark:border-white/5">
                        <img src="{{ $partner->profile_photo_url }}" class="w-full h-full object-cover">
                        
                        <!-- Status indicator -->
                        <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white dark:border-[#1a1a1a] {{ $isPartnerOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">{{ $partner->name }}</h3>
                        <p class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase">
                            {{ $isPartnerOnline ? 'Online' : 'Offline' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50/10 dark:bg-black/10">
                @forelse($chatRoom->messages as $msg)
                    @php
                        $isMe = $msg->sender_id === Auth::id();
                    @endphp
                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%] space-y-1">
                            <!-- Message bubble -->
                            <div class="p-4 rounded-3xl text-sm leading-relaxed {{ $isMe ? 'bg-gradient-to-r from-mtm-red to-mtm-red-dark text-white rounded-tr-none' : 'bg-white dark:bg-[#1a1a1a] text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-white/5 rounded-tl-none shadow-sm' }}">
                                @if($msg->image_path)
                                    <div class="mb-2 rounded-2xl overflow-hidden max-w-sm">
                                        <img src="{{ asset('storage/' . $msg->image_path) }}" class="w-full h-auto object-cover max-h-60" alt="Uploaded Image">
                                    </div>
                                @endif
                                @if($msg->message)
                                    <p>{{ $msg->message }}</p>
                                @endif
                            </div>
                            <!-- Timestamp and Read Status -->
                            <div class="flex items-center gap-1.5 px-2 text-[10px] text-gray-400 font-bold {{ $isMe ? 'justify-end' : 'justify-start' }}">
                                <span>{{ $msg->created_at->format('H:i') }}</span>
                                @if($isMe)
                                    <span>•</span>
                                    <span class="{{ $msg->is_read ? 'text-blue-500' : 'text-gray-400' }}">
                                        @if($msg->is_read)
                                            Dibaca
                                        @else
                                            Terkirim
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex items-center justify-center text-center">
                        <div>
                            <div class="w-12 h-12 bg-red-50 dark:bg-red-950/20 rounded-full flex items-center justify-center text-mtm-red mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-800 dark:text-white font-poppins">Mulai Diskusi</h4>
                            <p class="text-xs text-gray-500 mt-1">Kirim pesan pertama Anda untuk memulai negosiasi atau pengerjaan.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Input Bar -->
            <div class="p-4 border-t border-gray-100 dark:border-white/5 bg-white dark:bg-mtm-dark-surface/80" x-data="{ 
                imagePreview: null,
                fileSelected(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.imagePreview = URL.createObjectURL(file);
                    } else {
                        this.imagePreview = null;
                    }
                },
                clearImage() {
                    this.imagePreview = null;
                    document.getElementById('image-upload').value = '';
                }
            }">
                <!-- Image attachment preview -->
                <div x-show="imagePreview" class="mb-3 p-2 bg-gray-50 dark:bg-black/20 rounded-2xl flex items-center justify-between border border-gray-150 dark:border-white/5">
                    <div class="flex items-center gap-3">
                        <img :src="imagePreview" class="w-16 h-16 object-cover rounded-xl border border-gray-200 dark:border-white/10">
                        <span class="text-xs font-bold text-gray-500">Foto siap diunggah</span>
                    </div>
                    <button type="button" @click="clearImage()" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-full transition-all text-xs font-bold">
                        Batal
                    </button>
                </div>

                <form method="POST" action="{{ route('chat.messages.store', $chatRoom) }}" enctype="multipart/form-data" class="flex items-center gap-3">
                    @csrf
                    <!-- Photo upload trigger -->
                    <label for="image-upload" class="p-3 bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 rounded-2xl cursor-pointer transition-all flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <input type="file" id="image-upload" name="image" class="hidden" accept="image/*" @change="fileSelected($event)">
                    </label>

                    <!-- Message text input -->
                    <input type="text" name="message" class="flex-1 bg-gray-100 dark:bg-black/20 border-transparent dark:border-transparent rounded-2xl py-3 px-4 text-sm focus:ring-mtm-red focus:border-mtm-red dark:text-white dark:placeholder-gray-500" placeholder="Tulis pesan Anda...">

                    <!-- Send button -->
                    <button type="submit" class="p-3 bg-gradient-to-r from-mtm-red to-mtm-red-dark hover:shadow-mtm-red/25 text-white rounded-2xl font-bold transition-all flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scroll to bottom on load -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('chat-messages');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-app-layout>
