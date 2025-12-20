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

Route::get('/login', function () {
  return view('welcome');
})->name('login');

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
        
        // Assign Course
        Route::get('/assign-course', [\App\Http\Controllers\Admin\AssignCourseController::class, 'index'])->name('admin.assign-course.index');
        Route::post('/assign-course/{courseId}/assign-trainer', [\App\Http\Controllers\Admin\AssignCourseController::class, 'assignTrainer'])->name('admin.assign-course.assign-trainer');
        Route::post('/assign-course/{courseId}/remove-trainer/{trainerId}', [\App\Http\Controllers\Admin\AssignCourseController::class, 'removeTrainer'])->name('admin.assign-course.remove-trainer');
        
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
        
        // Trainer Module
        Route::prefix('trainer-module')->name('admin.trainer-module.')->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'dashboard'])->name('dashboard');
            Route::get('/profile', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'profile'])->name('profile');
            Route::put('/profile', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'updateProfile'])->name('update-profile');
            Route::get('/assigned-courses', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'assignedCourses'])->name('assigned-courses');
            Route::get('/active-batches', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'activeBatches'])->name('active-batches');
            Route::get('/live-classes', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'liveClasses'])->name('live-classes');
            Route::get('/live-classes/create', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'createLiveClass'])->name('create-live-class');
            Route::post('/live-classes', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'storeLiveClass'])->name('store-live-class');
            Route::get('/live-classes/{id}/edit', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'editLiveClass'])->name('edit-live-class');
            Route::put('/live-classes/{id}', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'updateLiveClass'])->name('update-live-class');
            Route::get('/videos', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'videos'])->name('videos');
            Route::get('/videos/create', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'createVideo'])->name('create-video');
            Route::post('/videos', [\App\Http\Controllers\Admin\TrainerModuleController::class, 'storeVideo'])->name('store-video');
        });
    });
});

// Trainer Routes
Route::prefix('trainer')->group(function () {
    Route::get('/login', [TrainerAuthController::class, 'showLoginForm'])->name('trainer.login');
    Route::post('/login', [TrainerAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [TrainerAuthController::class, 'logout'])->name('trainer.logout');
    
    Route::middleware(['auth', 'role:trainer'])->group(function () {
        Route::get('/dashboard', [TrainerDashboard::class, 'index'])->name('trainer.dashboard');
        
        // Profile
        Route::get('/profile', [\App\Http\Controllers\Trainer\ProfileController::class, 'index'])->name('trainer.profile');
        Route::put('/profile', [\App\Http\Controllers\Trainer\ProfileController::class, 'update'])->name('trainer.profile.update');
        
        // Courses
        Route::get('/assigned-courses', [\App\Http\Controllers\Trainer\CourseController::class, 'index'])->name('trainer.assigned-courses');
        
        // Batches
        Route::get('/active-batches', [\App\Http\Controllers\Trainer\BatchController::class, 'index'])->name('trainer.active-batches');
        Route::get('/batches/create', [\App\Http\Controllers\Trainer\BatchController::class, 'create'])->name('trainer.batches.create');
        Route::get('/batches/{id}/edit', [\App\Http\Controllers\Trainer\BatchController::class, 'edit'])->name('trainer.batches.edit');
        Route::post('/batches', [\App\Http\Controllers\Trainer\BatchController::class, 'store'])->name('trainer.batches.store');
        Route::put('/batches/{id}', [\App\Http\Controllers\Trainer\BatchController::class, 'update'])->name('trainer.batches.update');
        
        // Live Classes
        Route::get('/live-classes', [\App\Http\Controllers\Trainer\LiveClassController::class, 'index'])->name('trainer.live-classes');
        Route::get('/live-classes/create', [\App\Http\Controllers\Trainer\LiveClassController::class, 'create'])->name('trainer.live-classes.create');
        Route::post('/live-classes', [\App\Http\Controllers\Trainer\LiveClassController::class, 'store'])->name('trainer.live-classes.store');
        Route::get('/live-classes/{encryptedId}/edit', [\App\Http\Controllers\Trainer\LiveClassController::class, 'edit'])->name('trainer.live-classes.edit');
        Route::put('/live-classes/{encryptedId}', [\App\Http\Controllers\Trainer\LiveClassController::class, 'update'])->name('trainer.live-classes.update');
        Route::get('/live-classes/{encryptedId}/join', [\App\Http\Controllers\Trainer\LiveClassController::class, 'join'])->name('trainer.live-classes.join');
        Route::post('/live-classes/{encryptedId}/start', [\App\Http\Controllers\Trainer\LiveClassController::class, 'start'])->name('trainer.live-classes.start');
        Route::post('/live-classes/{encryptedId}/end', [\App\Http\Controllers\Trainer\LiveClassController::class, 'end'])->name('trainer.live-classes.end');
        
        // Videos
        Route::get('/videos', [\App\Http\Controllers\Trainer\VideoController::class, 'index'])->name('trainer.videos');
        Route::get('/videos/create', [\App\Http\Controllers\Trainer\VideoController::class, 'create'])->name('trainer.videos.create');
        Route::post('/videos', [\App\Http\Controllers\Trainer\VideoController::class, 'store'])->name('trainer.videos.store');
        Route::get('/videos/{id}', [\App\Http\Controllers\Trainer\VideoController::class, 'show'])->name('trainer.videos.show');
        Route::get('/videos/{encryptedId}/watch', [\App\Http\Controllers\Trainer\VideoController::class, 'watch'])->name('trainer.videos.watch');
        Route::get('/videos/{id}/edit', [\App\Http\Controllers\Trainer\VideoController::class, 'edit'])->name('trainer.videos.edit');
        Route::put('/videos/{id}', [\App\Http\Controllers\Trainer\VideoController::class, 'update'])->name('trainer.videos.update');
        Route::post('/videos/playlist', [\App\Http\Controllers\Trainer\VideoController::class, 'storePlaylist'])->name('trainer.videos.playlist.store');
        
        // SkillSpace
        Route::get('/skillspace', [\App\Http\Controllers\Trainer\SkillSpaceController::class, 'index'])->name('trainer.skillspace');
        
        // Quizzes
        Route::get('/quizzes', [\App\Http\Controllers\Trainer\QuizController::class, 'index'])->name('trainer.quizzes.index');
        Route::get('/quizzes/create', [\App\Http\Controllers\Trainer\QuizController::class, 'create'])->name('trainer.quizzes.create');
        Route::get('/quizzes/{id}', [\App\Http\Controllers\Trainer\QuizController::class, 'show'])->name('trainer.quizzes.show');
        Route::get('/quizzes/{id}/edit', [\App\Http\Controllers\Trainer\QuizController::class, 'edit'])->name('trainer.quizzes.edit');
        Route::post('/quizzes', [\App\Http\Controllers\Trainer\QuizController::class, 'store'])->name('trainer.quizzes.store');
        Route::put('/quizzes/{id}', [\App\Http\Controllers\Trainer\QuizController::class, 'update'])->name('trainer.quizzes.update');
        Route::delete('/quizzes/{id}', [\App\Http\Controllers\Trainer\QuizController::class, 'destroy'])->name('trainer.quizzes.destroy');
        Route::get('/quizzes/{id}/questions', [\App\Http\Controllers\Trainer\QuizController::class, 'viewQuestions'])->name('trainer.quizzes.questions');
        Route::post('/quizzes/{id}/questions', [\App\Http\Controllers\Trainer\QuizController::class, 'addQuestion'])->name('trainer.quizzes.add-question');
        Route::delete('/quizzes/{quizId}/questions/{questionId}', [\App\Http\Controllers\Trainer\QuizController::class, 'deleteQuestion'])->name('trainer.quizzes.delete-question');
        
        // Satsangs
        Route::get('/satsangs', [\App\Http\Controllers\Trainer\SatsangController::class, 'index'])->name('trainer.satsangs.index');
        Route::get('/satsangs/create', [\App\Http\Controllers\Trainer\SatsangController::class, 'create'])->name('trainer.satsangs.create');
        Route::post('/satsangs', [\App\Http\Controllers\Trainer\SatsangController::class, 'store'])->name('trainer.satsangs.store');
        
        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Trainer\NotificationController::class, 'index'])->name('trainer.notifications.index');
        Route::get('/notifications/unread-count', [\App\Http\Controllers\Trainer\NotificationController::class, 'getUnreadCount'])->name('trainer.notifications.unread-count');
        Route::get('/notifications/recent', [\App\Http\Controllers\Trainer\NotificationController::class, 'getRecent'])->name('trainer.notifications.recent');
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Trainer\NotificationController::class, 'markAsRead'])->name('trainer.notifications.read');
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Trainer\NotificationController::class, 'markAllAsRead'])->name('trainer.notifications.mark-all-read');
    });
});

