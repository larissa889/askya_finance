<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Caissier\CaisseController;
use App\Http\Controllers\Caissier\EndOfDayController;
use App\Http\Controllers\Caissier\SearchController;
use App\Http\Controllers\Caissier\ServiceController;
use App\Http\Controllers\Caissier\TransactionController as CaissierTransactionController;
use App\Http\Controllers\CaissierController;
use App\Http\Controllers\ComptableController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperviseurController;
use Illuminate\Support\Facades\Route;

// Route racine - TOUJOURS redirige vers login
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Routes pour les tableaux de bord selon le rôle (nécessite authentification + vérification du rôle)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $role = $user->role instanceof \App\Modules\Users\Models\UserRole 
            ? $user->role->value 
            : $user->role;
            
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'caissier' => redirect()->route('caissier.dashboard'),
            'superviseur' => redirect()->route('superviseur.dashboard'),
            'comptable' => redirect()->route('comptable.dashboard'),
            default => abort(403, 'Rôle non reconnu.'),
        };
    })->name('dashboard');

    Route::get('/caissier/dashboard', [CaissierController::class, 'dashboard'])
        ->name('caissier.dashboard')
        ->middleware('role:caissier');
    
    // Routes caissier pour les transactions
    Route::middleware(['auth', 'role:caissier'])->prefix('caissier')->name('caissier.')->group(function () {
        Route::get('transactions', [CaissierTransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/create', [CaissierTransactionController::class, 'create'])->name('transactions.create');
        Route::post('transactions', [CaissierTransactionController::class, 'store'])->name('transactions.store');
        Route::get('transactions/{id}', [CaissierTransactionController::class, 'show'])->name('transactions.show');
        
        // Routes pour la fiche d'arrêt
        Route::get('end-of-day', [EndOfDayController::class, 'index'])->name('end-of-day.index');
        Route::post('end-of-day', [EndOfDayController::class, 'store'])->name('end-of-day.store');
        
        // Routes pour les services
        Route::get('services/{code}', [ServiceController::class, 'show'])->name('service.show');
        Route::get('services/{serviceId}/operation-types', [ServiceController::class, 'getOperationTypes'])->name('services.operation-types');
        
        // Routes pour la caisse
        Route::get('caisse', [CaisseController::class, 'index'])->name('caisse.index');
        Route::post('caisse/ouvrir', [CaisseController::class, 'ouvrir'])->name('caisse.ouvrir');
        Route::post('caisse/fermer', [CaisseController::class, 'fermer'])->name('caisse.fermer');
        
        // Routes pour la recherche
        Route::get('search', [SearchController::class, 'index'])->name('search.index');
    });
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard')
        ->middleware('role:admin');
    
    Route::get('/superviseur/dashboard', [SuperviseurController::class, 'dashboard'])
        ->name('superviseur.dashboard')
        ->middleware('role:superviseur');
    
    // Routes superviseur pour les transactions
    Route::middleware(['auth', 'role:superviseur'])->prefix('superviseur')->name('superviseur.')->group(function () {
        Route::get('transactions', [SuperviseurController::class, 'transactions'])->name('transactions.index');
        Route::post('transactions/{id}/valider', [SuperviseurController::class, 'validerTransaction'])->name('valider');
        Route::post('transactions/{id}/rejeter', [SuperviseurController::class, 'rejeterTransaction'])->name('rejeter');
        Route::get('transactions/{id}', [SuperviseurController::class, 'showTransaction'])->name('show');
        
        // Routes pour la validation
        Route::get('validation', [SuperviseurController::class, 'validation'])->name('validation.index');
        
        // Routes pour les rapports
        Route::get('reports', [SuperviseurController::class, 'reports'])->name('reports.index');
        
        // Routes pour le profil
        Route::get('profile', [SuperviseurController::class, 'profile'])->name('profile.index');
        Route::put('profile', [SuperviseurController::class, 'updateProfile'])->name('profile.update');
    });
    
    Route::get('/comptable/dashboard', [ComptableController::class, 'dashboard'])
        ->name('comptable.dashboard')
        ->middleware('role:comptable');
    
    // Routes comptable pour les compensations
    Route::middleware(['auth', 'role:comptable'])->prefix('comptable')->name('comptable.')->group(function () {
        Route::get('compensations', [ComptableController::class, 'compensations'])->name('compensations.index');
        Route::get('compensations/{id}', [ComptableController::class, 'showCompensation'])->name('compensations.show');
        Route::post('compensations/{id}/valider', [ComptableController::class, 'validerCompensation'])->name('valider');
        Route::post('compensations/{id}/payer', [ComptableController::class, 'marquerPaye'])->name('payer');
        
        // Routes pour le solde
        Route::get('solde', [ComptableController::class, 'solde'])->name('solde.index');
        
        // Routes pour les rapports
        Route::get('reports', [ComptableController::class, 'financialReports'])->name('reports.index');
        Route::post('rapport', [ComptableController::class, 'genererRapport'])->name('rapport');
        Route::post('export', [ComptableController::class, 'export'])->name('export');
        
        // Routes pour le profil
        Route::get('profile', [ComptableController::class, 'profile'])->name('profile.index');
        Route::put('profile', [ComptableController::class, 'updateProfile'])->name('profile.update');
    });
});

// Routes admin pour la gestion des utilisateurs (nécessite authentification + rôle admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    
    // Routes pour les transactions
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    
    // Routes pour les rapports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Routes pour les paramètres
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});

// Routes de profil (nécessite authentification)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
