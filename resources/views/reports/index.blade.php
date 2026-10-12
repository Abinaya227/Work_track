
@extends('layouts.app')

@section('title', 'Manager Reports')
@section('topbar-title', 'Reports & Analytics')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold">Manager Reports</h2>
    <p class="text-muted mb-0">
        Track tasks, employee progress and reported working hours.
    </p>
</div>

{{-- Summary cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card card-clean p-3 h-100">
            <div class="text-muted small">Total Tasks</div>
            <div class="fs-2 fw-bold">{{ $totalTasks }}</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card card-clean p-3 h-100">
            <div class="text-muted small">Completed</div>
            <div class="fs-2 fw-bold text-success">
                {{ $completedTasks }}
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card card-clean p-3 h-100">
            <div class="text-muted small">In Progress</div>
            <div class="fs-2 fw-bold text-primary">
                {{ $inProgressTasks }}
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card card-clean p-3 h-100">
            <div class="text-muted small">Overdue</div>
            <div class="fs-2 fw-bold text-danger">
                {{ $overdueTasks }}
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card card-clean p-3 h-100">
            <div class="text-muted small">Employees</div>
            <div class="fs-2 fw-bold">{{ $totalEmployees }}</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card card-clean p-3 h-100">
            <div class="text-muted small">Reported Hours</div>
            <div class="fs-2 fw-bold">
                {{ number_format((float) $totalHours, 2) }}
            </div>
        </div>
    </div>
</div>

{{-- Employee progress --}}
<div class="card card-clean p-3 mb-4">
    <h5 class="fw-bold mb-3">Employee Progress</h5>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Total Tasks</th>
                    <th>Completed</th>
                    <th>Completion</th>
                    <th>Hours Reported</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td>
                            <div class="fw-semibold">
                                {{ $employee->name }}
                            </div>
                            <small class="text-muted">
                                {{ $employee->email }}
                            </small>
                        </td>
                        <td>{{ $employee->total_tasks }}</td>
                        <td>{{ $employee->completed_tasks }}</td>
                        <td>
                            @php
                                $percentage = $employee->total_tasks > 0
                                    ? round(
                                        $employee->completed_tasks
                                        / $employee->total_tasks * 100
                                    )
                                    : 0;
                            @endphp

                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1"
                                     style="height: 7px; min-width: 55px;">
                                    <div class="progress-bar"
                                         role="progressbar"
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ $percentage }}%</small>
                            </div>
                        </td>
                        <td>
                            {{ number_format((float) ($employee->total_hours ?? 0), 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            No employee accounts found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Overdue tasks --}}
<div class="card card-clean p-3 mb-4">
    <h5 class="fw-bold mb-3">Overdue Tasks</h5>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Assigned Employee</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($overdueTaskList as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->employee->name ?? 'Unknown' }}</td>
                        <td>{{ $task->due_date->format('d M Y') }}</td>
                        <td>
                            <span class="badge text-bg-danger">
                                Overdue
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            No overdue tasks. Great work!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Recent work updates --}}
<div class="card card-clean p-3">
    <h5 class="fw-bold mb-3">Recent Work Updates</h5>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Task</th>
                    <th>Hours</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentUpdates as $update)
                    <tr>
                        <td>
                            {{ $update->work_date->format('d M Y') }}
                        </td>
                        <td>{{ $update->employee->name }}</td>
                        <td>{{ $update->task->title }}</td>
                        <td>{{ $update->hours_spent }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            No work updates submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection