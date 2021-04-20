<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_matieres';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'couleur',
        'enseignant_id',
        'niveau_id'
    ];


    /**
     * Get the enseignant that owns the items.
     */
    public function enseignant()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Enseignant::class, 'enseignant_id', 'id');
    }

    /**
     * Get the niveau that owns the items.
     */
    public function niveau()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Niveau::class, 'niveau_id', 'id');
    }


    /**
     * Get the parcours that owns the items.
     */
    public function parcours()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsToMany(
            Parcours::class,
            'cactus_matiere_parcours', # Pivot
            'matiere_id',
            'parcours_id')
            # ->withPivot('id')
            # ->orderBy('cactus_annee_universitaires.id', 'desc')
            ;
    }
}
