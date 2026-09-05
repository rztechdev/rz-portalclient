<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TechnicianTicketController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Api\InternalSyncController;
use App\Http\Controllers\NotificationController;

// Internal API: Synchronize Client & Project from RZ CRM
Route::post('/api/internal/v1/sync-client-project', [InternalSyncController::class, 'syncClientProject'])
    ->name('api.internal.sync-client-project');

// Internal API: Fetch subscription status for CRM
Route::get('/api/internal/v1/subscription-status/{project}', [InternalSyncController::class, 'subscriptionStatus'])
    ->name('api.internal.subscription-status');

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
    Route::delete('/notifications-clear', [NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');
    Route::delete('/notifications-clear-read', [NotificationController::class, 'destroyRead'])->name('notifications.destroy-read');

    // Client Portal Routes (buat tiket)
    Route::middleware('permission:tickets.create')->group(function () {
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    });

    // Technician Portal Routes (menangani tiket)
    Route::middleware('permission:tickets.handle')->group(function () {
        Route::get('/technician/tickets', [TechnicianTicketController::class, 'index'])->name('technician.tickets');
    });

    // Kelola Tiket (admin inbox)
    Route::middleware('permission:tickets.manage')->group(function () {
        Route::get('/admin/tickets', [App\Http\Controllers\AdminTicketController::class, 'index'])->name('admin.tickets');
    });

    // Kelola Proyek
    Route::middleware('permission:projects.manage')->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });

    // Kelola Tugas
    Route::middleware('permission:tasks.manage')->group(function () {
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // Panel Admin — Manajemen Akses (Pengguna & Role)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('permission:users.manage')->group(function () {
            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::get('users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('users', [UserController::class, 'store'])->name('users.store');
            Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        Route::middleware('permission:roles.manage')->group(function () {
            Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
            Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
            Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        });
    });

    // Project & Task Read-only Access (Authenticated Users)
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

    // Update Task Progress Route (Kanban & Quick Move)
    Route::patch('/tasks/{task}/progress', [TaskController::class, 'updateProgress'])
        ->name('tasks.progress');

    // Document Management
    Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Invoices & Billing Area
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('invoices/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.download-pdf');
    Route::get('invoices/{invoice}/settlement-pdf', [InvoiceController::class, 'settlementPdf'])->name('invoices.settlement-pdf');
    Route::get('invoices/{invoice}/receipt', [InvoiceController::class, 'receipt'])->name('invoices.receipt');
    Route::get('invoices/{invoice}/download-receipt', [InvoiceController::class, 'downloadReceipt'])->name('invoices.download-receipt');
    Route::post('invoices/{invoice}/upload-proof', [InvoiceController::class, 'uploadPaymentProof'])->name('invoices.upload-proof');
    Route::post('invoices/{invoice}/verify', [InvoiceController::class, 'verifyPayment'])->name('invoices.verify');
});

require __DIR__.'/auth.php';
