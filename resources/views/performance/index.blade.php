
@extends('layouts.app')

@section('title', 'Performance Reviews')
@section('topbar-title', 'Performance Evaluation')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Performance Reviews</h2>
        <p class="text-muted mb-0">
            Review employee performance and feedback.
        </p>
    </div>

    @if (auth()->user()->role === 'manager')
        <a href="{{ route('performance.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Create Review
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
                    <th>Employee</th>
                    <th>Review Period</th>
                    <th>Rating</th>
                    <th>Manager</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr>
                        <td class="fw-semibold">
                            {{ $review->employee->name }}
                        </td>
                        <td>
                            {{ $review->review_period_start->format('d M Y') }}
                            –
                            {{ $review->review_period_end->format('d M Y') }}
                        </td>
                        <td>
                            <span class="badge text-bg-primary">
                                {{ $review->rating }} / 5
                            </span>
                        </td>
                        <td>{{ $review->manager->name }}</td>
                        <td>
                            {{ $review->comments ?: 'No feedback provided' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            No performance reviews found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection