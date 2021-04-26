<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_annonces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'image',
        'galerie',
    ];

    /**
     * Get the niveau that owns the annonces.
     */
    public function niveau()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsToMany(
            Niveau::class,
            'cactus_annonces_niveaux', # Pivot
            'annonce_id',
            'niveau_id')
            ->withPivot('id')
            ->orderBy('cactus_annonces_niveaux.updated_at', 'desc')
            ;
    }

    /**
     * Get the parcours that owns the annonces.
     */
    public function parcours()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsToMany(
            Parcours::class,
            'cactus_annonces_parcours', # Pivot
            'annonce_id',
            'parcours_id')
            ->withPivot('id')
            ->orderBy('cactus_annonces_parcours.updated_at', 'desc')
            ;
    }
}
