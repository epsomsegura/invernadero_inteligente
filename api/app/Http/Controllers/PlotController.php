<?php

namespace App\Http\Controllers;

use App\Greenhouse;
use App\Http\Controllers\Controller;
use App\Plot;
use Illuminate\Http\Request;
use App\User;
use Session;

class PlotController extends Controller
{
    function new (Request $request) {
        $message = '';
        $data = null;
        $code = 200;

        $plant = $request->plant;
        $greenhouse = $request->greenhouse;

        $plot = new Plot;
        $plot->plant = $plant;
        $plot->id_grenhouse = $greenhouse;
        $plot->save();

        $data = $plot;
        $message = 'Parcela guardada correctamente';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function read(Request $request)
    {
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;

        $data = Plot::find($id);
        $message = 'Parcela encontrada';
        if ($data == null) {
            $message = "Parcela no encontrada";
            $code = 404;
        }

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function readAll()
    {
        $message = '';
        $data = null;
        $code = 200;

        //$data = Plot::all();
        $data = array();
        $tempData = User::find(Session::get('id'))->rUserGreenhouse;
        foreach ($tempData as $key => $value) {
            foreach ($value->rGreenhouse->rPlot as $key2 => $value2) {
                $data[] = $value2;
            }
        }
        $message = 'Parcela encontrados';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function update(Request $request)
    {
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;
        $plant = $request->plant;
        $greenhouse = $request->greenhouse;

        $plot = Plot::find($id);
        $plot->plant = $plant;
        $plot->id_grenhouse = $greenhouse;
        $plot->save();

        $data = $plot;
        $message = 'Parcela guardada';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function delete(Request $request)
    {
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;

        $plot = Plot::find($id);
        foreach ($plot->rSensor as $key => $value) {
            $value->delete();
        }
        foreach ($plot->rActuator as $key => $value) {
            $value->delete();
        }
        $plot->delete();

        $message = 'Parcela eliminada';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function readByPlot(Request $request)
    {
        $message = '';
        $data = null;
        $code = 200;

        $id_greenhouse = $request->id_greenhouse;
        $plotByGreenhouse = Plot::where("id_greenhouse", $id_greenhouse)->get();

        $message = "Las parcelas son";

        return response()->json([
            'message' => $message,
            'data' => $plotByGreenhouse,
        ], $code);
    }

    public function notification(Request $request)
    {
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;
        $title = $request->title;
        $messageNoti = $request->messageNoti;

        $plot = Plot::find($id);
        $message = 'Parcela encontrada';
        if ($plot == null) {
            $message = "Parcela no encontrada";
            $code = 404;
        }

        $userGreenhouse = $plot->rGreenhouse->rUserGreenhouse;
        $users = array();
        foreach ($userGreenhouse as $key => $value) {
            $users[] = $value->id_user;
        }

        EngagespotPush::initialize('67VzxaRIwS1NciZZScbJrHHMbEWaUw', 'cnB4rjg1lCbcozDDXZ0u5bY4rtocz4');
        $data = ["campaignName" => "Parcela",
            "title" => $title,
            "message" => $messageNoti,
            "link" => "",
            "icon" => "http://engagespot.co/logo.png"];

        EngagespotPush::setMessage($data);
        EngagespotPush::addIdentifiers($users);
        EngagespotPush::send();
        $message = 'Mensaje enviado';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

}
