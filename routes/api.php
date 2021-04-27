<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\NewsletterController as APINewsletterController;
use App\Http\Controllers\API\ConfigurationController as APIConfigurationController;
use App\Http\Controllers\API\FormationController as APIFormationController;
use App\Http\Controllers\API\EtudiantController as APIEtudiantController;
use App\Http\Controllers\API\EnseignantController as APIEnseignantController;
use App\Http\Controllers\API\EspaceMembreController as APIEspaceMembreController;
use App\Http\Controllers\API\TokenController as APITokenController;
use App\Http\Controllers\API\EmploiTempsController as APIEmploiTempsController;
use App\Http\Controllers\API\ClubController as APIClubController;
use App\Http\Controllers\API\ArticleController as APIArticleController;
use App\Http\Controllers\API\AnnonceController as APIAnnonceController;
use App\Http\Controllers\API\EvenementController as APIEvenementController;
use App\Http\Controllers\API\MessageController as APIMessageController;
use App\Http\Controllers\API\EspaceNumeriqueController as APIEspaceNumeriqueController;
use App\Http\Controllers\API\ParcoursController as APIParcoursController;
use App\Http\Controllers\API\NiveauController as APINiveauController;
use App\Http\Controllers\API\AnneeUniversitaireController as APIAnneeUniversitaireController;
use App\Http\Controllers\API\AlbumController as APIAlbumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


####### API Route

# NewsLetter
Route::post('/newsletter', [APINewsletterController::class, 'post']);

# Token
Route::get('/token', [APITokenController::class, 'getToken']);

# Configuration
Route::get('/configurations', [APIConfigurationController::class, 'get']);

# Formation
Route::get('/formations', [APIFormationController::class, 'all']);
Route::get('/formations/{formation}', [APIFormationController::class, 'get']);

# Etudiant
Route::get('/etudiants', [APIEtudiantController::class, 'all']);
Route::get('/etudiants/{etudiant}', [APIEtudiantController::class, 'info']);
Route::get('/etudiants/filter/vue', [APIEtudiantController::class, 'filter']);
Route::get('/etudiants/filter/status', [APIEtudiantController::class, 'status']);
Route::post('/etudiants/{etudiant}', [APIEtudiantController::class, 'update']);
Route::post('/etudiants/{etudiant}/upload', [APIEtudiantController::class, 'changePhoto']);


# Enseignant
Route::get('/enseignants/{enseignant}', [APIEnseignantController::class, 'info']);
Route::post('/enseignants/{enseignant}', [APIEnseignantController::class, 'update']);
Route::post('/enseignants/{enseignant}/upload', [APIEnseignantController::class, 'changePhoto']);

### Espace Membre
Route::post('/login', [APIEspaceMembreController::class, 'login']);
Route::post('/logout', [APIEspaceMembreController::class, 'logout']);
Route::post('/verify', [APIEspaceMembreController::class, 'verifyEspace']);


### Album
Route::get('/albums', [APIAlbumController::class, 'all']);
Route::get('/albums/{pagination}', [APIAlbumController::class, 'paginate']);
Route::get('/albums/detail/{album}', [APIAlbumController::class, 'get']);


### Emploi du Temps
Route::get('/emploi-du-temps/{pagination?}', [APIEmploiTempsController::class, 'all']);
Route::get('/emploi-du-temps/detail/{id}', [APIEmploiTempsController::class, 'get']);

# Club
Route::get('/clubs', [APIClubController::class, 'all']);
Route::get('/clubs/{club}', [APIClubController::class, 'get']);

# Article
Route::get('/articles/{pagination?}', [APIArticleController::class, 'all']);
Route::get('/articles/principal/top', [APIArticleController::class, 'top']);
Route::get('/articles/detail/{article}', [APIArticleController::class, 'get']);

# Annonces
Route::get('/annonces/{pagination?}', [APIAnnonceController::class, 'all']);
Route::get('/annonces/principal/top', [APIAnnonceController::class, 'top']);
Route::get('/annonces/detail/{annonce}', [APIAnnonceController::class, 'get']);

# Evenements
Route::get('/evenements/{pagination?}', [APIEvenementController::class, 'all']);
Route::get('/evenements/principal/top/nouvelle', [APIEvenementController::class, 'topNouvelle']);
Route::get('/evenements/principal/top/actualite', [APIEvenementController::class, 'topActualite']);
Route::get('/evenements/detail/{evenement}', [APIEvenementController::class, 'get']);

# Messages
Route::post('/messages', [APIMessageController::class, 'post']);


# Espace Numeriques
Route::post('/espace-numerique', [APIEspaceNumeriqueController::class, 'post']);
Route::post('/espace-numerique/{espaceNumerique}', [APIEspaceNumeriqueController::class, 'postPiecesJointes']);
Route::get('/espace-numerique/{pagination?}', [APIEspaceNumeriqueController::class, 'all']);
Route::get('/espace-numerique/detail/{espaceNumerique}', [APIEspaceNumeriqueController::class, 'get']);

# Parcours
Route::get('/parcours/etudiants', [APIParcoursController::class, 'filter']);

# Niveaux
Route::get('/niveaux/etudiants', [APINiveauController::class, 'filter']);

# Annee Universitaire
Route::get('/annee-universitaire/etudiants', [APIAnneeUniversitaireController::class, 'filter']);

# Formation
Route::get('/formations/etudiants/filter', [APIFormationController::class, 'filter']);

