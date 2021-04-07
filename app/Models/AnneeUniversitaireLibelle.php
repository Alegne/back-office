<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeUniversitaireLibelle extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_annee_universitaire_libelles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle'
    ];


    /**
     * Get the etudiants for the niveau.
     */
    public function etudiants()
    {
        # foreignKey
        return $this->belongsToMany(
            Etudiant::class,
            AnneeUniversitaire::class, # Pivot
            'annee_id',
            'etudiant_id')
            # ->withPivot('libelle')
            ;
    }
}
