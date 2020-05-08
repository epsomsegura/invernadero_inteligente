<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $table = 'plot';
    
    public $timestamps = false;

    public function rGreenhouse(){
        return $this->belongsTo('App\Greenhouse','id_greenhouse');
    }

    public function rSensor(){
        return $this->hasMany('App\Sensor','id_plot');   
    }

    public function rActuator(){
        return $this->hasMany('App\Actuator','id_plot');   
    }
}
