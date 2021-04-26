<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'posteur',
        'slug',
        'image',
        'galerie',
        'club_id',
    ];

    /**
     * Get the club that owns the article.
     */
    public function club()
    {
        # related, foreignKey, ownerKey, relation
        return $this->belongsTo(Club::class, 'club_id', 'id');
    }

    /**
     * Get Galerie.
     *
     * @param  string  $value
     * @return string
     */
    public function getGalerieAttribute($value)
    {
        return  json_decode($value);
    }

    /**
     * Set Galerie.
     *
     * @param  string  $value
     * @return void
     */
    public function setGalerieAttribute($value)
    {
        $this->attributes['galerie'] = json_encode($value);
    }
}
