<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sensor;
use App\Plot;
use App\User;
use Session;

class SensorController extends Controller
{
    public function new(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $name = $request->name;
        $codename = $request->codename;
        $maxvalue = $request->maxvalue;
        $minvalue = $request->minvalue;
        $type = $request->type;
        $plot = $request->plot;
    
        $sensor = new Sensor;
        $sensor->name = $name;
        $sensor->codename = $codename;
        $sensor->maxvalue = $maxvalue;
        $sensor->minvalue = $minvalue;
        $sensor->type = $type;
 		$sensor->id_plot = $plot;
        $sensor->save();

        $data = $sensor;
        $message = 'Sensor guardado correctamente';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function read(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;

        $data = Sensor::find($id);
        $message = 'Sensor encontrado';
        if ($data == null) {
            $message = "Sensor no encontrado";
            $code = 404;
        }

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function readAll(){
        $message = '';
        $data = null;
        $code = 200;

        //$data = Sensor::all();
        $data = array();
        $tempData = User::find(Session::get('id'))->rUserGreenhouse;
        foreach ($tempData as $key => $value) {
            foreach ($value->rGreenhouse->rPlot as $key2 => $value2) {
                foreach ($value2->rSensor as $key3 => $value3) {
                    $data[] = $value3;
                }
            }
        }
        $message = 'Sensores encontrados';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function update(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;
        $name = $request->name;
        $codename = $request->codename;
	 	$maxvalue = $request->maxvalue;
        $minvalue = $request->minvalue;
        $type = $request->type;

        $sensor = Sensor::find($id);
        $sensor->name = $name;
        $sensor->codename = $codename;
        $sensor->maxvalue = $maxvalue;
        $sensor->minvalue = $minvalue;
        $sensor->type = $type;
        $sensor->save();

        $data = $sensor;
        $message = 'Sensor guardado';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function delete(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;

        $sensor = Sensor::find($id);
        foreach ($sensor->rActuator as $key => $value) {
            $value->id_sensor = NULL;
            $value->save();
        }
        //Pendiente QUE HACER CON REGISTROS EN LOGS
        $sensor->delete();

        $message = 'Sensor eliminado';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }
    public function readBySensores(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id_plot = $request->id_plot;
        $sensorByPlot = Sensor::where("id_plot", $id_plot)->get();
        
        $message = "los sensores";

        return response()->json([
            'message'   => $message,
            'data'      => $sensorByPlot ,              
        ],$code);
    }

}
