
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Employees</h3>
            <p class="text-muted mb-0">
                View employee details and task progress.
            </p>
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card card-clean h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Employees</p>
                    <h3 class="fw-bold">{{ $totalEmployees }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-clean h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Assigned Tasks</p>
                    <h3 class="fw-bold">{{ $totalTasks }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-clean h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Completed Tasks</p>
                    <h3 class="fw-bold">{{ $totalCompletedTasks }}</h3>
                </div>
            </div>
        </div>

    </div>

    {{-- Employee table --}}
    <div class="card card-clean">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Employee Directory</h5>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Email</th>
                            <th>Total Tasks</th>
                            <th>Completed</th>
                            <th>In Progress</th>
                            <th>Pending</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $employee->name }}
                                </td>

                                <td>{{ $employee->email }}</td>

                                <td>
                                    {{ $employee->assigned_tasks_count }}
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        {{ $employee->completed_tasks_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $employee->in_progress_tasks_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ $employee->assigned_tasks_count
                                            - $employee->completed_tasks_count
                                            - $employee->in_progress_tasks_count }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="text-center text-muted py-4">
                                    No employees found.
                                    Create employee accounts to see them here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection