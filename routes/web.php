<?php

use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\Back\AlbumController;
use App\Http\Controllers\Back\AnnonceController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\ClubController;
use App\Http\Controllers\Back\EmploiDuTempsController;
use App\Http\Controllers\Back\EnseignantController;
use App\Http\Controllers\Back\EspaceNumeriqueController;
use App\Http\Controllers\Back\EtudiantController;
use App\Http\Controllers\Back\EvenementController;
use App\Http\Controllers\Back\FormationController;
use App\Http\Controllers\Back\MatiereController;
use App\Http\Controllers\Back\MessageController;
use App\Http\Controllers\Back\NewsletterController;
use App\Http\Controllers\Back\NiveauController;
use App\Http\Controllers\Back\ParcoursController;
use App\Http\Controllers\Back\AnneeUniversitaireLibelleController;
use App\Http\Controllers\Back\LangueController;
use App\Http\Controllers\Back\ConfigurationController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Espace\EmploiTempsController;
use App\Http\Controllers\Espace\HomeController;
use App\Http\Controllers\Espace\ProfilsController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Espace\AnnoncesController;
use App\Http\Controllers\Espace\EspaceNumeriquesController as EspaceEspaceNumeriquesController;


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
    return redirect()->route('dashboard.webcup');
});

# Route::get('/dashboard', function () {
#     return view('dashboard');
# })->middleware(['auth'])->name('dashboard');

/**
 * Route Authentification
 */
require __DIR__ . '/auth.php';


/**
 * Route Espace Membre
 */

Route::group(['prefix' => 'espace', 'middleware' => ['espace']], function (){

    # Home
    Route::get('/home', [HomeController::class, 'index'])->name('espace.index');

    # Annonces
    Route::get('/annonces', [AnnoncesController::class, 'index'])->name('espace.annonces.index');

    # Profile
    Route::get('/profils', [ProfilsController::class, 'index'])->name('espace.profils.index');
    Route::put('/profils/update/{id}/{type}', [ProfilsController::class, 'update'])->name('espace.profils.update');

    # Emploi du temps
    Route::get('/emploi-temps', [EmploiTempsController::class, 'index'])->name('espace.emploi_temps.index');

    # Espace Numerique
    Route::get('/espace-numeriques', [EspaceEspaceNumeriquesController::class, 'index'])->name('espace.espace_numerique.index');


    Route::get('/verification-compte', [HomeController::class, 'verification'])->name('espace.verification');
    Route::get('/login', [HomeController::class, 'login'])->name('espace.login');

    # Route::view('/layout', 'espace.parent.layout')->name('espace.parent.layouts');
});


/**
 * Route Back-office
 */

