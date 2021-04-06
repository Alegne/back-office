<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiTempsItem extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_emploi_du_temps_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matiere',
        'jour',
        'heure_debut',
        'heure_fin',
        'specification',
        'niveau_id',
        'parcours_id',
        'emploi_du_temps_id',
        'enseignant_id'
    ];

    /**
     * Get the parent that owns the items.
     */
    public function parent()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Club::class, 'club_id', 'id');
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
        return $this->belongsTo(Parcours::class, 'parcours_id', 'id');
    }

    /**
     * Get the enseignant that owns the items.
     */
    public function enseignant()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Club::class, 'enseignant_id', 'id');
    }
}
