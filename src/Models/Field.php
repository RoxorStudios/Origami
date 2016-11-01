<?php

namespace Origami\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{

    public $table = 'origami_fields';

    public $timestamps = false;

    protected $fillable = [
        'name', 'type', 'description', 'required', 'options', 'default', 'position',
    ];

    protected $casts = [
        'options' => 'json',
    ];

    /**
     * Save a module
     */
    public function save(array $options = array())
    {
        if(!$this->uid) $this->uid = origami_uid($this->table);
        $this->identifier = $this->makeIdentifier();
        if(!$this->position) $this->position = $this->module->fields()->max('position') + 1;
        if($this->default) {
            $this->module->fields()->update(['default'=>false]);
            $this->required = true;
        }
        parent::save($options);
        if($this->type=="module" && !$this->submodule) {
            $this->newSubmodule();
        }
        
        return $this;
    }

    /**
     * New submodule
     */
    private function newSubmodule()
    {
        $name = $this->module->identifier.'-'.$this->identifier;
        $module = $this->submodule()->create([
            'name' => $name,
            'list' => true,
            'sortable' => false,
        ]);
    }

    /**
     * Make identifier
     */
    protected function makeIdentifier()
    {
        $identifier = str_slug($this->name);
        $i=1;
        if($this->module->fields()->where('id','!=',$this->id)->where('identifier',$identifier)->count()) {
            do {
                $identifier = str_slug($this->name).'-'.$i;
                $i++;
            }
            while ($this->module->fields()->where('identifier',$identifier)->count());
        }
        return $identifier;
    }

    /**
     * Belongs to a module
     */
    public function module()
    {
        return $this->belongsTo('Origami\Models\Module');
    }

    /**
     * Has one submodule
     */
    public function submodule()
    {
        return $this->hasOne('Origami\Models\Module', 'field_id');
    }

    /**
     * Has many data
     */
    public function data()
    {
        return $this->hasMany('Origami\Models\Data');
    }

    /**
     * Has many images
     */
    public function images()
    {
        return $this->hasMany('Origami\Models\Image');
    }
    

}