Route::group(['prefix' => 'toor', 'middleware' => ['auth']], function (){

    Route::get('/', [AdminController::class, 'index'])->name('dashboard.webcup');

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
    Route::name('etudiant.show.modal')->get('/etudiant/modal/{email}', [EtudiantController::class, 'modal']);
    Route::name('etudiant.indexactif')->get('/etudiant-actif', [EtudiantController::class, 'index']);
    Route::name('etudiant.indexold')->get('/etudiant-ancien', [EtudiantController::class, 'index']);
    Route::name('etudiant.filter')->get('/etudiant/filter/avance', [EtudiantController::class, 'filter']);
    Route::name('etudiant.filter.new')->get('/etudiant/filter/avance/show', [EtudiantController::class, 'filterJS']);
    Route::name('etudiant.filter.new.request')->get('/etudiant/filter/avance/request', [EtudiantController::class, 'filterJSRequest']);
    Route::name('etudiant.download.actif')->get('/etudiant/download/actif', [EtudiantController::class, 'downloadActif']);
    Route::name('etudiant.excel.view')->get('/etudiant/excel/view', [EtudiantController::class, 'excelView']);
    Route::name('etudiant.excel.export')->get('/etudiant/excel/export', [EtudiantController::class, 'excelExport']);
    Route::name('etudiant.excel.import')->post('/etudiant/excel/import', [EtudiantController::class, 'excelImport']);

# Enseignants
    Route::resource('enseignant', EnseignantController::class);

# Clubs
    Route::resource('club', ClubController::class);
    Route::view('/configuration/lien', 'back.configuration.lien')->name('configuration.lien');
    Route::get('/club/{club}/staff', [ClubController::class, 'addStaffView'])->name('club.staff.view');
    Route::post('/club/staff/add', [ClubController::class, 'addStaffStore'])->name('club.staff.add');
    Route::get('/club/staff/pull/{staff}', [ClubController::class, 'deleteStaff'])->name('club.staff.add.pull');

# Langue
    Route::resource('langue', LangueController::class);

# Album
    Route::resource('album', AlbumController::class);
    Route::get('/album/photos/{album}', [AlbumController::class, 'photosView'])
        ->name('album.photos.view');
    Route::post('/album/photos/upload/{album}', [AlbumController::class, 'photos'])
        ->name('album.photos.upload');
    Route::post('/album/photos/delete/{album}', [AlbumController::class, 'deletephotos'])
        ->name('album.photos.delete');

# Articles
    Route::resource('article', ArticleController::class);
    Route::get('/article/galeries/{article}', [ArticleController::class, 'galeriesView'])
        ->name('article.galeries.view');
    Route::post('/article/galeries/upload/{article}', [ArticleController::class, 'galeries'])
        ->name('article.galeries.upload');
    Route::post('/article/galeries/delete/{article}', [ArticleController::class, 'deleteGaleries'])
        ->name('article.galeries.delete');

# Evenements
    Route::resource('evenement', EvenementController::class);
    Route::get('/evenement/galeries/{evenement}', [EvenementController::class, 'galeriesView'])
        ->name('evenement.galeries.view');
    Route::post('/evenement/galeries/upload/{evenement}', [EvenementController::class, 'galeries'])
        ->name('evenement.galeries.upload');
    Route::post('/evenement/galeries/delete/{evenement}', [EvenementController::class, 'deleteGaleries'])
        ->name('evenement.galeries.delete');

# Annonces
    Route::resource('annonce', AnnonceController::class);
    Route::get('/annonce/galeries/{annonce}', [AnnonceController::class, 'galeriesView'])
        ->name('annonce.galeries.view');
    Route::post('/annonce/galeries/upload/{annonce}', [AnnonceController::class, 'galeries'])
        ->name('annonce.galeries.upload');
    Route::post('/annonce/galeries/delete/{annonce}', [AnnonceController::class, 'deleteGaleries'])
        ->name('annonce.galeries.delete');

    Route::name('annonce.approuve.update')->put('/annonce/approuve/{annonce}', [AnnonceController::class, 'approuve']);
    Route::name('annonce.desapprouve.update')->put('/annonce/desapprouve/{annonce}', [AnnonceController::class, 'desapprouve']);

# Message
    Route::resource('message', MessageController::class);

# Newsletter
    Route::resource('newsletter', NewsletterController::class);

# Configuration
    Route::view('/configuration/contenu', 'back.configuration.contenu')->name('configuration.contenu');
    Route::view('/configuration/contact', 'back.configuration.contact')->name('configuration.contact');
    Route::view('/configuration/lien', 'back.configuration.lien')->name('configuration.lien');
    Route::view('/configuration/index', 'back.configuration.index')->name('configuration.index');

    Route::put('/configuration/update', [ConfigurationController::class, 'update'])->name('configuration.update');
    Route::get('/configuration/update', [ConfigurationController::class, 'edit'])->name('configuration.edit');

# Espace Numerique
    Route::resource('espace-numerique-travail', EspaceNumeriqueController::class)
        ->parameters(['espace-numerique-travail' => 'espaceNumerique']);
    Route::get('/espace-numerique-travail/pieces-jointes/{espaceNumerique}', [EspaceNumeriqueController::class, 'piecesJointesView'])
        ->name('espace-numerique-travail.pieces.view');
    Route::post('/espace-numerique-travail/pieces-jointes/upload/{espaceNumerique}', [EspaceNumeriqueController::class, 'piecesJointes'])
        ->name('espace-numerique-travail.pieces.upload');
    Route::post('/espace-numerique-travail/pieces-jointes/delete/{espaceNumerique}', [EspaceNumeriqueController::class, 'deletePiecesJointes'])
        ->name('espace-numerique-travail.pieces.delete');


# Emploi du Temps
    Route::resource('emploi-du-temps', EmploiDuTempsController::class)
        ->parameters(['emploi-du-temps' => 'emploiDuTemps']);
    Route::get('/emploi-du-temps/calendar/{id}/{niveau}/{parcours}/{start?}/{end?}', [EmploiDuTempsController::class, 'showCalendar'])
        ->name('emploi-du-temps.calendar.show');
    Route::post('/emploi-du-temps/calendar', [EmploiDuTempsController::class, 'calendar'])
        ->name('emploi-du-temps.calendar');
    Route::get('/emploi-du-temps/calendar/seed', [EmploiDuTempsController::class, 'seed'])
        ->name('emploi-du-temps.calendar.seed');

# Matiere
    Route::resource('matiere', MatiereController::class);

# User
    Route::resource('user', UserController::class);
});



