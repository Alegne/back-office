<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class NiveauResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        #return parent::toArray($request);
        return [
            'id'              => $this->id,
            'libelle'         => $this->libelle,
            'tag'             => $this->tag,
            'etudiants_count' => $this->etudiants_count ? $this->etudiants_count : null
        ];
    }
}
