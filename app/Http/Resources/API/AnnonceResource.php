<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnonceResource extends JsonResource
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
            'id'             => $this->id,
            'titre'          => $this->titre,
            'description'    => $this->description,
            'type'           => $this->type,
            'parcours'       => $this->parcours->pluck('tag'),
            'niveaux'        => $this->niveau->pluck('tag'),
            'image'          => $this->image ? getImageSingle($this->image) : null,
            'date_creation'  => $this->created_at,
            'date_mise_jour' => $this->updated_at,
            'galerie'        => getFileMultiple($this->galerie),
        ];
    }
}