# File Manager
Route::group(['prefix' => 'laravel-filemanager-webcup', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


/*####### API Route

# Token
Route::get('/api/token', [APITokenController::class, 'getToken']);

# Configuration
Route::get('/api/configurations', [APIConfigurationController::class, 'get']);


# Formation
Route::get('/api/formations', [APIFormationController::class, 'all']);
Route::get('/api/formations/{formation}', [APIFormationController::class, 'get']);

# Etudiant
Route::get('/api/etudiants/{etudiant}', [APIEtudiantController::class, 'info']);
Route::get('/api/etudiants/filter/vue', [APIEtudiantController::class, 'filter']);
Route::get('/api/etudiants/filter/status', [APIEtudiantController::class, 'status']);

# Enseignant
Route::get('/api/enseignants/{enseignant}', [APIEnseignantController::class, 'info']);

### Espace Membre
Route::post('/api/login', [APIEspaceMembreController::class, 'login']);


### Emploi du Temps
Route::get('/api/emploi-du-temps', [APIEmploiTempsController::class, 'all']);
Route::get('/api/emploi-du-temps/{id}', [APIEmploiTempsController::class, 'get']);

# Club
Route::get('/api/clubs', [APIClubController::class, 'all']);
Route::get('/api/clubs/{club}', [APIClubController::class, 'get']);

# Article
Route::get('/api/articles', [APIArticleController::class, 'all']);
Route::get('/api/articles/top', [APIArticleController::class, 'top']);
Route::get('/api/articles/{article}', [APIArticleController::class, 'get']);

# Annonces
Route::get('/api/annonces', [APIAnnonceController::class, 'all']);
Route::get('/api/annonces/top', [APIAnnonceController::class, 'top']);
Route::get('/api/annonces/{annonce}', [APIAnnonceController::class, 'get']);

# Evenements
Route::get('/api/evenements', [APIEvenementController::class, 'all']);
Route::get('/api/evenements/top/nouvelle', [APIEvenementController::class, 'topNouvelle']);
Route::get('/api/evenements/top/actualite', [APIEvenementController::class, 'topActualite']);
Route::get('/api/evenements/{evenement}', [APIEvenementController::class, 'get']);

# Messages
Route::post('/api/messages', [APIMessageController::class, 'post']);

# NewsLetter
# Route::post('/api/newsletter', [APINewsletterController::class, 'post']);

# Espace Numeriques
Route::post('/api/espace-numerique', [APIEspaceNumeriqueController::class, 'post']);
Route::post('/api/espace-numerique/{espaceNumerique}', [APIEspaceNumeriqueController::class, 'postPiecesJointes']);
Route::get('/api/espace-numerique', [APIEspaceNumeriqueController::class, 'all']);
Route::get('/api/espace-numerique/{espaceNumerique}', [APIEspaceNumeriqueController::class, 'get']);

# Parcours
Route::get('/api/parcours/etudiants', [APIParcoursController::class, 'filter']);

# Niveaux
Route::get('/api/niveaux/etudiants', [APINiveauController::class, 'filter']);

# Annee Universitaire
Route::get('/api/annee-universitaire/etudiants', [APIAnneeUniversitaireController::class, 'filter']);

# Formation
Route::get('/api/formations/etudiants/filter', [APIFormationController::class, 'filter']);*/
