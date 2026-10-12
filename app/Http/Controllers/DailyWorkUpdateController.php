<?php

namespace App\Http\Controllers;

use App\Models\DailyWorkUpdate;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DailyWorkUpdateController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $updatesQuery = DailyWorkUpdate::with([
            'task',
            'employee',
        ]);

        if ($user->role !== 'manager') {
            $updatesQuery->where('employee_id', $user->id);
        }

        $updates = $updatesQuery
            ->latest('work_date')
            ->latest()
            ->get();

        return view('daily-updates.index', compact('updates'));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'employee', 403);

        $tasks = Task::where('assigned_to', auth()->id())
            ->where('status', '!=', 'completed')
            ->orderBy('title')
            ->get();

        return view('daily-updates.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'employee', 403);

        $validated = $request->validate([
            'task_id' => [
                'required',
                'integer',
                'exists:tasks,id',
            ],
            'work_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'completed_work' => [
                'required',
                'string',
                'max:5000',
            ],
            'pending_work' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'blockers' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'hours_spent' => [
                'required',
                'numeric',
                'min:0',
                'max:24',
            ],
        ]);

        // Ensure the selected task belongs to this employee.
        $task = Task::where('assigned_to', auth()->id())
            ->where('status', '!=', 'completed')
            ->findOrFail($validated['task_id']);

        DailyWorkUpdate::create([
            'task_id' => $task->id,
            'employee_id' => auth()->id(),
            'work_date' => $validated['work_date'],
            'completed_work' => $validated['completed_work'],
            'pending_work' => $validated['pending_work'] ?? null,
            'blockers' => $validated['blockers'] ?? null,
            'hours_spent' => $validated['hours_spent'],
        ]);

        return redirect()
            ->route('daily-updates.index')
            ->with('success', 'Daily work update submitted successfully!');
    }
}