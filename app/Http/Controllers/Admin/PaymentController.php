<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('task.user', 'task.assignment.mitra')->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
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
