<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_enseignants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'titre',
        'grade',
        'identifiant',
        'mot_de_passe',
        'email',
        'telephone',
        'adresse',
        'photo'
    ];

    /**
     * Get the piecesJointes for the enseignant.
     */
    public function piecesJointes()
    {
        # foreignKey
        return $this->hasMany(EspaceNumerique::class, 'enseignant_id');
    }
}
