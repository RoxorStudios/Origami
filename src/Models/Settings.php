<?php

namespace Origami\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    public $table = 'origami_settings';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'value',
    ];

    /**
     * Set
     */
    public static function set($name, $value)
    {
        $setting = Settings::firstOrNew(['name' => $name]);
        $setting->value = $value;
        $setting->save();
    }

    /**
     * Get
     */
    public static function get($name)
    {
        $setting = Settings::where('name', $name)->first();
        return $setting ? $setting->value : null;
    }

}
