<?php

namespace App\Http\Controllers;

use App\Models\DailyWorkUpdate;
use App\Models\Task;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // Reports are available to managers only.
        abort_unless(auth()->user()->role === 'manager', 403);

        $totalTasks = Task::count();

        $completedTasks = Task::where(
            'status',
            'completed'
        )->count();

        $inProgressTasks = Task::where(
            'status',
            'in_progress'
        )->count();

        $overdueTasks = Task::where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', today())
            ->count();

        $totalEmployees = User::where(
            'role',
            'employee'
        )->count();

        $totalHours = DailyWorkUpdate::sum('hours_spent');

        $employees = User::where('role', 'employee')
            ->withCount([
                'assignedTasks as total_tasks',
                'assignedTasks as completed_tasks' => function ($query) {
                    $query->where('status', 'completed');
                },
            ])
            ->withSum('dailyWorkUpdates as total_hours', 'hours_spent')
            ->orderBy('name')
            ->get();

        $overdueTaskList = Task::with('employee')
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', today())
            ->orderBy('due_date')
            ->get();

        $recentUpdates = DailyWorkUpdate::with([
            'employee',
            'task',
        ])
            ->latest('work_date')
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'overdueTasks',
            'totalEmployees',
            'totalHours',
            'employees',
            'overdueTaskList',
            'recentUpdates'
        ));
    }
}