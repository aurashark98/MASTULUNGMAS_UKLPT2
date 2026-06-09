<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ActivityLog;

class PaymentController extends Controller
{
    public function showPaymentPage(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        if ($task->status !== 'bid_accepted') {
            return redirect()->route('tasks.show', $task)->with('error', 'Pembayaran hanya dapat dilakukan setelah Anda menyetujui penawaran Mitra.');
        }

        if ($task->payment && $task->payment->status === 'completed') {
            return redirect()->route('tasks.show', $task)->with('error', 'Tugas ini sudah dibayar.');
        }

        return view('tasks.payment', compact('task'));
    }

    public function processPayment(Request $request, Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        if ($task->status !== 'bid_accepted') {
            return redirect()->route('tasks.show', $task)->with('error', 'Pembayaran hanya dapat dilakukan setelah Anda menyetujui penawaran Mitra.');
        }

        $request->validate([
            'payment_method' => 'required|string|in:qris,cod',
            'proof' => 'required_if:payment_method,qris|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proofPath = null;
        if ($request->payment_method === 'qris' && $request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('payments', 'public');
        }

        $payment = Payment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'amount' => $task->budget,
            'payment_method' => $request->payment_method,
            'status' => $request->payment_method === 'qris' ? 'pending' : 'completed',
            'transaction_id' => 'TX-' . strtoupper(Str::random(12)),
            'proof_path' => $proofPath,
        ]);

        $acceptedBid = $task->bids()->where('status', 'accepted')->first();
        if (!$acceptedBid) {
            return redirect()->route('tasks.show', $task)->with('error', 'Tidak ada penawaran yang disetujui.');
        }

        if ($request->payment_method === 'qris') {
            ActivityLog::log('Payment Activity', "Mengunggah bukti pembayaran QRIS untuk tugas '{$task->title}' sebesar Rp " . number_format($task->budget, 0, ',', '.'));
            return redirect()->route('tasks.show', $task)->with('success', 'Bukti pembayaran QRIS berhasil diunggah! Menunggu verifikasi admin sebelum Mitra dapat ditugaskan.');
        }

        // --- COD FLOW (Auto-Complete Payment Phase) ---
        // Create assignment
        $task->assignment()->create([
            'mitra_id' => $acceptedBid->mitra_id,
            'assigned_at' => now(),
        ]);

        // Create Chat Room automatically
        \App\Models\ChatRoom::firstOrCreate([
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'mitra_id' => $acceptedBid->mitra_id,
        ]);

        // Update task status to assigned (Mitra can start)
        $task->update(['status' => 'assigned']);

        // Log Activity
        ActivityLog::log('Payment Activity', "Melakukan pembayaran COD untuk tugas '{$task->title}' sebesar Rp " . number_format($task->budget, 0, ',', '.'));

        // Notify Mitra
        $acceptedBid->mitra->sendNotification(
            'payment_completed',
            'Pembayaran COD Dipilih',
            "Konsumen memilih pembayaran COD untuk tugas '{$task->title}'. Anda sekarang dapat memulai pekerjaan.",
            route('tasks.show', $task)
        );

        // Notify User
        Auth::user()->sendNotification(
            'payment_completed',
            'Pembayaran COD Dikonfirmasi',
            "Tugas '{$task->title}' akan dibayar secara COD. Mitra akan segera menuju lokasi Anda.",
            route('tasks.show', $task)
        );

        return redirect()->route('tasks.show', $task)->with('success', 'Pilihan COD berhasil dikonfirmasi! Mitra akan segera mengerjakan tugas Anda.');

    }
}
