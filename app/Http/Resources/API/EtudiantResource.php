<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class EtudiantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        # return parent::toArray($request);
        return [
            'id'                => $this->id,
            'numero'            => $this->numero,
            'nom'               => $this->nom,
            'prenom'            => $this->prenom,
            'email'             => $this->email,
            'cin'               => $this->cin,
            'date_naissance'    => $this->date_naissance,
            'lieu_naissance'    => $this->lieu_naissance,
            'adresse'           => $this->adresse,
            'status'            => $this->status,
            'parcours'          => $this->parcours->tag,
            'niveau'            => $this->niveau->pluck('tag'), # count($this->niveau) > 0 ? $this->niveau[0]->tag : null,
            'annee'             => $this->annee->pluck('libelle'), # count($this->annee) > 0 ? $this->annee[0]->libelle : null,
            'photo'             => $this->photo ? getImageSingle($this->photo) : null,
            'remember_token'    => $this->remember_token,
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
