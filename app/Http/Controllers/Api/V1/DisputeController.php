<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskDispute;
use App\Models\User;
use App\Notifications\DisputeCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisputeController extends Controller
{
    /**
     * GET /api/v1/disputes
     * List disputes involving the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $disputes = TaskDispute::where('reporter_id', $user->id)
            ->orWhere('reported_user_id', $user->id)
            ->with(['task', 'reporter', 'reportedUser'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $disputes->items(),
            'meta'    => [
                'current_page' => $disputes->currentPage(),
                'last_page'    => $disputes->lastPage(),
                'per_page'     => $disputes->perPage(),
                'total'        => $disputes->total(),
            ],
        ]);
    }

    /**
     * POST /api/v1/tasks/{task}/dispute
     * Create a dispute for a task.
     */
    public function store(Request $request, Task $task)
    {
        $user = $request->user();

        // Only task owner or assigned mitra can create a dispute
        $mitraId = $task->assignment?->mitra_id;
        if ($user->id !== $task->user_id && $user->id !== $mitraId) {
            return response()->json(['success' => false, 'message' => 'Anda tidak terlibat dalam tugas ini.'], 403);
        }

        if ($task->dispute()->exists()) {
            return response()->json(['success' => false, 'message' => 'Laporan masalah sudah ada untuk tugas ini.'], 422);
        }

        $request->validate([
            'reason'      => 'required|string|max:255',
            'description' => 'required|string',
            'evidence'    => 'nullable|image|max:5120',
        ]);

        $reported_user_id = $user->id === $task->user_id
            ? $mitraId
            : $task->user_id;

        if (!$reported_user_id) {
            return response()->json(['success' => false, 'message' => 'Tidak ada pihak yang dapat dilaporkan (belum ada mitra ditugaskan).'], 422);
        }

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('disputes', 'public');
        }

        $dispute = TaskDispute::create([
            'task_id'          => $task->id,
            'reporter_id'      => $user->id,
            'reported_user_id' => $reported_user_id,
            'reason'           => $request->reason,
            'description'      => $request->description,
            'evidence_path'    => $evidencePath,
            'status'           => 'open',
        ]);

        // Notify admins and reported user
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DisputeCreatedNotification($dispute));
        }
        $dispute->reportedUser->notify(new DisputeCreatedNotification($dispute));

        \App\Models\ActivityLog::log('Dispute Created', "API: Melaporkan masalah pada tugas '{$task->title}'");

        return response()->json([
            'success' => true,
            'message' => 'Laporan masalah berhasil dikirim. Admin akan segera meninjau.',
            'data'    => $dispute->load(['task', 'reporter', 'reportedUser']),
        ], 201);
    }

    /**
     * GET /api/v1/disputes/{dispute}
     * Show a specific dispute.
     */
    public function show(Request $request, TaskDispute $dispute)
    {
        $user = $request->user();

        // Only reporter, reported, or admin can view
        if ($user->id !== $dispute->reporter_id && $user->id !== $dispute->reported_user_id && $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        $dispute->load(['task', 'reporter', 'reportedUser', 'resolver']);

        return response()->json([
            'success' => true,
            'data'    => $dispute,
        ]);
    }

    /**
     * POST /api/v1/disputes/{dispute}/respond
     * Reported user responds to a dispute.
     */
    public function respond(Request $request, TaskDispute $dispute)
    {
        $user = $request->user();

        if ($user->id !== $dispute->reported_user_id) {
            return response()->json(['success' => false, 'message' => 'Hanya pihak yang dilaporkan yang dapat merespons.'], 403);
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
            'partner_response'      => $request->partner_response,
            'partner_evidence_path' => $evidencePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tanggapan Anda berhasil dikirim.',
            'data'    => $dispute->fresh()->load(['task', 'reporter', 'reportedUser']),
        ]);
    }
}
