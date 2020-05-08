<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLogs extends Model
{
    protected $table = 'action_logs';

    public $timestamps = false;

    public function rUser(){
        return $this->belongsTo('App\User','id_user');
    }

    public function rActuator(){
        return $this->belongsTo('App\Actuator','id_actuator');
    }
}
