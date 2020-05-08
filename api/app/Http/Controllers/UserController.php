<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permissions;
use Hash;
use Session;
use App\ActionLogs;
use Carbon\Carbon;

class UserController extends Controller
{
    public function new(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $username = $request->username;
        $password = $request->password;
        
        $permissions = new Permissions;
        $permissions->sensors = FALSE;
        $permissions->actuators = FALSE;
        $permissions->readplot = FALSE;
        $permissions->writeplot = FALSE;
        $permissions->readgreenhouse = FALSE;
        $permissions->writegreenhouse = FALSE;
        $permissions->readusers = FALSE;
        $permissions->writeusers = FALSE;
        $permissions->save();

        $user = new User;
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->permissions = $permissions->id;
        $user->save();

        $data = $user;
        $message = 'Usuario guardado correctamente';

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

        $data = User::find($id);
        $message = 'Usuario encontrado';
        if ($data == null) {
            $message = "Usuario no encontrado";
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

        $data = User::all();
        $message = 'Usuarios encontrados';

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
        $username = $request->username;
        $password = $request->password;

        $user = User::find($id);
        $user->username = $username;
        if ($password != '') {
            $user->password = Hash::make($password);
        }
        $user->save();

        $data = $user;
        $message = 'Usuario guardado';

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

        $user = User::find($id);
        $user->rPermissions->delete();
        $user->delete();

        $message = 'Usuario eliminado';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function auth(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $username = $request->username;
        $password = $request->password;

        $user = User::where('username',$username)->first();
        if ($user == null) {
            $message = 'Usuario no registrado';
            $code = 404;
        }else{
            if (Hash::check($password,$user->password)) {
                $message = 'Éxito';
                Session::put('logged',true);
                Session::put('id',$user->id);
                Session::put('username',$user->username);
                Session::put('sensors',$user->rPermissions->sensors);
                Session::put('actuators',$user->rPermissions->actuators);
                Session::put('readplot',$user->rPermissions->readplot);
                Session::put('writeplot',$user->rPermissions->writeplot);
                Session::put('readgreenhouse',$user->rPermissions->readgreenhouse);
                Session::put('writegreenhouse',$user->rPermissions->writegreenhouse);
                Session::put('readusers',$user->rPermissions->readusers);
                Session::put('writeusers',$user->rPermissions->writeusers);
            }else{
                $message = 'La contraseña con coincide';
                $code = 401;
            }
        }

        //Lineas para bitacora de acciones
        $ActionLogs = new ActionLogs;
        $ActionLogs->date = Carbon::now()->toDateTimeString();
        $ActionLogs->actions = "Inicio de Sesión";
        $ActionLogs->id_user = Session::get('id');
        $ActionLogs->save();

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }

    public function deauth(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $message = 'Sesión Cerrada';

        //Lineas para bitacora de acciones
        $ActionLogs = new ActionLogs;
        $ActionLogs->date = Carbon::now()->toDateTimeString();
        $ActionLogs->actions = "Fin de Sesión";
        $ActionLogs->id_user = Session::get('id');
        $ActionLogs->save();

        Session::flush();

        return redirect('login');
        //return response()->json([
        //    'message'   => $message,
        //    'data'      => $data ,              
        //],$code);
    }

    public function getPermissions(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;

        $data = User::find($id);
        $message = 'Permisos Encontrados';
        if ($data == null) {
            $message = "Usuario no encontrado";
            $code = 404;
        }

        return response()->json([
            'message'   => $message,
            'data'      => $data->rPermissions ,              
        ],$code);
    }

    public function savePermissions(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $id = $request->id;
        $sensors = $request->sensors;
        $actuators = $request->actuators;
        $readgreenhouse = $request->readgreenhouse;
        $writegreenhouse = $request->writegreenhouse;
        $readplot = $request->readplot;
        $writeplot = $request->writeplot;
        $readusers = $request->readusers;
        $writeusers = $request->writeusers;

        $data = User::find($id);
        $message = 'Permisos Guardados';
        if ($data == null) {
            $message = "Usuario no encontrado";
            $code = 404;
        }
        $data->rPermissions->sensors = $sensors;
        $data->rPermissions->actuators = $actuators;
        $data->rPermissions->readgreenhouse = $readgreenhouse;
        $data->rPermissions->writegreenhouse = $writegreenhouse;
        $data->rPermissions->readplot = $readplot;
        $data->rPermissions->writeplot = $writeplot;
        $data->rPermissions->readusers = $readusers;
        $data->rPermissions->writeusers = $writeusers;
        $data->rPermissions->save();

        return response()->json([
            'message'   => $message,
            'data'      => $data->rPermissions ,              
        ],$code);
    }

    public function getUserToGrant(Request $request){
        $message = '';
        $data = null;
        $code = 200;

        $data = User::where('id','<>',Session::get('id'))->get();
        $message = 'Usuarios encontrados';

        return response()->json([
            'message'   => $message,
            'data'      => $data ,              
        ],$code);
    }
}
