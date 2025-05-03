<?php

use App\Http\Controllers\Admin\AdminInternsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Mintor\MintorDashboardController;
use App\Http\Controllers\Intern\InternDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('interns', AdminInternsController::class);
    Route::get('interns-export', [AdminInternsController::class, 'export'])->name('interns.export');
    Route::get('interns-print', [AdminInternsController::class, 'print'])->name('interns.print');
    Route::post('interns-import', [AdminInternsController::class, 'import'])->name('interns.import');
    Route::get('interns-template', [AdminInternsController::class, 'template'])->name('interns.template');
});

Route::prefix('mintor')->name('mintor.')->middleware(['auth', 'mintor'])->group(function () {
    Route::get('/dashboard', [MintorDashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('intern')->name('intern.')->middleware(['auth', 'intern'])->group(function () {
    Route::get('/dashboard', [InternDashboardController::class, 'index'])->name('dashboard');
});

// Route for 404 errors.
Route::get('/error/404', function () {
    return response()->view('errors.error404', [], 404);
})->name('error.404');

// Route for 500 errors.
Route::get('/error/500', function () {
    return response()->view('errors.error500', [], 500);
})->name('error.500');

Route::get('/error/403', function () {
    return response()->view('errors.error403', [], 403);
})->name('error.403');

// Fallback route to catch any undefined URL and redirect to your custom 404 page.
Route::fallback(function () {
    return redirect()->route('error.404');
});
require __DIR__ . '/auth.php';
