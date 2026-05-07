<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OtpController;

// --- Routes d'Authentification ---
Route::get('/', [GuestController::class, 'login'])->name('login');
Route::post('/', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::get('/verify-2fa', [GuestController::class, 'twoFactor'])->name('two-factor');
Route::post('/verify-2fa', [OtpController::class, 'verify'])->name('two-factor.verify');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// --- Routes d'Invitation (Visiteurs/Candidats) ---
Route::controller(GuestController::class)->prefix('invitation')->name('invitation.')->group(function () {
    Route::get('/', 'invitation')->name('home');
    Route::get('/identification', 'identification')->name('identification');
    Route::get('/televersement', 'upload')->name('upload');
    Route::get('/confirmation', 'confirmation')->name('confirmation');
});

// --- Routes Protégées (Auth & Role Middleware) ---
Route::middleware(['auth'])->group(function () {

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/evenements', [AdminController::class, 'evenements'])->name('evenements');
        Route::get('/documents', [AdminController::class, 'documents'])->name('documents');
        Route::get('/recherche', [AdminController::class, 'recherche'])->name('recherche');
        Route::get('/archives', [AdminController::class, 'archives'])->name('archives');
        Route::get('/cloud', [AdminController::class, 'cloud'])->name('cloud');
    });

    // Super Admin Routes
    Route::middleware('role:super-admin')->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/administrateurs', [UserController::class, 'index'])->name('administrateurs');
        Route::get('/logs', [SuperAdminController::class, 'logs'])->name('logs');
        Route::get('/logs/refresh', [SuperAdminController::class, 'refreshLogs'])->name('logs.refresh');
        Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
        Route::get('/creation-admin', [SuperAdminController::class, 'creationAdmin'])->name('creation-admin');

        Route::get('/administrateurs/edit/{user}', [UserController::class, 'edit'])->name('administrateurs.edit');
        Route::patch('/administrateurs/toggle-status/{user}', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Routes Publiques (mais nécessitant d'être connecté) ---
Route::post('/user/heartbeat', [UserController::class, 'heartbeat'])->name('user.heartbeat')->middleware('auth');

// --- Routes de Gestion des Utilisateurs (Accès complet par design) ---
// Elles sont définies en dehors du groupe 'auth' pour que le SuperAdmin puisse les appeler directement.
Route::resource('users', UserController::class)->except(['show']);

require __DIR__ . '/auth.php';
