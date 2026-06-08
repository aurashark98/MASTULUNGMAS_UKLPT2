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

        if ($task->status !== 'completed') {
            return redirect()->route('tasks.show', $task)->with('error', 'Pembayaran hanya dapat dilakukan setelah tugas selesai dikerjakan.');
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

        if ($task->status !== 'completed') {
            return redirect()->route('tasks.show', $task)->with('error', 'Pembayaran hanya dapat dilakukan setelah tugas selesai dikerjakan.');
        }

        $request->validate([
            'payment_method' => 'required|string|in:qris,dana,ovo,gopay,bank_transfer',
        ]);

        $payment = Payment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'amount' => $task->budget,
            'payment_method' => $request->payment_method,
            'status' => 'completed',
            'transaction_id' => 'TX-' . strtoupper(Str::random(12)),
        ]);

        // Log Activity
        ActivityLog::log('Payment Activity', "Melakukan pembayaran tugas '{$task->title}' sebesar Rp " . number_format($task->budget, 0, ',', '.') . " melalui " . strtoupper($request->payment_method));

        // Notify Mitra
        if ($task->assignment && $task->assignment->mitra) {
            $task->assignment->mitra->sendNotification(
                'payment_completed',
                'Pembayaran Diterima',
                "Konsumen telah melakukan pembayaran untuk tugas '{$task->title}'.",
                route('tasks.show', $task)
            );
        }

        // Notify User
        Auth::user()->sendNotification(
            'payment_completed',
            'Pembayaran Sukses',
            "Pembayaran untuk tugas '{$task->title}' telah berhasil diproses.",
            route('tasks.show', $task)
        );

        return redirect()->route('tasks.show', $task)->with('success', 'Pembayaran berhasil! Silakan berikan ulasan pelayanan Mitra.');
    }
}
