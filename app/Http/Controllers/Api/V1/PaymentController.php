<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * POST /api/v1/tasks/{task}/pay
     * Process payment for a task.
     */
    public function processPayment(Request $request, Task $task)
    {
        $user = $request->user();

        if ($user->id !== $task->user_id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        if ($task->status !== 'completed') {
            return response()->json(['success' => false, 'message' => 'Tugas belum selesai, tidak dapat diproses pembayarannya.'], 422);
        }

        if ($task->payment && $task->payment->status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Tugas ini sudah dibayar.'], 422);
        }

        $request->validate([
            'payment_method' => 'required|in:transfer,cash,e-wallet',
        ]);

        $payment = Payment::updateOrCreate(
            ['task_id' => $task->id],
            [
                'user_id'        => $user->id,
                'amount'         => $task->budget,
                'payment_method' => $request->payment_method,
                'status'         => 'paid',
                'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
            ]
        );

        $task->update(['status' => 'paid']);

        // Notify mitra
        if ($task->assignment && $task->assignment->mitra) {
            $task->assignment->mitra->sendNotification(
                'payment_received',
                'Pembayaran Diterima!',
                "Pembayaran untuk tugas '{$task->title}' telah dikonfirmasi.",
                route('tasks.show', $task)
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diproses.',
            'data'    => $payment,
        ]);
    }
}
