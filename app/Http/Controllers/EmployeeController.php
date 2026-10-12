<?php

namespace App\Http\Controllers;

use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        // Only managers can access this page.
        abort_unless(auth()->user()->role === 'manager', 403);

        // Fetch employees and calculate their task statistics.
        $employees = User::where('role', 'employee')
            ->withCount('assignedTasks')
            ->withCount([
                'assignedTasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'completed');
                },
                'assignedTasks as in_progress_tasks_count' => function ($query) {
                    $query->where('status', 'in_progress');
                },
            ])
            ->orderBy('name')
            ->get();

        $totalEmployees = $employees->count();

        $totalTasks = $employees->sum('assigned_tasks_count');

        $totalCompletedTasks = $employees->sum('completed_tasks_count');

        return view('employees.index', compact(
            'employees',
            'totalEmployees',
            'totalTasks',
            'totalCompletedTasks'
        ));
    }
}