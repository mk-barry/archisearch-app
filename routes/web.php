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

    // 1. Routes Libres : L'étudiant arrive ici pour s'identifier
    Route::get('/historique', 'history')->name('history');
    Route::get('/{uuid}', 'invitation')->name('home');
    Route::get('/identification/{uuid}', 'identification')->name('identification');
    Route::post('/verify/{uuid}', 'verifyIdentification')->name('verify'); // La route qui crée la session

    // 2. Routes Protégées : L'étudiant doit être identifié (Middleware student.auth)
    Route::middleware(['student.auth', 'student.allowed'])->group(function () {
        
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/televersement/{uuid}', 'upload')->name('upload');
        Route::post('/televersement/{uuid}/store', 'storeDocument')->name('store.document');
        Route::get('/confirmation/{uuid}', 'confirmation')->name('confirmation');
    });
});

// --- Routes Protégées (Auth & Role Middleware) ---
Route::middleware(['auth'])->group(function () {

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/evenements', [AdminController::class, 'evenements'])->name('evenements');
        Route::post('/evenements/store', [AdminController::class, 'storeEvent'])->name('events.store');
        Route::patch('/admin/evenements/{event}/cloture-prematuree', [AdminController::class, 'cloturePrematuree'])->name('evenements.cloture-prematuree');
        // On ajoute une route de visualisation rapide
        Route::get('/evenements/{uuid}', [AdminController::class, 'showEvent'])->name('voir-events');
        Route::get('/creation-events', [AdminController::class, 'creationEvent'])->name('creation-events');
        Route::get('/evenements/{uuid}/edit', [AdminController::class, 'editEvent'])->name('edit-events');
        Route::put('/evenements/{uuid}/update', [AdminController::class, 'update'])->name('evenements.update');
        Route::get('/documents', [AdminController::class, 'documents'])->name('documents');
        // Route::get('/document/{document}/view', [AdminController::class, 'showDocumentAnalysis'])->name('documents.show');
        Route::get('/document/{document}/test', [AdminController::class, 'showDocumentAnalysis'])->name('doc.show');
        Route::get('/document/{document}/download', [AdminController::class, 'downloadDocument'])->name('documents.download');
        Route::delete('/document/{document}', [AdminController::class, 'destroyDocument'])->name('documents.destroy');
        Route::post('/bulk', [AdminController::class, 'bulkAction'])->name('documents.bulk');
        Route::post('/document/{document}/status', [AdminController::class, 'updateStatus'])->name('documents.updateStatus');
        Route::get('/recherche', [AdminController::class, 'recherche'])->name('recherche');
        Route::get('/recherche/save', [AdminController::class, 'sauvegarderRecherche'])->name('recherche.save');
        // Route::get('/recherche/search_result', [AdminController::class, 'recherche'])->name('recherche.partial');
        Route::get('/archives', [AdminController::class, 'archives'])->name('archives');
        Route::get('/cloud', [AdminController::class, 'cloud'])->name('cloud');
    });

    // Super Admin Routes
    Route::middleware('role:super-admin')->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/administrateurs', [UserController::class, 'index'])->name('administrateurs');
        Route::get('/students', [SuperAdminController::class, 'indexStudents'])->name('students');
        Route::get('/logs', [SuperAdminController::class, 'logs'])->name('logs');
        Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
        Route::get('/creation-admin', [SuperAdminController::class, 'creationAdmin'])->name('creation-admin');
        Route::get('/creation-student', [SuperAdminController::class, 'createStudent'])->name('students.create');
        Route::post('/store-student', [SuperAdminController::class, 'storeStudent'])->name('students.store');
        Route::post('/store-doc-type', [SuperAdminController::class, 'storeDocType'])->name('document-types.store');
        Route::post('/extension', [SuperAdminController::class, 'storeExtension'])->name('extensions.store');
        Route::post('/extensions/{extension}', [SuperAdminController::class, 'destroyExtension'])->name('extensions.destroy');

        Route::get('/administrateurs/edit/{user}', [UserController::class, 'edit'])->name('administrateurs.edit');
        Route::patch('/administrateurs/toggle-status/{user}', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Profile Routes
    // Route::get('/profile', [UserController::class, 'profile'])->name('profile.view');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Routes Publiques (mais nécessitant d'être connecté) ---
Route::post('/user/heartbeat', [UserController::class, 'heartbeat'])->name('user.heartbeat')->middleware('auth');

// --- Routes de Gestion des Utilisateurs (Accès complet par design) ---
// Elles sont définies en dehors du groupe 'auth' pour que le SuperAdmin puisse les appeler directement.
Route::resource('users', UserController::class)->except(['show']);

require __DIR__ . '/auth.php';
