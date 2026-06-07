<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Kelola Profil Mitra</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar seluruh profil pengajuan dan detail keahlian mitra MTM.</p>
            </div>
            
            <a href="{{ route('admin.mitra-profiles.create') }}" class="px-5 py-3 bg-gradient-to-r from-red-500 to-amber-500 hover:scale-[1.02] hover:shadow-lg hover:shadow-red-500/20 active:scale-[0.98] transition-all text-white font-bold text-sm rounded-2xl flex items-center gap-2 cursor-pointer shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Profil Mitra
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Mitra Profiles Table -->
        <div class="bg-white dark:bg-mtm-dark-surface rounded-3xl border border-gray-200 dark:border-white/5 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 dark:text-gray-500 text-xs uppercase font-bold border-b border-gray-100 dark:border-white/5">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Mitra</th>
                            <th class="px-6 py-4">Dokumen & Foto</th>
                            <th class="px-6 py-4">Keahlian (Skills)</th>
                            <th class="px-6 py-4">Rating / Pendapatan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        @forelse($profiles as $profile)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-gray-500 dark:text-gray-400">
                                    #{{ $profile->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($profile->profile_photo_path)
                                            <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" alt="Foto Profile" class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-white/10 shadow-sm">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center font-black text-xs text-mtm-red border border-gray-200 dark:border-white/10 shadow-sm">
                                                {{ strtoupper(substr($profile->user->name ?? 'M', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-sm text-gray-800 dark:text-white leading-snug">{{ $profile->user->name ?? 'User Terhapus' }}</p>
                                            <p class="text-[11px] text-gray-400 dark:text-gray-500 font-medium">{{ $profile->user->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <div class="space-y-1">
                                        @if($profile->ktp_path)
                                            <a href="{{ asset('storage/' . $profile->ktp_path) }}" target="_blank" class="inline-flex items-center gap-1 text-mtm-red hover:underline font-bold">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                Lihat KTP
                                            </a>
                                        @else
                                            <span class="text-gray-400">KTP Tidak Ada</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @if(is_array($profile->skills))
                                            @foreach($profile->skills as $skill)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300">
                                                    {{ $skill }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5 text-sm font-bold text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span>{{ number_format($profile->rating, 1) }}</span>
                                    </div>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">Pendapatan: Rp {{ number_format($profile->earnings, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($profile->is_verified)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-600 dark:text-green-400">
                                            TERVERIFIKASI
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-500/10 text-red-650 dark:text-red-400">
                                            TIDAK TERVERIFIKASI
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.mitra-profiles.edit', $profile) }}" class="p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 rounded-xl transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.mitra-profiles.destroy', $profile) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil mitra ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500/20 rounded-xl transition-all cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                    Tidak ada data profil mitra.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($profiles->hasPages())
                <div class="p-6 border-t border-gray-100 dark:border-white/5">
                    {{ $profiles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
