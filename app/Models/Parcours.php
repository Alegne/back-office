<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_parcours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'tag'
    ];

    /**
     * Get the etudiants for the club.
     */
    public function etudiants()
    {
        # foreignKey
        return $this->hasMany(Etudiant::class, 'parcours_id');
    }
}
