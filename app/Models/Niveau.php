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
        'tag',
        'formation_id'
    ];

    /**
     * Desactive timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the etudiants for the niveau.
     */
    public function etudiants()
    {
        # foreignKey
        return $this->belongsToMany(
            Etudiant::class,
            AnneeUniversitaire::class,
            'niveau_id',
            'etudiant_id')
            # ->withPivot('libelle')
            ;
    }


    /**
     * Get the formation for the niveau.
     */
    public function formation()
    {
        return $this->belongsTo(Formation::class,'formation_id');
    }

    /**
     * Get files for the niveau
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fichiers()
    {
        return $this->hasMany(EspaceNumerique::class, 'niveau_id');
    }
}
