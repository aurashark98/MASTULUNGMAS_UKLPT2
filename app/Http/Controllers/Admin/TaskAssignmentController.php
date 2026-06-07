<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskAssignment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskAssignmentController extends Controller
{
    public function index()
    {
        $assignments = TaskAssignment::with('task', 'mitra')->latest()->paginate(10);
        return view('admin.task_assignments.index', compact('assignments'));
    }

    public function create()
    {
        $tasks = Task::doesntHave('assignment')->get();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.task_assignments.create', compact('tasks', 'mitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id|unique:task_assignments,task_id',
            'mitra_id' => 'required|exists:users,id',
            'assigned_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'evidence_photo' => 'nullable|image|max:2048',
        ]);

        $evidencePath = $request->hasFile('evidence_photo') ? $request->file('evidence_photo')->store('evidence', 'public') : null;

        TaskAssignment::create([
            'task_id' => $request->task_id,
            'mitra_id' => $request->mitra_id,
            'assigned_at' => $request->assigned_at ?? now(),
            'completed_at' => $request->completed_at,
            'evidence_path' => $evidencePath,
        ]);

        return redirect()->route('admin.task-assignments.index')->with('success', 'Penugasan baru berhasil ditambahkan!');
    }

    public function edit(TaskAssignment $taskAssignment)
    {
        $tasks = Task::all();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.task_assignments.edit', compact('taskAssignment', 'tasks', 'mitras'));
    }

    public function update(Request $request, TaskAssignment $taskAssignment)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id|unique:task_assignments,task_id,' . $taskAssignment->id,
            'mitra_id' => 'required|exists:users,id',
            'assigned_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'evidence_photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'task_id' => $request->task_id,
            'mitra_id' => $request->mitra_id,
            'assigned_at' => $request->assigned_at,
            'completed_at' => $request->completed_at,
        ];

        if ($request->hasFile('evidence_photo')) {
            $data['evidence_path'] = $request->file('evidence_photo')->store('evidence', 'public');
        }

        $taskAssignment->update($data);

        return redirect()->route('admin.task-assignments.index')->with('success', 'Penugasan berhasil diperbarui!');
    }

    public function destroy(TaskAssignment $taskAssignment)
    {
        $taskAssignment->delete();
        return redirect()->route('admin.task-assignments.index')->with('success', 'Penugasan berhasil dihapus!');
    }
}
