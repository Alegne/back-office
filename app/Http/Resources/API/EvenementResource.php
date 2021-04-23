<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class EvenementResource extends JsonResource
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
            'date_creation'   => $this->date_creation,
            'description'     => $this->description,
            'image'           => $this->image ? getImageSingle($this->image) : null,
            'type'            => $this->type,
            'date_mise_jour'  => $this->updated_at,
        ];
    }
}
