<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionLogs;
use App\Actuator;
use App\Plot;
use App\Sensor;
use Hash;

class ActuatorController extends Controller
{
    public function new(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $name = $request->name;
        $codename = $request->codename;
        $type = $request->type;
        $id_plot = $request->plot;
        $id_sensor = $request->sensor;

        $actuator = new Actuator;
        $actuator->name = $name;
        $actuator->codename = $codename;
        $actuator->type = $type;
        $actuator->id_plot = $id_plot;
        $actuator->id_sensor = $id_sensor;
        $actuator->save();

        $data = $actuator;
        $message = 'Actuador guardado correctamente';

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

        $data = Actuator::find($id);
        $message = 'Actuador encontrado';
        if ($data == null) {
            $message = "Actuador no encontrado";
            $code = 404;
        }

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function readByPlot(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id_plot = $request->plot;

        $data=Actuator::where("id_plot",$id_plot)->get();
        $message = 'Actuadores encontrados';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function readAll(){
        $message = '';
        $data = null;
        $code = 200;

        //$data = Actuator::all();
        $data = array();
        foreach ($tempData as $key => $value) {
            foreach ($value->rGreenhouse->rPlot as $key2 => $value2) {
                foreach ($value2->rActuator as $key3 => $value3) {
                    $data[] = $value3;
                }
            }
        }
        $message = 'Actuadores encontrados';

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
        $type = $request->type;
        $id_plot = $request->plot;
        $id_sensor = $request->sensor;

        $actuator = Actuator::find($id);
        $actuator->name = $name;
        $actuator->codename = $codename;
        $actuator->type = $type;
        $actuator->id_plot = $id_plot;
        $actuator->id_sensor = $id_sensor;
        $actuator->save();

        $data = $actuator;
        $message = 'Actuador guardado';

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

        $actuator = Actuator::find($id);
        //Pendiente QUE HACER CON REGISTROS EN LOGS
        $actuator->delete();

        $message = 'Actuador eliminado';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function associateSensor(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;
        $id_sensor = $request->sensor;

        $data = Actuator::find($id);
        $message = 'Actuador encontrado';
        if ($data == null) {
            $message = "Actuador no encontrado";
            $code = 404;
        }else {
            $actuator->id_sensor = $id_sensor;
            $actuator->save();
            $message = 'Sensor asociado al actuador';
        }

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

}
