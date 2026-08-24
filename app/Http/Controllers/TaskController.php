<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Services\TicketWorkflowService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $users = User::role(['admin', 'technician'])->get();
        return view('tasks.create', compact('project', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:todo,in_progress,review,done',
            'priority'    => 'required|in:low,medium,high',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date'    => 'nullable|date',
        ]);

        $task = Task::create($request->only(['project_id','name','description','status','priority','assignee_id','due_date']));

        if ($task->assignee_id) {
            app(TicketWorkflowService::class)->notifyTaskAssigned($task);
        }

        return redirect()->route('projects.show', $request->project_id)->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show(Task $task)
    {
        $user = auth()->user();
        if ($user->hasRole('ceo')) {
            // CEO: read-only access to all tasks
        } elseif ($user->hasRole('client') && $task->project->client_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses tugas ini.');
        } elseif ($user->hasRole('technician') && $task->assignee_id !== $user->id && $task->project->manager_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses tugas ini.');
        }

        $task->load(['project', 'assignee', 'documents.uploader']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = User::role(['admin', 'technician'])->get();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:todo,in_progress,review,done',
            'priority'    => 'required|in:low,medium,high',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date'    => 'nullable|date',
        ]);

        $previousAssigneeId = $task->assignee_id;

        $task->update($request->only(['name','description','status','priority','assignee_id','due_date']));

        if ($task->assignee_id && $task->assignee_id !== $previousAssigneeId) {
            app(TicketWorkflowService::class)->notifyTaskAssigned($task->fresh(), $previousAssigneeId !== null);
        }

        return redirect()->route('projects.show', $task->project_id)->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();
        return redirect()->route('projects.show', $projectId)->with('success', 'Tugas berhasil dihapus.');
    }

    /**
     * Update task progress status (technician action).
     */
    public function updateProgress(Request $request, Task $task)
    {
        $user = auth()->user();
        if ($task->assignee_id !== $user->id && $task->project->manager_id !== $user->id && !$user->hasRole('admin')) {
            abort(403, 'Anda hanya dapat memperbarui progress tugas yang ditugaskan kepada Anda.');
        }

        $request->validate([
            'status' => 'required|in:todo,in_progress,review,done',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Progress tugas berhasil diperbarui.');
    }
}
