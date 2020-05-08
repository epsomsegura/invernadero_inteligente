<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;

class MainController extends Controller
{
    public function index(){
        $data = array();
        $tempData = User::find(Session::get('id'))->rUserGreenhouse;
        foreach ($tempData as $key => $value) {
            $count = 0;
            $rows = []; 
            $cells = [];
            foreach ($value->rGreenhouse->rPlot as $key2 => $value2) {
                $cells[$count] = $value2;
                $count++;
                if ($count == 3) {
                    $rows[] = $cells;
                    $cells = [];
                    $count = 0;
                }
            }    
            $rows[] = $cells;
            $cells = [];
            $count = 0;
            $value->rGreenhouse->rPlot = $rows;
            $data[] = $value->rGreenhouse;
        }

        //return response()->json([
        //    'data' => $data,
        //]);
        return view('main',["invernaderos" => $data]);
    }
}
