<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorLogs extends Model
{
    protected $table = 'sensor_logs';

    public $timestamps = false;

    public function rSensor(){
        return $this->belongsTo('App\Sensor','id_sensor');
    }
}
