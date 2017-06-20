<?php

namespace Origami\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{

    public $table = 'origami_data';

    public $timestamps = false;

    protected $fillable = [
        'value',
    ];

    /**
     * Belongs to a field
     */
    public function field()
    {
        return $this->belongsTo('Origami\Models\Field');
    }

    /**
     * Has many images
     */
    public function images()
    {
        return $this->hasMany('Origami\Models\Image');
    }

    /**
     * Belongs to an entry
     */
    public function entry()
    {
        return $this->belongsTo('Origami\Models\Entry');
    }

}
