<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskDispute;
use App\Notifications\DisputeStatusChangedNotification;
use App\Notifications\ResolutionPostedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskDisputeController extends Controller
{
    public function index()
    {
        $disputes = TaskDispute::with(['task', 'reporter', 'reportedUser'])
            ->latest()
            ->paginate(10);

        return view('admin.disputes.index', compact('disputes'));
    }

    public function show(TaskDispute $dispute)
    {
        $dispute->load(['task', 'reporter', 'reportedUser', 'resolver']);
        return view('admin.disputes.show', compact('dispute'));
    }

    public function updateStatus(Request $request, TaskDispute $dispute)
    {
        $request->validate([
            'status' => 'required|in:investigating,resolved,rejected',
            'resolution' => 'required_if:status,resolved,rejected|string|nullable',
        ]);

        $oldStatus = $dispute->status;
        
        $dispute->update([
            'status' => $request->status,
            'resolution' => $request->resolution,
            'resolved_by' => in_array($request->status, ['resolved', 'rejected']) ? Auth::id() : $dispute->resolved_by,
            'resolved_at' => in_array($request->status, ['resolved', 'rejected']) ? now() : $dispute->resolved_at,
        ]);

        // Notify involved parties if status changed
        if ($oldStatus !== $request->status) {
            $dispute->reporter->notify(new DisputeStatusChangedNotification($dispute));
            $dispute->reportedUser->notify(new DisputeStatusChangedNotification($dispute));
        }

        // Notify resolution if posted
        if (in_array($request->status, ['resolved', 'rejected']) && $request->filled('resolution')) {
            $dispute->reporter->notify(new ResolutionPostedNotification($dispute));
            $dispute->reportedUser->notify(new ResolutionPostedNotification($dispute));
        }

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
