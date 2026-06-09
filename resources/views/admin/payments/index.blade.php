<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black font-poppins text-gray-800 dark:text-white">Histori Transaksi</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar transaksi pembayaran pengerjaan tugas oleh klien kepada mitra di MTM.</p>
            </div>
            
            <a href="{{ route('admin.payments.create') }}" class="px-5 py-3 bg-gradient-to-r from-red-500 to-amber-500 hover:scale-[1.02] hover:shadow-lg hover:shadow-red-500/20 active:scale-[0.98] transition-all text-white font-bold text-sm rounded-2xl flex items-center gap-2 cursor-pointer shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Transaksi
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900/30 text-sm font-bold text-green-600 dark:text-green-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Payments Table -->
        <div class="bg-white dark:bg-mtm-dark-surface rounded-3xl border border-gray-200 dark:border-white/5 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 dark:text-gray-500 text-xs uppercase font-bold border-b border-gray-100 dark:border-white/5">
                            <th class="px-6 py-4">ID Transaksi</th>
                            <th class="px-6 py-4">Tugas / Pekerjaan</th>
                            <th class="px-6 py-4">Klien (Pengirim)</th>
                            <th class="px-6 py-4">Mitra (Penerima)</th>
                            <th class="px-6 py-4">Nominal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Metode</th>
                            <th class="px-6 py-4">Bukti</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400">
                                    {{ $payment->transaction_id ?? 'TRX-' . $payment->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-sm text-gray-800 dark:text-white leading-tight">
                                        {{ $payment->task->title ?? 'Tugas Terhapus' }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500">ID Tugas: #{{ $payment->task_id }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ $payment->user->name ?? ($payment->task->user->name ?? '-') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    {{ $payment->task->assignment->mitra->name ?? 'Belum Ditugaskan' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-black text-mtm-red">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->status === 'completed' || $payment->status === 'success')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-600 dark:text-green-400">
                                            SUKSES
                                        </span>
                                    @elseif($payment->status === 'pending' || $payment->status === 'processing')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-600 dark:text-yellow-400">
                                            PENDING
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-500/10 text-red-600 dark:text-red-400">
                                            {{ strtoupper($payment->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-gray-650 dark:text-gray-400">
                                    {{ strtoupper($payment->payment_method ?? 'E-Wallet') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->proof_path)
                                        <a href="{{ Storage::url($payment->proof_path) }}" target="_blank" class="text-[10px] bg-blue-500/10 text-blue-500 px-2 py-1 rounded-lg hover:bg-blue-500/20 transition-all font-bold block text-center">Lihat Bukti</a>
                                    @else
                                        <span class="text-xs text-gray-400 block text-center">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-450 dark:text-gray-500 font-medium">
                                    {{ $payment->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($payment->status === 'pending')
                                            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" onsubmit="return confirm('Verifikasi pembayaran ini? Mitra akan otomatis ditugaskan ke klien.')">
                                                @csrf
                                                <button type="submit" class="p-2 bg-green-500/10 text-green-600 dark:text-green-400 hover:bg-green-500/20 rounded-xl transition-all cursor-pointer font-bold text-[10px] uppercase tracking-wider shadow-sm" title="Verifikasi Lunas">
                                                    Verifikasi
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.payments.edit', $payment) }}" class="p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 rounded-xl transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?')">
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
                                <td colspan="9" class="px-6 py-8 text-center text-sm text-gray-500">
                                    Tidak ada histori transaksi pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($payments->hasPages())
                <div class="p-6 border-t border-gray-100 dark:border-white/5">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
