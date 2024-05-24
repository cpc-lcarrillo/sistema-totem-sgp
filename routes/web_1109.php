<?php

use GuzzleHttp\Psr7\Request;

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

Route::get('/', function () {
    return view('pantalla');

  
});
Route::get('/pantalla2', function () {
    return view('pantalla2');

  
});
Route::get('/pantallainterna', function () {
    return view('pantallainterna');

  
});
Route::get('/pantallatest', function () {
    return view('pantallatest');

  
});



Route::resource('totem','ControllerTotem');

Route::get('maderacelulosa', function () {
    return view('maderacelulosa');  
});

Route::get('noagendado', function () {
    return view('noagendado');
});

Route::get('agendado', function () {
    return view('agendado');
});
Route::get('importacion', function () {
    return view('importacion');
});
Route::get('madera', function () {
    return view('madera');
});
Route::get('celulosa', function () {
    return view('celulosa');
});
Route::get('reexpedicion', function () {
    return view('reexpedicion');
});
Route::get('cargasuelta1', function () {
    return view('cargasuelta1');
});
Route::get('cargasuelta2', function () {
    return view('cargasuelta2');
});
Route::get('Deposito-Atencion-General', function () {
    return view('Deposito-Atencion-General');
});
Route::get('Deposito-Atencion-General-Dry', function () {
    return view('Deposito-Atencion-General-Dry');
});
Route::get('Deposito-Atencion-General-Refeer', function () {
    return view('Deposito-Atencion-General-Refeer');
});



Route::post('ajaxPantalla', 'ControllerTotem@ajaxRequestPostPantalla');
Route::post('ajaxPantallahistorico', 'ControllerTotem@ajaxRequestPostPantallahistorico');
Route::post('ajaxPantallaultimollamado', 'ControllerTotem@ajaxRequestPostPantallaultimollamado');
Route::post('ajaxPantallacolaespera', 'ControllerTotem@ajaxRequestPostPantallacolaespera');
Route::post('ajaxPantallacolaespera22', 'ControllerTotem@ajaxRequestPostPantallacolaespera22');
Route::post('ajaxDestinoCamion', 'ControllerTotem@ajaxRequestPostDestinoCamion');



Route::get('ajaxPantalla2', 'ControllerTotem@ajaxRequestPostPantalla2');
Route::get('ajaxPantallahistorico2', 'ControllerTotem@ajaxRequestPostPantallahistorico2');
Route::get('ajaxPantallacolaespera2', 'ControllerTotem@ajaxRequestPostPantallacolaespera2');
Route::get('ajaxPantallaultimollamado2', 'ControllerTotem@ajaxRequestPostPantallaultimollamado2');


Route::get('ajaxDestinoCamion2', 'ControllerTotem@ajaxRequestPostDestinoCamion2');


Route::get('/Administrator', function () {
    return view('Administrator.login');

  
});
Route::resource('Administrator/login','ControllerLogin');

Route::resource('Administrator/Menu','ControllerMenu');

Route::resource('Administrator/Users','ControllerUsers');

Route::resource('Administrator/DelayIngreso','ControllerDelayIngreso');

Route::resource('Administrator/Misiones','ControllerMisiones');

Route::resource('Administrator/Agentes','ControllerAgentes');

Route::resource('Administrator/Distribucion','ControllerDistribucion');

Route::resource('Administrator/AgentesVentana','ControlleraAgentesVentanas');

Route::resource('Administrator/Ventanillas','ControllerVentanillas');

Route::resource('Administrator/Atendidos-por-Agentes','ControllerReportAtendidos');

Route::resource('Administrator/Tag','ControllerTag');
Route::resource('Administrator/Ubicacion-Camion','ControllerUbicacionCamion');
Route::resource('Administrator/numeros-espera','ControllerReportNumerosEspera');

// PASO A PRODUCCION 12-01-2023 Produccción
Route::resource('Administrator/Ocr','ControllerOCR');
Route::resource('Administrator/RegistroOCR','ControllerRegistroOCR');
Route::resource('Administrator/BloqueoHorarioFijo','ControllerBloqueoHorarioFijo');
Route::resource('Administrator/DesbloqueoHorarioDirigido','ControllerBloqueoDesbloqueoHorarioDirigido');
Route::get('HabilitacionTotem', 'ControllerTotem@ajaxRequestGetHabilitacionTotem');
// PASO A PRODUCCION 12-01-2023 Produccción

Route::get('1', function () {
    return view('1/pantalla2');  
});

// Route::get('Tablet', function () {
//     return view('Tablet/tablet');  
// });

Route::resource('Transportista','ControllerTransportista');

Route::resource('Tablet','ControllerTablet');

Route::post('ajaxTablet', 'ControllerTablet@ajaxRequestPostTablet');


Route::resource('Administrator/pruebas-tag','ControllerPruebasTag');

Route::resource('teccap','ControllerPruebasTeccap');


