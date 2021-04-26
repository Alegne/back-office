<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_albums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'photos',
    ];


    /**
     * Get Photos.
     *
     * @param  string  $value
     * @return string
     */
    public function getPhotosAttribute($value)
    {
        return  json_decode($value);
    }

    /**
     * Set Photos.
     *
     * @param  string  $value
     * @return void
     */
    public function setPhotosAttribute($value)
    {
        $this->attributes['photos'] = json_encode($value);
    }
}
