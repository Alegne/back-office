<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_etudiants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'email_verified_at',
        'password',
        'cin',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'status',
        'photo',
        'niveau_id',
        'parcours_id',
        'formation_id',
        'annee_universitaire_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_naissance',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        # 'is_admin' => 'boolean',
        'date_naissance' => 'date',
    ];


    /**
     * Get the niveau that owns the etudiants.
     */
    public function niveau()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Niveau::class, 'niveau_id', 'id');
    }

    /**
     * Get the parcours that owns the etudiants.
     */
    public function parcours()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Parcours::class, 'parcours_id', 'id');
    }

    /**
     * Get the formation that owns the etudiants.
     */
    public function formation()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Formation::class, 'formation_id', 'id');
    }

    /**
     * Get the annee universitaire that owns the etudiants.
     */
    public function annee()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(AnneeUniversitaire::class, 'annee_universitaire_id', 'id');
    }

    /**
     * get FullName
     */
    public function getFullName()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}
