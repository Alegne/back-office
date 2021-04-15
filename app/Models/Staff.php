<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'club_id',
        'etudiant_id'
    ];


    /**
     * Get the club that owns the items.
     */
    public function club()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Club::class, 'club_id', 'id');
    }


    /**
     * Get the etudiant that owns the items.
     */
    public function etudiant()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id');
    }

}
