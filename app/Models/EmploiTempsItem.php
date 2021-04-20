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
        'matiere_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'specification',
        'emploi_du_temps_id'
    ];

    /**
     * Get the parent that owns the items.
     */
    public function parent()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(EmploiTemps::class, 'emploi_du_temps_id', 'id');
    }

    /**
     * Get the matiere that owns the items.
     */
    public function matiere()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Matiere::class, 'matiere_id', 'id');
    }
}
