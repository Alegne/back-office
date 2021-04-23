<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class EnseignantResource extends JsonResource
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
            'nom'               => $this->nom,
            'prenom'            => $this->prenom,
            'titre'             => $this->titre,
            'grade'             => $this->grade,
            'email'             => $this->email,
            'adresse'           => $this->adresse,
            'telephone'         => $this->telephone,
            'remember_token'    => $this->remember_token,
            'email_verified_at' => $this->email_verified_at,
            'photo'             => $this->photo ? getImageSingle($this->photo) : null,
        ];
    }
}
