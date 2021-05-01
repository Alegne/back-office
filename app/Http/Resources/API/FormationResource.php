<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
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
            'id'          => $this->id,
            'libelle'     => $this->libelle,
            'slug'        => $this->slug,
            'description' => $this->description,
            'photo'       => $this->photo ? getImageSingle($this->photo) : null,
        ];
    }
}
