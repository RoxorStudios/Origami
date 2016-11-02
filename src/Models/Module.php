<?php

namespace Origami\Models;

use DB;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	
    public $table = 'origami_modules';

    protected $fillable = [
        'name', 'identifier', 'position', 'list', 'only_admin', 'sortable', 'dashboard', 'options',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'options' => 'json',
    ];

    /**
     * Scope accessible
     */
    public function scopeAccessible($query)
    {
        if(!Auth::guard('origami')->user() || !Auth::guard('origami')->user()->admin)
            return $query->where('only_admin', false);
    }

    /**
     * Get default field value
     */
    public function getDefaultFieldAttribute()
    {
        $field = $this->fields()->whereIn('type',['text','textarea'])->orderBy('default','DESC')->orderBy('position','ASC')->first();
        if(!$field) return 'UID';
        
        return $field->name;
    }

    /**
     * Save a module
     */
    public function save(array $options = array())
    {
        if(!$this->uid) $this->uid = origami_uid($this->table);
        $this->identifier = $this->makeIdentifier();
        if(!$this->position) $this->position = Module::max('position') + 1;
        parent::save($options);
        return $this;
    }

    /**
     * Make identifier
     */
    protected function makeIdentifier()
    {
        $identifier = str_slug($this->name);
        $i=1;
        if(DB::table($this->table)->where('id','!=',$this->id)->where('identifier',$identifier)->count()) {
            do {
                $identifier = str_slug($this->name).'-'.$i;
                $i++;
            }
            while (DB::table($this->table)->where('identifier',$identifier)->count());
        }
        return $identifier;
    }

    /**
     * Belongs to a field
     */
    public function field()
    {
        return $this->belongsTo('Origami\Models\Field', 'field_id');
    }

    /**
     * Has many fields
     */
    public function fields()
    {
        return $this->hasMany('Origami\Models\Field')->orderBy('position','ASC')->orderBy('id','DESC');
    }

    /**
     * Has many entries
     */
    public function entries()
    {
        return $this->hasMany('Origami\Models\Entry')->orderBy('position','ASC')->orderBy('id','DESC');
    }

    /**
     * Has many data
     */
    public function data()
    {
        return $this->hasManyThrough('Origami\Models\Data', 'Origami\Models\Entry');
    }

}
