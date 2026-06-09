<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ActivityLog;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('task.user', 'task.bids.mitra')->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function checkPending()
    {
        $count = Payment::where('status', 'pending')->count();
        return response()->json(['pending_count' => $count]);
    }

    public function verify(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Pembayaran ini sudah tidak berstatus pending.');
        }

        $payment->update([
            'status' => 'completed',
            'verified_at' => now()
        ]);

        $task = $payment->task;
        $acceptedBid = $task->bids()->where('status', 'accepted')->first();

        if ($acceptedBid && $task->status !== 'assigned') {
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

            // Update task status
            $task->update(['status' => 'assigned']);

            ActivityLog::log('Payment Activity', "Admin memverifikasi pembayaran QRIS untuk tugas '{$task->title}'");

            // Notify Mitra
            $acceptedBid->mitra->sendNotification(
                'payment_completed',
                'Pembayaran Diterima & Terverifikasi',
                "Admin telah memverifikasi pembayaran untuk tugas '{$task->title}'. Anda sekarang dapat memulai pekerjaan.",
                route('tasks.show', $task)
            );

            // Notify User
            $task->user->sendNotification(
                'payment_completed',
                'Pembayaran Berhasil Diverifikasi',
                "Pembayaran QRIS untuk tugas '{$task->title}' telah berhasil diverifikasi admin. Mitra akan segera menuju lokasi Anda.",
                route('tasks.show', $task)
            );
        }

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil diverifikasi! Mitra telah ditugaskan.');
    }

    public function create()
    {
        $tasks = Task::all();
        $users = User::all();
        return view('admin.payments.create', compact('tasks', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id',
        ]);

        Payment::create([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'transaction_id' => $request->transaction_id ?? 'TRX-' . strtoupper(Str::random(10)),
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Transaksi pembayaran baru berhasil ditambahkan!');
    }

    public function edit(Payment $payment)
    {
        $tasks = Task::all();
        $users = User::all();
        return view('admin.payments.edit', compact('payment', 'tasks', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|in:pending,completed,failed,refunded',
            'transaction_id' => 'required|string|max:255|unique:payments,transaction_id,' . $payment->id,
        ]);

        $payment->update([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'transaction_id' => $request->transaction_id,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Transaksi pembayaran berhasil diperbarui!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Transaksi pembayaran berhasil dihapus!');
    }
}
