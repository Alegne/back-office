<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class EtuditantStatusResource extends JsonResource
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
            'status'          => $this->status,
            'etudiants_count' => $this->etudiants_count ? $this->etudiants_count : null
        ];
    }
}
