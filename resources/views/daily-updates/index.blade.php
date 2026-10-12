
@extends('layouts.app')

@section('title', 'Daily Work Updates')
@section('topbar-title', 'Daily Work Updates')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Daily Work Updates</h2>
        <p class="text-muted mb-0">
            Review employee progress and completed work.
        </p>
    </div>

    @if (auth()->user()->role === 'employee')
        <a href="{{ route('daily-updates.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Submit Update
        </a>
    @endif
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card card-clean p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Work Date</th>
                    <th>Employee</th>
                    <th>Task</th>
                    <th>Completed Work</th>
                    <th>Pending Work</th>
                    <th>Hours</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($updates as $update)
                    <tr>
                        <td>
                            {{ $update->work_date->format('d M Y') }}
                        </td>
                        <td>{{ $update->employee->name }}</td>
                        <td>{{ $update->task->title }}</td>
                        <td>
                            {{ \Illuminate\Support\Str::limit($update->completed_work, 80) }}
                        </td>
                        <td>
                            {{ $update->pending_work
                                ? \Illuminate\Support\Str::limit($update->pending_work, 60)
                                : '—' }}
                        </td>
                        <td>{{ $update->hours_spent }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No daily work updates have been submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection