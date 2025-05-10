<?php

use App\Http\Controllers\Admin\AdminAdminsController;
use App\Http\Controllers\Admin\AdminCertificateProgramsController;
use App\Http\Controllers\Admin\AdminFlaggedInternsController;
use App\Http\Controllers\Admin\AdminMentorsController;
use App\Http\Controllers\Admin\AdminOnboardingController;
use App\Http\Controllers\Admin\AdminVoucherController;
use App\Http\Controllers\Intern\InternCertificateController;
use App\Http\Controllers\Intern\InternSessionController;
use App\Http\Controllers\Intern\OnboardingController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use App\Http\Controllers\Mentor\MentorInternsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Broadcast;


use App\Http\Controllers\ChatController;
// Admin Controllers
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInternsController;
use App\Http\Controllers\Admin\ProviderController;

// Mentor + Intern Controllers

use App\Http\Controllers\Intern\InternDashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Profile routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * ========================
 * ADMIN ROUTES
 * ========================
 */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('vouchers', AdminVoucherController::class)->except(['show', 'create', 'edit']);

    // Interns 
    Route::resource('interns', AdminInternsController::class);
    Route::post('interns-import', [AdminInternsController::class, 'import'])->name('interns.import');
    Route::get('interns-export', [AdminInternsController::class, 'export'])->name('interns.export');
    Route::get('interns-print', [AdminInternsController::class, 'print'])->name('interns.print');
    Route::get('interns-template', [AdminInternsController::class, 'template'])->name('interns.template');
    Route::post('interns/{intern}/send-email', [AdminInternsController::class, 'sendEmail'])->name('interns.send-email');
    Route::resource('certificate-programs', AdminCertificateProgramsController::class)
        ->names('certificate-programs');
    Route::post('upload-image', [AdminCertificateProgramsController::class, 'uploadImage'])->name('upload-image');
    Route::post('delete-image', [AdminCertificateProgramsController::class, 'deleteImage'])->name('delete-image');


    Route::resource('onboarding', AdminOnboardingController::class);
    // Step ordering and status updates
    Route::post('onboarding/update-order', [AdminOnboardingController::class, 'updateOrder'])->name('onboarding.update-order');
    Route::post('onboarding-steps/{id}/update-status', [AdminOnboardingController::class, 'updateStepStatus'])->name('onboarding.update-status');
    Route::resource('mentors', AdminMentorsController::class);
    Route::resource('admins', AdminAdminsController::class);
    // Providers
    Route::resource('providers', ProviderController::class);

    Route::get('/flagged-interns', [AdminFlaggedInternsController::class, 'index'])->name('flagged-interns.index');
    Route::put('/flagged-interns/{id}/update-status', [AdminFlaggedInternsController::class, 'updateStatus'])->name('flagged-interns.update-status');
    
    Route::put('mentors/{mentor}/deactivate', [AdminMentorsController::class, 'deactivate'])
        ->name('mentors.deactivate');
    Route::post('mentors/{mentor}/send-email', [AdminMentorsController::class, 'sendEmail'])
        ->name('mentors.send-email');
    // Optional: If you later separate mentors, adjust this
});
/**
 * ========================
 * MENTOR ROUTES
 * ========================
 */
Route::prefix('mentor')->name('mentor.')->middleware(['auth', 'mentor'])->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/interns', [MentorDashboardController::class, 'viewAllInterns'])->name('interns.index');
    Route::get('/interns/{id}', [MentorInternsController::class, 'show'])->name('interns.show');
    Route::post('/interns/{intern}/email', [MentorInternsController::class, 'sendEmail'])->name('interns.send-email');

    
    Route::post('/interns/{intern}/nudge', [MentorInternsController::class, 'nudgeIntern'])->name('interns.nudge');
    Route::post('/interns/{intern}/flag', [MentorInternsController::class, 'flagIntern'])->name('interns.flag');
    // Course Progress
    Route::post('/course/progress', [MentorDashboardController::class, 'updateCourseProgress'])->name('course.progress');
    
    // Certificate Progress
    Route::post('/certificate/progress', [MentorDashboardController::class, 'updateCertificateProgress'])->name('certificate.progress');
    Route::post('/interns/{intern}/sessions', [MentorInternsController::class, 'storeSession'])->name('sessions.store');

    // Vouchers
    Route::get('/vouchers/available/{providerId}', [MentorDashboardController::class, 'getAvailableVouchers'])->name('vouchers.available');
    Route::post('/vouchers/assign', [MentorDashboardController::class, 'assignVoucher'])->name('vouchers.assign');
});

