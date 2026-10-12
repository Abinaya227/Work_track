<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DailyWorkUpdateController;
use App\Http\Controllers\PerformanceReviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmployeeController;
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [TaskController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/tasks', [TaskController::class, 'index'])
        ->name('tasks.index');

    Route::get('/tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::post('/tasks', [TaskController::class, 'store'])
        ->name('tasks.store');
    Route::patch('/tasks/{task}/status', [
        TaskController::class,
        'updateStatus',
    ])->name('tasks.update-status');
    Route::get('/daily-updates', [
        DailyWorkUpdateController::class,
        'index',
    ])->name('daily-updates.index');

    Route::get('/daily-updates/create', [
        DailyWorkUpdateController::class,
        'create',
    ])->name('daily-updates.create');

    Route::post('/daily-updates', [
        DailyWorkUpdateController::class,
        'store',
    ])->name('daily-updates.store');
    Route::get('/performance', [
        PerformanceReviewController::class,
        'index',
    ])->name('performance.index');

    Route::get('/performance/create', [
        PerformanceReviewController::class,
        'create',
    ])->name('performance.create');

    Route::post('/performance', [
        PerformanceReviewController::class,
        'store',
    ])->name('performance.store');
    Route::get('/reports', [
        ReportController::class,
        'index',
    ])->name('reports.index');
    Route::get('/employees', [EmployeeController::class, 'index'])
    ->name('employees.index');
});