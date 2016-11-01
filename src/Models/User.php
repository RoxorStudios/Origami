<?php

namespace Origami\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    public $table = 'origami_users';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email','admin', 'password', 'lastseen_at',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'lastseen_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set the password attribute
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Save an user
     */
    public function save(array $options = array())
    {
        if(!$this->uid) $this->uid = origami_uid($this->table);
        parent::save($options);
        return $this;
    }

}
