<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensor';
    
    public $timestamps = false;

    public function rPlot(){
        return $this->belongsTo('App\Plot','id_plot');
    }

    public function rActuator(){
        return $this->hasMany('App\Actuator','id_sensor');
    }
}
