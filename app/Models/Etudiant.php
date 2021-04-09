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
        'numero',
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
        # 'niveau_id',
        'parcours_id',
        # 'formation_id',
        # 'annee_universitaire_id'
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
        return $this->belongsToMany(
            Niveau::class,
            AnneeUniversitaire::class, # Pivot
            'etudiant_id',
            'niveau_id')
            ->withPivot('id')
            ->orderBy('cactus_annee_universitaires.id', 'desc')
            ;
    }


    /**
     * Get the libelle anneeUniversitaire that owns the etudiants.
     */
    public function annee()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsToMany(
            AnneeUniversitaireLibelle::class,
            AnneeUniversitaire::class, # Pivot
            'etudiant_id',
            'annee_id')
            ->withPivot('id')
            ->orderBy('cactus_annee_universitaires.id', 'desc')
            ;
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
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function formation()
    {
        return null # $this
            # ->niveau()
            # ->where('formation_id', '=', $formation)
            # ->first('formation_id')
            # ->formation()
            ;

        # return $this->hasOneThrough(
        #     Formation::class,
        #     Niveau::class,
        #     # AnneeUniversitaire::class,
        #     'etudiant_id',
        #     'formation_id',
        #     'id',
        #     'id');
    }

    # /**
    #  * Get the annee universitaire that owns the etudiants.
    #  */
    # public function annee()
    # {
    #     # related, foreignKey, ownerKey, relation
    #     return $this->hasMany(AnneeUniversitaire::class, 'etudiant_id', 'id');
    # }

    /**
     * get FullName
     */
    public function getFullNameAttribute()
    {
        return "{$this->nom} {$this->prenom}";
    }
}
