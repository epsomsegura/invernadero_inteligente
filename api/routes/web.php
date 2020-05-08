<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','MainController@index',['as' => 'home']);

Route::get('/invernadero', ['as' => 'invernadero',function () {
    return view('invernadero');
}]);

Route::get('/parcelas', ['as' => 'parcelas',function () {
    return view('parcelas');
}]);

Route::get('/sensores', ['as' => 'sensores',function () {
    return view('sensores');
}]);

Route::get('/actuadores', ['as' => 'actuadores',function () {
    return view('actuadores');
}]);

Route::get('/usuarios', ['as' => 'usuarios',function () {
    return view('usuarios');
}]);

Route::get('/login', ['as' => 'login',function () {
    return view('login');
}]);

//Routes for users
Route::post('user/new','UserController@new');
Route::post('user/get','UserController@read');
Route::post('user/get/all','UserController@readAll');
Route::post('user/update','UserController@update');
Route::post('user/delete','UserController@delete');
Route::post('user/auth','UserController@auth');
Route::get('user/deauth','UserController@deauth');
Route::post('user/permissions/get','UserController@getPermissions');
Route::post('user/permissions/save','UserController@savePermissions');
Route::post('user/permissions/grant/get','UserController@getUserToGrant');


//Routes for greenhouses
Route::post('greenhouse/new','GreenhouseController@new');
Route::post('greenhouse/get','GreenhouseController@read');
Route::post('greenhouse/get/all','GreenhouseController@readAll');
Route::post('greenhouse/update','GreenhouseController@update');
Route::post('greenhouse/delete','GreenhouseController@delete');
Route::post('greenhouse/permissions/grant/list','GreenhouseController@getGreenhouseToGrant');
Route::post('greenhouse/permissions/grant/save','GreenhouseController@saveGrant');

//Routes for Plot
Route::post('plot/new','PlotController@new');
Route::post('plot/get','PlotController@read');
Route::post('plot/get/all','PlotController@readAll');
Route::post('plot/update','PlotController@update');
Route::post('plot/delete','PlotController@delete');

//Routes for sensors
Route::post('sensor/new','SensorController@new');
Route::post('sensor/get','SensorController@read');
Route::post('sensor/get/all','SensorController@readAll');
Route::post('sensor/update','SensorController@update');
Route::post('sensor/delete','SensorController@delete');
Route::post('sensor/get/by/plot','SensorController@readBySensores');

//Routes for actuators
Route::post('actuator/new','ActuatorController@new');
Route::post('actuator/get','ActuatorController@read');
Route::post('actuator/get/byPlot','ActuatorController@readByPlot');
Route::post('actuator/get/all','ActuatorController@readAll');
Route::post('actuator/update','ActuatorController@update');
Route::post('actuator/delete','ActuatorController@delete');
Route::post('actuator/associate/sensor','ActuatorController@associateSensor');