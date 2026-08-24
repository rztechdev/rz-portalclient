<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TechnicianTicketController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/kpi-data', [DashboardController::class, 'getKpiData'])->name('api.kpi-data');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notification API
    Route::get('/notifications', function () {
        return response()->json(auth()->user()->unreadNotifications);
    });
    Route::post('/notifications/{id}/read', function ($id) {
        auth()->user()->notifications()->where('id', $id)->first()?->markAsRead();
        return response()->json(['success' => true]);
    });

    // Client Portal Routes
    Route::middleware('role:client')->group(function () {
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    });

    // Technician Portal Routes
    Route::middleware('role:technician|admin')->group(function () {
        Route::get('/technician/tickets', [TechnicianTicketController::class, 'index'])->name('technician.tickets');
    });

    // Admin Portal Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/tickets', [App\Http\Controllers\AdminTicketController::class, 'index'])->name('admin.tickets');
        
        // Project Management CRUD (Admin Only)
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        // Task CRUD (Admin Only)
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // Project & Task Read-only Access (Authenticated Users)
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

    // Technician Update Progress Route
    Route::patch('/tasks/{task}/progress', [TaskController::class, 'updateProgress'])->name('tasks.progress');

    // Document Management
    Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});

require __DIR__.'/auth.php';
