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
        return $this->hasMany(Etudiant::class, 'parcours_id');
    }

    /**
     * Get the files that owns the items.
     */
    public function fichiers()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsToMany(
            EspaceNumerique::class,
            'cactus_ent_parcours',
            'parcours_id',
            'ent_id')
            ->orderBy('cactus_ent_parcours.id', 'desc')
            ;
    }
}
