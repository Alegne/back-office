<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_niveaux';

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
     * Desactive timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the etudiants for the club.
     */
    public function etudiants()
    {
        # foreignKey
        return $this->hasMany(Etudiant::class, 'niveau_id');
    }
}
