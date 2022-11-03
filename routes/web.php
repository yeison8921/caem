<?php

use App\Http\Controllers\Api\ConvenioController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\EmpresaSedeController;
use App\Http\Controllers\Api\ParametroController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Parametros
Route::get('/parametros',  function () {
    return view('administracion/parametro/index_parametro');
});
Route::get('/parametros/create/{tipo_parametro_id}', [ParametroController::class, 'formParametro']);
Route::get('/parametros/edit/{tipo_parametro_id}/{id_parametro}', [ParametroController::class, 'formParametro']);

// Convenios
Route::get('/convenios',  function () {
    return view('administracion/convenio/index_convenio');
});
Route::get('/convenios/create', [ConvenioController::class, 'formConvenio']);
Route::get('/convenios/edit/{id_convenio}', [ConvenioController::class, 'formConvenio']);

// Empresas
Route::get('/empresas',  function () {
    return view('administracion/empresa/index_empresa');
});
Route::get('/empresas/edit/{id_empresa}', [EmpresaController::class, 'formEmpresa']);

// Sedes
Route::get('/sedes',  function () {
    return view('administracion/sede/index_sede');
});
Route::get('/sedes/create/{empresa_id}', [EmpresaSedeController::class, 'crearSede']);
Route::get('/sedes/edit/{id_empresa_sede}', [EmpresaSedeController::class, 'actualizarSede']);

// Proceseo
Route::get('/procesos',  function () {
    return view('proceso/index_proceso');
});

// Autorizacion
Route::get('/autorizaciones',  function () {
    return view('autorizacion/index_autorizacion');
});

