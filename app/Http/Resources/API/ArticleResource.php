<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'id'              => $this->id,
            'slug'            => $this->slug,
            'titre'           => $this->titre,
            'posteur'         => $this->posteur,
            'club'            => $this->club->libelle,
            'description'     => $this->description,
            'image'           => $this->image ? getImageSingle($this->image) : null,
            'date_creation'   => $this->created_at,
            'date_mise_jour'  => $this->updated_at,
            'galerie'        => getFileMultiple($this->galerie),
        ];
    }
}
