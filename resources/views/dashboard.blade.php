@extends('layouts.app')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard Overview')

@section('content')

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                {{ $greeting }}, {{ auth()->user()->name }} 👋
            </h3>

            <p class="text-muted-custom mb-0">
                {{ $dashboardSubtitle }}
            </p>
        </div>

        @if (auth()->user()->role === 'manager')
            <a href="{{ route('tasks.create') }}" class="btn-primary-custom text-decoration-none d-inline-block">
                <i class="bi bi-plus-lg me-2"></i>
                Create New Task
            </a>
        @endif
    </div>

    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-clean p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted-custom small">Total Tasks</span>
                    <div class="stat-icon" style="background:#eef2ff;color:#4f46e5">
                        <i class="bi bi-kanban"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $totalTasks }}</div>
                <small class="text-muted-custom">
                    {{ auth()->user()->role === 'manager'
        ? 'Across all employees'
        : 'Tasks assigned to you' }}
                </small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-clean p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted-custom small">Completed</span>
                    <div class="stat-icon" style="background:#dcfce7;color:#15803d">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $completedTasks }}</div>
                <small class="text-muted-custom">Tasks marked complete</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-clean p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted-custom small">In Progress</span>
                    <div class="stat-icon" style="background:#fef3c7;color:#b45309">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $inProgressTasks }}</div>
                <small class="text-muted-custom">Currently being worked on</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-clean p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted-custom small">Overdue</span>
                    <div class="stat-icon" style="background:#fee2e2;color:#dc2626">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $overdueTasks }}</div>
                <small class="text-muted-custom">Require attention</small>
            </div>
        </div>

    </div>

    <div class="card-clean overflow-hidden">

        <div class="p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold mb-1">Recent Tasks</h5>
                <p class="text-muted-custom small mb-0">
                    Overview of recently assigned work
                </p>
            </div>

            <button class="btn btn-light border btn-sm" type="button">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned To</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recentTasks as $task)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $task->title }}</div>
                                <small class="text-muted-custom">
                                    {{ $task->description ?: 'No description' }}
                                </small>
                            </td>

                            <td>{{ $task->employee->name ?? 'Unknown' }}</td>

                            <td>
                                @php
                                    $priorityColors = [
                                        'low' => 'success',
                                        'medium' => 'warning',
                                        'high' => 'danger',
                                    ];
                                @endphp

                                <span class="badge text-bg-{{ $priorityColors[$task->priority] ?? 'secondary' }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>

                            <td>{{ $task->due_date?->format('d M Y') ?? 'Not set' }}</td>

                            <td>
                                @if ($task->status === 'completed')
                                    <span class="status-badge status-completed">Completed</span>
                                @elseif ($task->due_date && $task->due_date->lt(today()))
                                    <span class="status-badge status-overdue">Overdue</span>
                                @elseif ($task->status === 'in_progress')
                                    <span class="status-badge status-progress">In Progress</span>
                                @else
                                    <span class="status-badge status-pending">To Do</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-clipboard2 display-6 text-secondary"></i>
                                <p class="fw-semibold mt-3 mb-1">No tasks yet</p>
                                <p class="text-muted-custom mb-0">
                                    Create your first task to see it here.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 border-top text-center">
            <a href="{{ route('tasks.index') }}" class="text-decoration-none fw-semibold small" style="color:#4f46e5">
                View all tasks <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

    </div>

@endsection