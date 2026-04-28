<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class);

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/verify-2fa', function () {
    return view('auth.two-factor');
})->name('two-factor');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset.test');

// Super Admin Routes
Route::prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('super-admin.dashboard'); })->name('dashboard');
    Route::get('/administrateurs', [UserController::class, 'index'])->name('administrateurs');
    Route::get('/logs', function () {
        return view('super-admin.logs'); })->name('logs');
    Route::get('/settings', function () {
        return view('super-admin.settings'); })->name('settings');
    Route::get('/creation-admin', function () {
        return view('super-admin.creation-admin');
    })->name('creation-admin');
    Route::get('/administrateurs/edit/{user}', [UserController::class, 'edit'])->name('administrateurs.edit');
    Route::patch('/administrateurs/toggle-status/{user}', [UserController::class, 'toggleStatus'])
    ->name('toggle-status');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); })->name('dashboard');
    Route::get('/evenements', function () {
        return view('admin.evenements'); })->name('evenements');
    Route::get('/documents', function () {
        return view('admin.documents'); })->name('documents');
    Route::get('/recherche', function () {
        return view('admin.recherche'); })->name('recherche');
    Route::get('/archives', function () {
        return view('admin.archives'); })->name('archives');
    Route::get('/cloud', function () {
        return view('admin.cloud'); })->name('cloud');
});

// User Routes

Route::get('/invitation', function () {
    return view('user.invitation');
})->name('invitation.home');

Route::get('/invitation/identification', function () {
    return view('user.identification');
})->name('invitation.identification');

Route::get('/invitation/televersement', function () {
    return view('user.televersement');
})->name('invitation.upload');

Route::get('/invitation/confirmation', function () {
    return view('user.confirmation');
})->name('invitation.confirmation');

// System Routes

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
