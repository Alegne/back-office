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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        # 'heure_debut',
        # 'heure_fin',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        # 'heure_debut' => 'datetime',
        # 'heure_fin' => 'datetime',
    ];

    /**
     * Timestamps disable
     *
     * @var bool
     */
    public $timestamps = false;

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
