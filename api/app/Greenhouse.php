<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Greenhouse extends Model
{
    protected $table = 'greenhouse';

    public $timestamps = false;

    public function rPlot(){
        return $this->hasMany('App\Plot','id_grenhouse');
    }

    public function rUserGreenhouse(){
        return $this->hasMany('App\User_greenhouse','id_greenhouse');
    }
}
