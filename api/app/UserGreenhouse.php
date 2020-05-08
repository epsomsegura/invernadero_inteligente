<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGreenhouse extends Model
{
    protected $table = 'user_greenhouse';
    
    public $timestamps = false;

    public function rUser(){
        return $this->belongsTo('App\User','id_user');
    }

    public function rGreenhouse(){
        return $this->belongsTo('App\Greenhouse','id_greenhouse');
    }
}
