<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\EnseignantResource;
use App\Http\Resources\API\EtudiantResource;
use App\Models\Enseignant;
use App\Models\Etudiant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EspaceMembreController extends Controller
{

    public function login(Request $request)
    {
        if ($request->has('type') && $request->type == 'etudiant')
        {
            if ($request->has('numero') && $request->numero)
            {
                $etudiant = Etudiant::where('numero', $request->numero)->first();
            } elseif ($request->has('email') && $request->numero){
                $etudiant = Etudiant::where('email', $request->email)->first();
            } else {
                return response()->json(['message' => 'Email ou Numero Invalide']);
            }

            # request | BDD
            if ($etudiant && $request->has('password') && Hash::check($request->password, $etudiant->password)){
                # return response()->json($etudiant);

                return new EtudiantResource($etudiant);
            } else {
                return response()->json(['message' => 'Mot de passe Incorrect']);
            }
        } elseif ($request->has('type') && $request->type == 'enseignant'){
            if ($request->has('identifiant') && $request->identifiant)
            {
                $enseignant = Enseignant::where('identifiant', $request->identifiant)->first();
            } elseif ($request->has('email') && $request->numero){
                $enseignant = Enseignant::where('email', $request->email)->first();
            } else {
                return response()->json(['message' => 'Email ou Identifiant Invalide']);
            }

            if ($enseignant && $request->has('mot_de_passe') && Hash::check($request->mot_de_passe, $enseignant->mot_de_passe)){
                return new EnseignantResource($enseignant);
            } else {
                return response()->json(['message' => 'Mot de passe Incorrect']);
            }
        } else{
            return response()->json(['message' => "Erreur d'authentification"]);
        }


    }

    public function logout(Request $request)
    {

    }

    # GET Email|Token
    public function verify(Request $request)
    {
        if ($request->has('type') && $request->type == 'etudiant')
        {
            if ($request->has('email') && $request->email &&
                $request->has('remember_token') && $request->remember_token) {

                $etudiant = Etudiant::where('email', $request->email)
                                    ->where('remember_token', $request->remember_token)
                                    ->update([
                    'email_verified_at' => Carbon::now(),
                    'remember_token' => Carbon::now()
                ]);

                if ($etudiant) {

                    return response()->json($etudiant);
                    # view
                } else{
                    return response()->json(['message' => "Etudiant introuvable"]);
                }

            } else{
                return response()->json(['message' => "Email obligatoire"]);
            }

        }elseif ($request->has('type') && $request->type == 'enseignant'){

            if ($request->has('email') && $request->email) {
                $enseignant = Enseignant::where('email', $request->email)
                    ->where('remember_token', $request->remember_token)
                    ->update([
                        'email_verified_at' => Carbon::now(),
                        'remember_token' => Carbon::now()
                    ]);

                if ($enseignant) {
                    # Envoi d'email

                    return response()->json($enseignant);
                    # View
                } else{
                    return response()->json(['message' => "Enseignant introuvable"]);
                }

            } else{
                return response()->json(['message' => "Champ Email obligatoire"]);
            }
        }else{
            return response()->json(['message' => "Erreur de Confirmation"]);
        }
    }

    # Envoi Email
    public function forgot(Request $request)
    {
        if ($request->has('type') && $request->type == 'etudiant')
        {
            if ($request->has('email') && $request->email) {
                $etudiant = Etudiant::where('email', $request->email)->first();


                if ($etudiant) {
                    # Envoi d'email

                    return response()->json(['message' => "Envoi d'Email"]);
                } else{
                    return response()->json(['message' => "Etudiant introuvable"]);
                }

            } else{
                return response()->json(['message' => "Champ Email obligatoire"]);
            }

        }elseif ($request->has('type') && $request->type == 'enseignant'){

            if ($request->has('email') && $request->email) {
                $enseignant = Enseignant::where('email', $request->email)->first();

                if ($enseignant) {
                    # Envoi d'email

                    return response()->json(['message' => "Envoi d'Email"]);
                } else{
                    return response()->json(['message' => "Enseignant introuvable"]);
                }

            } else{
                return response()->json(['message' => "Champ Email obligatoire"]);
            }
        }else{
            return response()->json(['message' => "Erreur de reinitialisation"]);
        }

    }

    # Reset
    public function reset(Request $request)
    {
        if ($request->has('type') && $request->type == 'etudiant')
        {
            if ($request->has('email') && $request->email) {
                $etudiant = Etudiant::where('email', $request->email)->update([
                    'password' => Hash::make($request->password)
                ]);

                if ($etudiant) {

                    return response()->json($etudiant);
                    # view
                } else{
                    return response()->json(['message' => "Etudiant introuvable"]);
                }

            } else{
                return response()->json(['message' => "Champ Email obligatoire"]);
            }

        }elseif ($request->has('type') && $request->type == 'enseignant'){

            if ($request->has('email') && $request->email) {
                $enseignant = Enseignant::where('email', $request->email)->update([
                    'mot_de_passe' => Hash::make($request->mot_de_passe)
                ]);

                if ($enseignant) {
                    # Envoi d'email

                    return response()->json($enseignant);
                    # View
                } else{
                    return response()->json(['message' => "Enseignant introuvable"]);
                }

            } else{
                return response()->json(['message' => "Champ Email obligatoire"]);
            }
        }else{
            return response()->json(['message' => "Erreur de reinitialisation"]);
        }
    }

}
