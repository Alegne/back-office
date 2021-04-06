<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_clubs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'description',
        'image',
    ];

    /**
     * Get the articles for the club.
     */
    public function articles()
    {
        # foreignKey
        return $this->hasMany(Article::class, 'club_id');
    }

    /**
     * Get the staffs for the club.
     */
    public function staffs()
    {
        # foreignKey
        return $this->hasMany(Staff::class, 'club_id');
    }
}
