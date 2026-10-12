@extends('layouts.app')

@section('title', 'All Tasks')
@section('topbar-title', 'Task Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">All Tasks</h4>
            <p class="text-muted-custom mb-0">
                Track assigned work and deadlines.
            </p>
        </div>


        @if (auth()->user()->role === 'manager')
            <a href="{{ route('tasks.create') }}" class="btn-primary-custom text-decoration-none">
                <i class="bi bi-plus-lg me-1"></i>
                Create Task
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-clean overflow-hidden">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned Employee</th>
                        <th>Priority</th>
                        <th>Update Status</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td>
                                <div class="fw-semibold">
                                    {{ $task->title }}
                                </div>
                                <small class="text-muted-custom">
                                    {{ $task->description ?: 'No description' }}
                                </small>
                            </td>

                            <td>
                                {{ $task->employee->name ?? 'Unknown' }}
                            </td>

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

                            <td>
                                <form method="POST" action="{{ route('tasks.update-status', $task) }}">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" class="form-select form-select-sm mb-2" aria-label="Task status">
                                        <option value="todo" @selected($task->status === 'todo')>
                                            To Do
                                        </option>

                                        <option value="in_progress" @selected($task->status === 'in_progress')>
                                            In Progress
                                        </option>

                                        <option value="completed" @selected($task->status === 'completed')>
                                            Completed
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Save
                                    </button>
                                </form>
                            </td>

                            <td>
                                @if ($task->status === 'completed')
                                    <span class="status-badge status-completed">
                                        Completed
                                    </span>
                                @elseif ($task->due_date && $task->due_date->isPast())
                                    <span class="status-badge status-overdue">
                                        Overdue
                                    </span>
                                @elseif ($task->status === 'in_progress')
                                    <span class="status-badge status-progress">
                                        In Progress
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        To Do
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $task->due_date?->format('d M Y') ?? 'Not set' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-clipboard2 display-6 text-secondary"></i>
                                <p class="fw-semibold mt-3 mb-1">No tasks yet</p>
                                <p class="text-muted-custom mb-0">
                                    Tasks will appear here once they are assigned.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection