<?php

namespace App\Http\Controllers;

use App\Greenhouse;
use Illuminate\Http\Request;
use App\Plot;
use App\User;
use App\UserGreenhouse;
use Hash;
use Session;

class GreenhouseController extends Controller
{
    function new (Request $request) {
        $message = '';
        $data = null;
        $code = 200;
        //Control de permisos
        if (Session::get('writegreenhouse') == 1) {
            $message = '';
            $data = null;
            $code = 200;

            $address = $request->address;

            $greenhouse = new Greenhouse;
            $greenhouse->address = $address;
            $greenhouse->save();

            $user = User::find(Session::get('id'));
            $userGreenhouse = new UserGreenhouse;
            $userGreenhouse->id_user = $user->id;
            $userGreenhouse->id_greenhouse = $greenhouse->id;
            $userGreenhouse->save();

            $data = $greenhouse;
            $message = 'Invernadero guardado correctamente';
        }else{
            $message = 'No autorizado';
            $code = 401;
        }    
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

        if (Session::get('readgreenhouse') == 1) {
            $id = $request->id;

            $data = Greenhouse::find($id);
            $message = 'Invernadero encontrado';
            if ($data == null) {
                $message = "Invernadero no encontrado";
                $code = 404;
            }
        }else{
            $message = 'No autorizado';
            $code = 401;
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

        //$data = Greenhouse::all();
        $data = array();
        $tempData = User::find(Session::get('id'))->rUserGreenhouse;
        foreach ($tempData as $key => $value) {
            $data[] = $value->rGreenhouse;
        }
        $message = 'Invernaderos encontrados';

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
        $address = $request->address;

        $greenhouse = Greenhouse::find($id);
        $greenhouse->address = $address;
        $greenhouse->save();

        $data = $greenhouse;
        $message = 'Invernadero guardado';

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

        $greenhouse = Greenhouse::find($id);
        foreach ($greenhouse->rPlot as $key => $value) {
            $value->delete();
        }
        $greenhouse->delete();

        $message = 'Invernadero eliminado';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function getGreenhouseToGrant(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;

        $greenhousesGranted = UserGreenhouse::where('id_user',$id)->get();
        $allGreenhouses = Greenhouse::all();

        $idsGranteds = [];
        foreach ($greenhousesGranted as $key => $value) {
            $idsGranteds[] = $value->id_greenhouse;
        }

        $greenhousesNotGranted = [];
        foreach ($allGreenhouses as $key => $value) {
            if (!in_array($value->id,$idsGranteds)) {
                $greenhousesNotGranted[] = $value;
            }
        }
        
        $data = $greenhousesNotGranted;

        $message = 'Invernaderos encontrados';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function saveGrant(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $idUser = $request->idUser;
        $idGreenhouse = $request->idGreenhouse;

        $grantrow = new UserGreenhouse;
        $grantrow->id_user = $idUser;
        $grantrow->id_greenhouse = $idGreenhouse;
        $grantrow->save();
        
        $message = 'Permiso otorgado';

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

}
