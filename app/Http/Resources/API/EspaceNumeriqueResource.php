<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class EspaceNumeriqueResource extends JsonResource
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
            'id'                     => $this->id,
            'libelle'                => $this->libelle,
            'description'            => $this->description,
            'enseignant'             => $this->enseignant->nom,
            'niveau'                 => $this->niveau->tag,
            'parcours'               => $this->parcours->pluck('tag'),
            'date_creation'          => $this->created_at,
            'date_mise_jour'         => $this->updated_at,
            'pieces_jointes'         => $this->pieces_jointes ? getFileMultiple($this->pieces_jointes) : null,
        ];
    }
}
