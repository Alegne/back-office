<?php

use App\Http\Controllers\Back\AnnonceController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\ClubController;
use App\Http\Controllers\Back\EnseignantController;
use App\Http\Controllers\Back\EspaceNumeriqueController;
use App\Http\Controllers\Back\EtudiantController;
use App\Http\Controllers\Back\EvenementController;
use App\Http\Controllers\Back\FormationController;
use App\Http\Controllers\Back\MessageController;
use App\Http\Controllers\Back\NewsletterController;
use App\Http\Controllers\Back\NiveauController;
use App\Http\Controllers\Back\ParcoursController;
use App\Http\Controllers\Back\AnneeUniversitaireLibelleController;
use App\Http\Controllers\Back\LangueController;
use App\Http\Controllers\Back\ConfigurationController;
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
require __DIR__ . '/auth.php';


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

# Enseignants
Route::resource('enseignant', EnseignantController::class);

# Clubs
Route::resource('club', ClubController::class);Route::view('/configuration/lien', 'back.configuration.lien')->name('configuration.lien');
Route::get('/club/{club}/staff', [ClubController::class, 'addStaffView'])->name('club.staff.view');
Route::post('/club/staff/add', [ClubController::class, 'addStaffStore'])->name('club.staff.add');

# Langue
Route::resource('langue', LangueController::class);

# Articles
Route::resource('article', ArticleController::class);

# Evenements
Route::resource('evenement', EvenementController::class);

# Annonces
Route::resource('annonce', AnnonceController::class);

# Message
Route::resource('message', MessageController::class);

# Newsletter
Route::resource('newsletter', NewsletterController::class);

# Configuration
Route::view('/configuration/contenu', 'back.configuration.contenu')->name('configuration.contenu');
Route::view('/configuration/contact', 'back.configuration.contact')->name('configuration.contact');
Route::view('/configuration/lien', 'back.configuration.lien')->name('configuration.lien');

Route::put('/configuration/update', [ConfigurationController::class, 'update'])->name('configuration.update');

# Espace Numerique
Route::resource('espace-numerique-travail', EspaceNumeriqueController::class)
    ->parameters(['espace-numerique-travail' => 'espaceNumerique']);


# File Manager
Route::group(['prefix' => 'laravel-filemanager-webcup', 'middleware' => ['web', 'auth']], function (){
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
