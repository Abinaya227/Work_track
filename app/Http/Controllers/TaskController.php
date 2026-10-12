<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;


class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'manager') {
            $tasks = Task::with('employee')
                ->latest()
                ->get();
        } else {
            $tasks = Task::with('employee')
                ->where('assigned_to', $user->id)
                ->latest()
                ->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'manager', 403);

        $employees = User::where('role', 'employee')
            ->orderBy('name')
            ->get();

        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'manager', 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'priority' => [
                'required',
                'in:low,medium,high',
            ],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $employee = User::where('role', 'employee')
            ->findOrFail($validated['assigned_to']);

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'assigned_to' => $employee->id,
            'created_by' => auth()->id(),
            'priority' => $validated['priority'],
            'status' => 'todo',
            'start_date' => $validated['start_date'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task assigned successfully!');
    }


    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => ['required', 'in:todo,in_progress,completed'],
        ]);

        $user = auth()->user();

        // Employees can update only their assigned tasks.
        if (
            $user->role !== 'manager' &&
            $task->assigned_to !== $user->id
        ) {
            abort(403);
        }

        $newStatus = $request->input('status');

        $task->status = $newStatus;
        $task->completed_at = $newStatus === 'completed'
            ? now()
            : null;

        $task->save();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task status updated successfully!');
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Managers see all tasks; employees see their assigned tasks.
        $tasksQuery = Task::query();

        if ($user->role !== 'manager') {
            $tasksQuery->where('assigned_to', $user->id);
        }

        // Calculate real task counts.
        $totalTasks = (clone $tasksQuery)->count();

        $completedTasks = (clone $tasksQuery)
            ->where('status', 'completed')
            ->count();

        $inProgressTasks = (clone $tasksQuery)
            ->where('status', 'in_progress')
            ->count();

        $overdueTasks = (clone $tasksQuery)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', today())
            ->count();

        // Load the latest five tasks.
        $recentTasks = (clone $tasksQuery)
            ->with('employee')
            ->latest()
            ->take(5)
            ->get();

        // Dynamic greeting based on the current time.
        $hour = now()->hour;

        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 17) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }

        $dashboardSubtitle = $user->role === 'manager'
            ? "Here's what's happening with your team today."
            : "Here's an overview of your assigned work today.";

        return view('dashboard', compact(
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'overdueTasks',
            'recentTasks',
            'greeting',
            'dashboardSubtitle'
        ));
    }
}
