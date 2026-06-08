<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskDispute;
use App\Models\User;
use App\Notifications\DisputeCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskDisputeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $disputes = TaskDispute::where('reporter_id', Auth::id())
            ->orWhere('reported_user_id', Auth::id())
            ->with(['task', 'reporter', 'reportedUser'])
            ->latest()
            ->paginate(10);

        return view('disputes.index', compact('disputes'));
    }

    public function create(Task $task)
    {
        // Only task owner or assigned mitra can create a dispute
        if (Auth::id() !== $task->user_id && Auth::id() !== ($task->assignment->mitra_id ?? null)) {
            abort(403);
        }

        // Check if dispute already exists for this task
        if ($task->dispute()->exists()) {
            return redirect()->route('disputes.show', $task->dispute)->with('error', 'Laporan masalah sudah ada untuk tugas ini.');
        }

        return view('disputes.create', compact('task'));
    }

    public function store(Request $request, Task $task)
    {
        if (Auth::id() !== $task->user_id && Auth::id() !== ($task->assignment->mitra_id ?? null)) {
            abort(403);
        }

        if ($task->dispute()->exists()) {
            return redirect()->route('disputes.show', $task->dispute)->with('error', 'Laporan masalah sudah ada untuk tugas ini.');
        }

        $request->validate([
            'reason' => 'required|string|max:255',
            'description' => 'required|string',
            'evidence' => 'nullable|image|max:5120',
        ]);

        $reported_user_id = Auth::id() === $task->user_id 
            ? $task->assignment->mitra_id 
            : $task->user_id;

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('disputes', 'public');
        }

        $dispute = TaskDispute::create([
            'task_id' => $task->id,
            'reporter_id' => Auth::id(),
            'reported_user_id' => $reported_user_id,
            'reason' => $request->reason,
            'description' => $request->description,
            'evidence_path' => $evidencePath,
            'status' => 'open',
        ]);

        // Notify Admin and Reported User
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DisputeCreatedNotification($dispute));
        }
        $dispute->reportedUser->notify(new DisputeCreatedNotification($dispute));

        // Log Activity
        \App\Models\ActivityLog::log('Dispute Created', "Melaporkan masalah pada tugas '{$task->title}'");

        return redirect()->route('disputes.show', $dispute)->with('success', 'Laporan masalah berhasil dikirim. Admin akan segera meninjau.');
    }

    public function show(TaskDispute $dispute)
    {
        $this->authorize('view', $dispute);
        $dispute->load(['task', 'reporter', 'reportedUser', 'resolver']);
        return view('disputes.show', compact('dispute'));
    }

    public function respond(Request $request, TaskDispute $dispute)
    {
        // Only reported user can respond
        if (Auth::id() !== $dispute->reported_user_id) {
            abort(403);
        }

        $request->validate([
            'partner_response' => 'required|string',
            'partner_evidence' => 'nullable|image|max:5120',
        ]);

        $evidencePath = $dispute->partner_evidence_path;
        if ($request->hasFile('partner_evidence')) {
            if ($evidencePath) {
                Storage::disk('public')->delete($evidencePath);
            }
            $evidencePath = $request->file('partner_evidence')->store('disputes/responses', 'public');
        }

        $dispute->update([
            'partner_response' => $request->partner_response,
            'partner_evidence_path' => $evidencePath,
        ]);

        return redirect()->back()->with('success', 'Tanggapan Anda berhasil dikirim.');
    }
}
