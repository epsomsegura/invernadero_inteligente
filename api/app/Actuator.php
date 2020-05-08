<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actuator extends Model
{
    protected $table = 'actuator';

    public $timestamps = false;

    public function rPlot(){
        return $this->belongsTo('App\Plot','id_plot');
    }
    
    public function rSensor(){
        return $this->belongsTo('App\Sensor','id_sensor');
    }
}
