<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class EmploiTempsResource extends JsonResource
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
            'date_debut'        => $this->date_debut,
            'date_fin'          => $this->date_fin,
            'niveau'            => $this->niveau->tag,
            'annee'             => $this->annee->libelle,
            'parcours'          => $this->parcours->pluck('tag')
        ];
    }
}
