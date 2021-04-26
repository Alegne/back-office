<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_evenements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'date_creation',
        'posteur',
        'slug',
        'type',
        'image',
        'galerie'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_creation'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        # 'is_admin' => 'boolean',
        'date_creation' => 'datetime',
    ];


    /**
     * Get Galerie.
     *
     * @param  string  $value
     * @return string
     */
    public function getGalerieAttribute($value)
    {
        return  json_decode($value);
    }

    /**
     * Set Galerie.
     *
     * @param  string  $value
     * @return void
     */
    public function setGalerieAttribute($value)
    {
        $this->attributes['galerie'] = json_encode($value);
    }
}
