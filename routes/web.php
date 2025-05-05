<?php

use App\Http\Controllers\Admin\AdminAdminsController;
use App\Http\Controllers\Admin\AdminCertificateProgramsController;
use App\Http\Controllers\Admin\AdminMentorsController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInternsController;
use App\Http\Controllers\Admin\InternCertificateController;
use App\Http\Controllers\Admin\ProgressUpdateController;
use App\Http\Controllers\Admin\OnboardingStepController;
use App\Http\Controllers\Admin\CertificateProgramController;
use App\Http\Controllers\Admin\ProviderController;

// Mentor + Intern Controllers
use App\Http\Controllers\Mentor\MentorController;
use App\Http\Controllers\Mintor\MintorDashboardController;
use App\Http\Controllers\Intern\InternDashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    



    Route::resource('mentors', AdminMentorsController::class);
    Route::resource('admins', AdminAdminsController::class);
    // Providers
    Route::resource('providers', ProviderController::class);



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
    Route::get('/interns', [MentorController::class, 'interns'])->name('interns');
    Route::get('/interns/{intern}', [MentorController::class, 'showIntern'])->name('interns.show');
    Route::post('/progress-updates', [MentorController::class, 'storeProgressUpdate'])->name('progress-updates.store');
});

/**
 * ========================
 * INTERN ROUTES
 * ========================
 */
Route::prefix('intern')->name('intern.')->middleware(['auth', 'intern'])->group(function () {
    Route::get('/dashboard', [InternDashboardController::class, 'index'])->name('dashboard');
});

/**
 * ========================
 * ERROR + FALLBACK ROUTES
 * ========================
 */
Route::get('/error/404', fn() => response()->view('errors.error404', [], 404))->name('error.404');
Route::get('/error/500', fn() => response()->view('errors.error500', [], 500))->name('error.500');
Route::get('/error/403', fn() => response()->view('errors.error403', [], 403))->name('error.403');

Route::fallback(fn() => redirect()->route('error.404'));

require __DIR__ . '/auth.php';