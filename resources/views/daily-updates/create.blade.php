
@extends('layouts.app')

@section('title', 'Submit Daily Update')
@section('topbar-title', 'Daily Work Update')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <h2 class="fw-bold">Submit Daily Update</h2>
        <p class="text-muted">
            Record the work you completed today.
        </p>
    </div>

    <div class="card card-clean p-4">
        @if ($tasks->isEmpty())
            <div class="alert alert-info mb-0">
                You have no open assigned tasks available for updates.
            </div>
        @else
            <form method="POST"
                  action="{{ route('daily-updates.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Assigned Task *</label>
                    <select name="task_id" class="form-select" required>
                        <option value="">Select a task</option>
                        @foreach ($tasks as $task)
                            <option value="{{ $task->id }}"
                                @selected(old('task_id') == $task->id)>
                                {{ $task->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('task_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Work Date *</label>
                    <input type="date"
                           name="work_date"
                           class="form-control"
                           max="{{ today()->format('Y-m-d') }}"
                           value="{{ old('work_date', today()->format('Y-m-d')) }}"
                           required>
                    @error('work_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Completed Work *</label>
                    <textarea name="completed_work"
                              class="form-control"
                              rows="4"
                              required
                              placeholder="Describe the work you completed...">{{ old('completed_work') }}</textarea>
                    @error('completed_work')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pending Work</label>
                    <textarea name="pending_work"
                              class="form-control"
                              rows="3"
                              placeholder="What work is still pending?">{{ old('pending_work') }}</textarea>
                    @error('pending_work')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Blockers</label>
                    <textarea name="blockers"
                              class="form-control"
                              rows="2"
                              placeholder="Any issue blocking your progress?">{{ old('blockers') }}</textarea>
                    @error('blockers')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Hours Spent *</label>
                    <input type="number"
                           name="hours_spent"
                           class="form-control"
                           min="0"
                           max="24"
                           step="0.25"
                           value="{{ old('hours_spent', '0') }}"
                           required>
                    @error('hours_spent')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Submit Update
                </button>

                <a href="{{ route('daily-updates.index') }}"
                   class="btn btn-outline-secondary ms-2">
                    Cancel
                </a>
            </form>
        @endif
    </div>
</div>
@endsection