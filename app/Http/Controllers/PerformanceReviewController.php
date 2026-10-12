<?php

namespace App\Http\Controllers;

use App\Models\PerformanceReview;
use App\Models\User;
use Illuminate\Http\Request;

class PerformanceReviewController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $reviewsQuery = PerformanceReview::with([
            'employee',
            'manager',
        ]);

        // Employees can see only their own reviews.
        if ($user->role !== 'manager') {
            $reviewsQuery->where('employee_id', $user->id);
        }

        $reviews = $reviewsQuery
            ->latest('review_period_end')
            ->get();

        return view('performance.index', compact('reviews'));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'manager', 403);

        $employees = User::where('role', 'employee')
            ->orderBy('name')
            ->get();

        return view('performance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'manager', 403);

        $validated = $request->validate([
            'employee_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'review_period_start' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'review_period_end' => [
                'required',
                'date',
                'after_or_equal:review_period_start',
                'before_or_equal:today',
            ],
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],
            'comments' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        // Ensure the selected user is an employee.
        $employee = User::where('role', 'employee')
            ->findOrFail($validated['employee_id']);

        PerformanceReview::create([
            'employee_id' => $employee->id,
            'manager_id' => auth()->id(),
            'review_period_start' => $validated['review_period_start'],
            'review_period_end' => $validated['review_period_end'],
            'rating' => $validated['rating'],
            'comments' => $validated['comments'] ?? null,
        ]);

        return redirect()
            ->route('performance.index')
            ->with('success', 'Performance review saved successfully!');
    }
}