<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\EnrollmentController as StudentEnrollmentController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\SummaryController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\EnrollmentController as TeacherEnrollmentController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Teacher\AnnouncementController as TeacherAnnouncementController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\FileController;


Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (!auth()->check()) return redirect()->route('login');
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : (auth()->user()->role === 'teacher'
            ? redirect()->route('teacher.dashboard')
            : redirect()->route('student.dashboard'));
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
    
    // Original enrollment route (for backward compatibility)
    Route::get('/enrollment', [StudentEnrollmentController::class, 'create'])->name('enrollment.create');
    Route::post('/enrollment', [StudentEnrollmentController::class, 'store'])->name('enrollment.store');
    
    // Separate SHS and JHS enrollment routes
    Route::get('/enrollment/shs', [StudentEnrollmentController::class, 'createSHS'])->name('enrollment.shs.create');
    Route::post('/enrollment/shs', [StudentEnrollmentController::class, 'storeSHS'])->name('enrollment.shs.store');
    Route::get('/enrollment/jhs', [StudentEnrollmentController::class, 'createJHS'])->name('enrollment.jhs.create');
    Route::post('/enrollment/jhs', [StudentEnrollmentController::class, 'storeJHS'])->name('enrollment.jhs.store');
    
    // Document management routes
    Route::get('/documents', [App\Http\Controllers\Student\DocumentController::class, 'index'])->name('documents.index');
    Route::get('/announcements', [App\Http\Controllers\Student\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/documents/upload', [App\Http\Controllers\Student\DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/{id}/download', [App\Http\Controllers\Student\DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{id}', [App\Http\Controllers\Student\DocumentController::class, 'delete'])->name('documents.delete');

    // Notification routes
    Route::get('/notifications', [App\Http\Controllers\Student\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [App\Http\Controllers\Student\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::patch('/notifications/mark-all-read', [App\Http\Controllers\Student\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [App\Http\Controllers\Student\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/summary', [SummaryController::class, 'index'])->name('summary');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::get('/students/{id}/documents', [AdminStudentController::class, 'documents'])->name('students.documents');
    Route::patch('/students/{id}/approve', [AdminStudentController::class, 'approve'])->name('students.approve');
    Route::patch('/students/{id}/reject', [AdminStudentController::class, 'reject'])->name('students.reject');
    Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/enrollments/{enrollment}/approve', [AdminEnrollmentController::class, 'approve'])->name('enrollments.approve');
    Route::post('/enrollments/{enrollment}/reject', [AdminEnrollmentController::class, 'reject'])->name('enrollments.reject');
    
    // Enhanced reporting and monitoring routes
    Route::get('/reports', [AdminReportController::class, 'dashboard'])->name('reports.dashboard');
    Route::get('/reports/enhanced', [App\Http\Controllers\Admin\EnhancedReportController::class, 'dashboard'])->name('reports.enhanced');
    Route::get('/reports/enrollment', [App\Http\Controllers\Admin\EnhancedReportController::class, 'enrollmentReport'])->name('reports.enrollment-report');
    Route::get('/reports/system-monitoring', [App\Http\Controllers\Admin\EnhancedReportController::class, 'systemMonitoring'])->name('reports.system-monitoring');
    
    Route::resource('announcements', AdminAnnouncementController::class);
    Route::patch('/announcements/{announcement}/toggle', [AdminAnnouncementController::class, 'toggle'])->name('announcements.toggle');
    Route::patch('/documents/{document}/verify', [App\Http\Controllers\Admin\DocumentVerificationController::class, 'update'])->name('documents.verify');
    Route::resource('teachers', AdminTeacherController::class);
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
    Route::get('/enrollments', [TeacherEnrollmentController::class, 'index'])->name('enrollments.index');
    Route::patch('/enrollments/{enrollment}/approve', [TeacherEnrollmentController::class, 'approve'])->name('enrollments.approve');
    Route::patch('/enrollments/{enrollment}/reject', [TeacherEnrollmentController::class, 'reject'])->name('enrollments.reject');
    Route::resource('announcements', TeacherAnnouncementController::class);
    Route::patch('/documents/{document}/verify', [App\Http\Controllers\Teacher\DocumentVerificationController::class, 'update'])->name('documents.verify');
    
    // Enhanced student management routes
    Route::get('/students', [App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [App\Http\Controllers\Teacher\StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{id}/academic-record', [App\Http\Controllers\Teacher\StudentController::class, 'academicRecord'])->name('students.academic-record');
    Route::get('/students/{id}/documents', [App\Http\Controllers\Teacher\StudentController::class, 'documents'])->name('students.documents');
    Route::patch('/students/{id}/verify-academic-standing', [App\Http\Controllers\Teacher\StudentController::class, 'verifyAcademicStanding'])->name('students.verify-academic-standing');
    Route::get('/students/export', [App\Http\Controllers\Teacher\StudentController::class, 'exportStudentList'])->name('students.export');
    
    Route::get('/classes', [App\Http\Controllers\Teacher\ClassController::class, 'index'])->name('classes.index');
    Route::get('/attendance', function() { return view('teacher.attendance.index'); })->name('attendance.index');
    Route::get('/grades', function() { return view('teacher.grades.index'); })->name('grades.index');
    Route::get('/reports', function() { return view('teacher.reports.index'); })->name('reports.index');
});

Route::middleware(['auth'])->get('/files/public/{path}', [FileController::class, 'public'])
    ->where('path', '.*')
    ->name('files.public');

require __DIR__.'/auth.php';
