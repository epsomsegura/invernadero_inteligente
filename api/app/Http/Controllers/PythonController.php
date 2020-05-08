<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plot;


class PythonController extends Controller
{
    public function sendConfig(Request $request){
        $plot = Plot::find($request->id);
        if ($plot == null) {
            echo 'nodata';
        }else{
            $string = 'cnf?';
            foreach ($plot->rSensor as $key => $value) {
                $string .= $value->codename;
                $string .= ':';
                $string .= $value->maxvalue;
                $string .= ',';
                $string .= $value->minvalue;
                $string .= '|';
            }
            $string = substr(trim($string), 0, -1).';';
            //pendiente valores de los actuadores.
            
            echo $string;
        }
    }

    public function reciveData(){

    }
}
