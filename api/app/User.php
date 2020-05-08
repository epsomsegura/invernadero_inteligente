<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    
    public $timestamps = false;

    public function rPermissions(){
        return $this->belongsTo('App\Permissions','permissions');
    }

    public function rUserGreenhouse(){
        return $this->hasMany('App\UserGreenhouse','id_user');
    }
}
