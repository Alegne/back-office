<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiTemps extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_emploi_du_temps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_debut',
        'date_fin',
        'niveau_id',
        'annee_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        # 'date_debut',
        # 'date_fin',
        # 'parcours_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        # 'is_admin' => 'boolean',
        # 'date_debut' => 'datetime',
        # 'date_fin' => 'datetime',
    ];

    /**
     * Timestamps disable
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the items for the emploi du temps.
     */
    public function items()
    {
        # foreignKey
        return $this->hasMany(EmploiTempsItem::class, 'emploi_du_temps_id');
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
        # return $this->belongsTo(Parcours::class, 'parcours_id', 'id');
        return $this->belongsToMany(
            Parcours::class,
            'cactus_emploi_du_temps_parcours', # Pivot
            'emploi_du_temps_id',
            'parcours_id')
            # ->withPivot('id')
            # ->orderBy('cactus_annee_universitaires.id', 'desc')
            ;
    }

    /**
     * Get the annee that owns the items.
     */
    public function annee()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(AnneeUniversitaireLibelle::class, 'annee_id', 'id');
    }
}
