<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspaceNumerique extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_espace_numeriques';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'description',
        'pieces_jointes',
        'niveau_id',
        'parcours_id',
        'enseignant_id'
    ];

    protected $casts = [
        # 'pieces_jointes' => 'json',
        # 'pieces_jointes' => 'array',
    ];


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
            'cactus_ent_parcours',
            'ent_id',
            'parcours_id')
            ->orderBy('cactus_ent_parcours.id', 'desc')
        ;
    }

    /**
     * Get the enseignant that owns the items.
     */
    public function enseignant()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Enseignant::class, 'enseignant_id', 'id');
    }

    /**
     * Get Piece jointe.
     *
     * @param  string  $value
     * @return string
     */
    public function getPiecesJointesAttribute($value)
    {
        # dd('get');
        return  json_decode($value);
    }

    /**
     * Set Piece Jointes.
     *
     * NOT Working
     *
     * @param  string  $value
     * @return void
     */
    public function setPieceJointesAttribute($value)
    {
        dd('set');
        $this->attributes['pieces_jointes'] = json_encode($value);
    }
}
