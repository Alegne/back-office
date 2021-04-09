<?php

use App\Http\Controllers\Back\EtudiantController;
use App\Http\Controllers\Back\FormationController;
use App\Http\Controllers\Back\NiveauController;
use App\Http\Controllers\Back\ParcoursController;
use App\Http\Controllers\Back\AnneeUniversitaireLibelleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/**
 * Route Authentification
 */
require __DIR__.'/auth.php';


/**
 * Route Back-office
 */

# Tester l'intergaration
Route::get('/layout', function () {
    return view('back.parent.layout');
});

# Formation
Route::resource('formation', FormationController::class);

# Parcours
Route::resource('parcours', ParcoursController::class)->parameters(['parcours' => 'parcours']);

# Annee Universitaire
Route::resource('annee-universitaire', AnneeUniversitaireLibelleController::class)->parameters(['annee-universitaire' => 'annee']);

# Niveau
Route::resource('niveau', NiveauController::class);

# Etudiants
Route::resource('etudiant', EtudiantController::class);
Route::name('etudiant.indexactif')->get('/etudiant-actif', [EtudiantController::class, 'index']);
Route::name('etudiant.indexold')->get('/etudiant-ancien', [EtudiantController::class, 'index']);
