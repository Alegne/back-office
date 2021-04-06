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
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_debut',
        'date_fin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        # 'is_admin' => 'boolean',
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    /**
     * Get the items for the emploi du temps.
     */
    public function items()
    {
        # foreignKey
        return $this->hasMany(EmploiTempsItem::class, 'emploi_du_temps_id');
    }
}