/**
 * ========================
 * INTERN ROUTES
 * ========================
 */
Route::prefix('intern')->name('intern.')->middleware(['auth', 'intern', 'check.onboarding'])->group(function () {
    Route::get('/dashboard', [InternDashboardController::class, 'index'])->name('dashboard');
    Route::get('/sessions', [InternSessionController::class, 'show'])->name('sessions.show');
    // Routes for certificate and course detail views
    Route::get('/certificates', [InternCertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/completed', [InternCertificateController::class, 'completedCertificates'])->name('certificates.completed');
    Route::get('/certificates/{id}', [InternCertificateController::class, 'show'])->name('certificates.show');
    Route::post('/certificates/start', [InternCertificateController::class, 'start'])->name('certificates.start');
    Route::post('/certificates/{id}/update-progress', [InternCertificateController::class, 'updateProgress'])->name('certificates.update-progress');
    Route::post('/certificates/{id}/request-voucher', [InternCertificateController::class, 'requestVoucher'])->name('certificates.request-voucher');
    Route::post('/certificates/{id}/update-course-progress', [InternCertificateController::class, 'updateCourseProgress'])->name('certificates.update-course-progress');
    Route::post('/certificates/{id}/set-exam-date', [InternCertificateController::class, 'setExamDate'])->name('certificates.set-exam-date');
    Route::get('/certificates/{id}/download', [InternCertificateController::class, 'downloadCertificate'])->name('certificates.download');
    Route::post('/certificates/toggle-favorite', [InternCertificateController::class, 'toggleCourseFavorite'])->name('certificates.toggle-favorite');
    Route::get('/certificates/achievements', [InternCertificateController::class, 'achievements'])->name('certificates.achievements');

});
Route::middleware(['auth', 'intern'])->prefix('intern')->name('intern.')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding/complete-step', [OnboardingController::class, 'completeStep'])->name('onboarding.complete-step');
    Route::post('/onboarding/skip-step', [OnboardingController::class, 'skipStep'])->name('onboarding.skip-step');
    Route::get('/onboarding/finalize', [OnboardingController::class, 'finalize'])->name('onboarding.finalize');
});



/*
|--------------------------------------------------------------------------
| Chat System Routes
|--------------------------------------------------------------------------
*/

// Main chat interface
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Chat interface using Inertia
    Route::get('/chat', [ChatController::class, 'index'])
         ->name('chat.index')
         ->middleware('web'); // Apply the Inertia middleware

    // Conversations API
    Route::post('/chat/conversations', [ChatController::class, 'getOrCreateConversation'])
         ->name('chat.conversations.create');
    
    Route::get('/chat/conversations/{id}/messages', [ChatController::class, 'getMessages'])
         ->name('chat.conversations.messages');
    
    Route::post('/chat/conversations/read', [ChatController::class, 'markAsRead'])
         ->name('chat.conversations.read');

    // Messages API
    Route::post('/chat/messages', [ChatController::class, 'sendMessage'])
         ->name('chat.messages.send');
    
    Route::delete('/chat/messages/{id}', [ChatController::class, 'deleteMessage'])
         ->name('chat.messages.delete');

    // Attachments
    Route::get('/chat/attachments/{id}/download', [ChatController::class, 'downloadAttachment'])
         ->name('chat.attachments.download');
         Route::post('/chat/heartbeat', [ChatController::class, 'heartbeat'])->name('chat.heartbeat');

    // User Status
    Route::post('/chat/status', [ChatController::class, 'updateStatus'])
         ->name('chat.status.update');
});

// Pusher Authentication
Route::post('/broadcasting/auth', function (Request $request) {
    return Broadcast::auth($request);
})->middleware(['web', 'auth:sanctum']);
/**
 * ========================
 * ERROR + FALLBACK ROUTES
 * ========================
 */
Route::get('/error/404', fn() => response()->view('errors.error404', [], 404))->name('error.404');
Route::get('/error/500', fn() => response()->view('errors.error500', [], 500))->name('error.500');
Route::get('/error/403', fn() => response()->view('errors.error403', [], 403))->name('error.403');

Route::fallback(fn() => redirect()->route('error.404'));

Broadcast::routes();

require __DIR__ . '/auth.php';