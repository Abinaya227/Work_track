
@extends('layouts.app')

@section('title', 'Create Performance Review')
@section('topbar-title', 'Performance Evaluation')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold">Create Performance Review</h2>
    <p class="text-muted">
        Evaluate an employee's performance during a review period.
    </p>
</div>

<div class="card card-clean p-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($employees->isEmpty())
        <div class="alert alert-info mb-0">
            No employee accounts are available for review yet.
        </div>
    @else
        <form method="POST" action="{{ route('performance.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Select Employee *</label>
                <select name="employee_id" class="form-select" required>
                    <option value="">Choose an employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"
                            @selected(old('employee_id') == $employee->id)>
                            {{ $employee->name }} — {{ $employee->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Review Period Start *</label>
                    <input type="date"
                           name="review_period_start"
                           class="form-control"
                           max="{{ today()->format('Y-m-d') }}"
                           value="{{ old('review_period_start') }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Review Period End *</label>
                    <input type="date"
                           name="review_period_end"
                           class="form-control"
                           max="{{ today()->format('Y-m-d') }}"
                           value="{{ old('review_period_end') }}"
                           required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Performance Rating *</label>
                <select name="rating" class="form-select" required>
                    <option value="">Select a rating</option>
                    @for ($rating = 1; $rating <= 5; $rating++)
                        <option value="{{ $rating }}"
                            @selected(old('rating') == $rating)>
                            {{ $rating }} / 5
                            @if ($rating === 1)
                                — Needs Improvement
                            @elseif ($rating === 2)
                                — Below Expectations
                            @elseif ($rating === 3)
                                — Meets Expectations
                            @elseif ($rating === 4)
                                — Very Good
                            @else
                                — Excellent
                            @endif
                        </option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Manager Feedback</label>
                <textarea name="comments"
                          class="form-control"
                          rows="5"
                          maxlength="5000"
                          placeholder="Describe strengths, achievements, and areas for improvement...">{{ old('comments') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Review
            </button>

            <a href="{{ route('performance.index') }}"
               class="btn btn-outline-secondary ms-2">
                Cancel
            </a>
        </form>
    @endif
</div>
@endsection