// Student Routes
Route::prefix('student')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
    
    Route::middleware(['auth', 'role:student'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');
        
        // Profile
        Route::get('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'index'])->name('student.profile');
        Route::put('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('student.profile.update');
        
        // Enroll Courses
        Route::get('/enroll-courses', [\App\Http\Controllers\Student\CourseController::class, 'index'])->name('student.enroll-courses');
        
        // Certificates
        Route::get('/certificates', [\App\Http\Controllers\Student\CourseController::class, 'certificates'])->name('student.certificates');
        Route::get('/certificates/{encryptedId}/download', [\App\Http\Controllers\Student\CourseController::class, 'downloadCertificate'])->name('student.certificates.download');
        
        // Attendance
        Route::get('/attendance', [\App\Http\Controllers\Student\CourseController::class, 'attendance'])->name('student.attendance');
        
        // Recorded Courses
        Route::get('/recorded-courses', [\App\Http\Controllers\Student\CourseController::class, 'recordedCourses'])->name('student.recorded-courses');
        Route::get('/recorded-courses/{courseId}/details', [\App\Http\Controllers\Student\CourseController::class, 'getCourseDetails'])->name('student.recorded-courses.details');
        
        // Support
        Route::get('/support', [\App\Http\Controllers\Student\CourseController::class, 'support'])->name('student.support');
        
        // Watch Video
        Route::get('/videos/{encryptedId}/watch', [\App\Http\Controllers\Student\CourseController::class, 'watchVideo'])->name('student.videos.watch');
        Route::post('/videos/{encryptedId}/mark-completed', [\App\Http\Controllers\Student\CourseController::class, 'markVideoCompleted'])->name('student.videos.mark-completed');
        
        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Student\NotificationController::class, 'index'])->name('student.notifications.index');
        Route::get('/notifications/unread-count', [\App\Http\Controllers\Student\NotificationController::class, 'getUnreadCount'])->name('student.notifications.unread-count');
        Route::get('/notifications/recent', [\App\Http\Controllers\Student\NotificationController::class, 'getRecent'])->name('student.notifications.recent');
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Student\NotificationController::class, 'markAsRead'])->name('student.notifications.read');
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Student\NotificationController::class, 'markAllAsRead'])->name('student.notifications.mark-all-read');
    });
});
