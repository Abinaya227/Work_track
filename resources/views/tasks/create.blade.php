
@extends('layouts.app')

@section('title', 'Create Task')
@section('topbar-title', 'Assign a New Task')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Create Task</h4>
        <p class="text-muted-custom mb-0">
            Assign work and set a deadline.
        </p>
    </div>

    <a href="{{ route('tasks.index') }}"
       class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Tasks
    </a>
</div>

<div class="card-clean p-4" style="max-width: 850px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">
                Task Title *
            </label>
            <input type="text" id="title" name="title"
                   class="form-control" value="{{ old('title') }}"
                   placeholder="e.g. Develop employee dashboard"
                   maxlength="255" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">
                Description
            </label>
            <textarea id="description" name="description"
                      class="form-control" rows="4"
                      placeholder="Describe the expected work...">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label fw-semibold">
                Assign to Employee *
            </label>
            <select id="assigned_to" name="assigned_to"
                    class="form-select" required>
                <option value="">Select an employee</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}"
                        @selected(old('assigned_to') == $employee->id)>
                        {{ $employee->name }} — {{ $employee->email }}
                    </option>
                @endforeach
            </select>

            @if ($employees->isEmpty())
                <small class="text-danger">
                    No employees found. Create an employee account first.
                </small>
            @endif
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="priority" class="form-label fw-semibold">
                    Priority *
                </label>
                <select id="priority" name="priority"
                        class="form-select" required>
                    <option value="low"
                        @selected(old('priority') === 'low')>Low</option>
                    <option value="medium"
                        @selected(old('priority', 'medium') === 'medium')>
                        Medium
                    </option>
                    <option value="high"
                        @selected(old('priority') === 'high')>High</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label fw-semibold">
                    Start Date
                </label>
                <input type="date" id="start_date" name="start_date"
                       class="form-control" value="{{ old('start_date') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="due_date" class="form-label fw-semibold">
                    Due Date
                </label>
                <input type="date" id="due_date" name="due_date"
                       class="form-control" value="{{ old('due_date') }}">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('tasks.index') }}"
               class="btn btn-light">Cancel</a>

            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-plus-circle me-1"></i>
                Assign Task
            </button>
        </div>
    </form>
</div>
@endsection