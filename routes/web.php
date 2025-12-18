<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\TrainerAuthController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboard;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;

// Home/Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        
        // Student Enroll
        Route::get('/student-enroll', [\App\Http\Controllers\Admin\StudentEnrollController::class, 'index'])->name('admin.student-enroll.index');
        Route::put('/student-enroll/{id}/toggle-status', [\App\Http\Controllers\Admin\StudentEnrollController::class, 'toggleStatus'])->name('admin.student-enroll.toggle-status');
        
        // Courses
        Route::get('/courses', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('admin.courses.index');
        Route::get('/courses/create', [\App\Http\Controllers\Admin\CourseController::class, 'create'])->name('admin.courses.create');
        Route::post('/courses', [\App\Http\Controllers\Admin\CourseController::class, 'store'])->name('admin.courses.store');
        Route::put('/courses/{id}/toggle-status', [\App\Http\Controllers\Admin\CourseController::class, 'toggleStatus'])->name('admin.courses.toggle-status');
        
        // Instructors
        Route::get('/instructors', [\App\Http\Controllers\Admin\InstructorController::class, 'index'])->name('admin.instructors.index');
        Route::get('/instructors/create', [\App\Http\Controllers\Admin\InstructorController::class, 'create'])->name('admin.instructors.create');
        Route::post('/instructors', [\App\Http\Controllers\Admin\InstructorController::class, 'store'])->name('admin.instructors.store');
        Route::get('/instructors/{id}/edit', [\App\Http\Controllers\Admin\InstructorController::class, 'edit'])->name('admin.instructors.edit');
        Route::put('/instructors/{id}', [\App\Http\Controllers\Admin\InstructorController::class, 'update'])->name('admin.instructors.update');
        Route::put('/instructors/{id}/toggle-status', [\App\Http\Controllers\Admin\InstructorController::class, 'toggleStatus'])->name('admin.instructors.toggle-status');
        
        // Hiring Portal
        Route::get('/hiring', [\App\Http\Controllers\Admin\HiringController::class, 'index'])->name('admin.hiring.index');
        Route::get('/hiring/create', [\App\Http\Controllers\Admin\HiringController::class, 'create'])->name('admin.hiring.create');
        Route::post('/hiring', [\App\Http\Controllers\Admin\HiringController::class, 'store'])->name('admin.hiring.store');
        Route::delete('/hiring/{id}', [\App\Http\Controllers\Admin\HiringController::class, 'destroy'])->name('admin.hiring.destroy');
        
        // Community Queries
        Route::get('/community-queries', [\App\Http\Controllers\Admin\CommunityQueryController::class, 'index'])->name('admin.community-queries.index');
        Route::post('/community-queries/{id}/assign', [\App\Http\Controllers\Admin\CommunityQueryController::class, 'assignTrainer'])->name('admin.community-queries.assign');
        Route::post('/community-queries/{id}/reply', [\App\Http\Controllers\Admin\CommunityQueryController::class, 'reply'])->name('admin.community-queries.reply');
        Route::post('/community-queries/{id}/close', [\App\Http\Controllers\Admin\CommunityQueryController::class, 'close'])->name('admin.community-queries.close');
        
        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
        
        // Profile
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile.index');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
        
        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index');
        Route::get('/notifications/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('admin.notifications.show');
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('admin.notifications.read');
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
        Route::get('/notifications/unread-count', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->name('admin.notifications.unread-count');
        Route::get('/notifications/recent', [\App\Http\Controllers\Admin\NotificationController::class, 'getRecent'])->name('admin.notifications.recent');
        
        // Activity Logs
        Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
    });
});

// Trainer Routes
Route::prefix('trainer')->group(function () {
    Route::get('/login', [TrainerAuthController::class, 'showLoginForm'])->name('trainer.login');
    Route::post('/login', [TrainerAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [TrainerAuthController::class, 'logout'])->name('trainer.logout');
    
    Route::middleware(['auth', 'role:trainer'])->group(function () {
        Route::get('/dashboard', [TrainerDashboard::class, 'index'])->name('trainer.dashboard');
    });
});

// Student Routes
Route::prefix('student')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
    
    Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');
    });
});
