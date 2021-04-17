<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Configuration extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cactus_configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cle',
        'valeur',
    ];

    public $timestamps = false;

    /**
     * @param $key
     */
    public static function get($key)
    {
        $setting = new self();
        $entry = $setting->where('cle', $key)->first();
        if (!$entry) {
            return;
        }
        return $entry->valeur;
    }

    /**
     * @param $key
     * @param null $value
     * @return bool
     */
    public static function set($key, $value = null)
    {
        $setting = new self();
        $entry = $setting->where('cle', $key)->firstOrFail();
        $entry->valeur = $value;

        $entry->saveOrFail();

        Config::set('cle', $value);
        if (Config::get($key) == $value) {
            return true;
        }
        return false;
    }
}
