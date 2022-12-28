<?php

use App\Http\Controllers\Api\AislamientoController;
use App\Http\Controllers\Api\CombustibleController;
use App\Http\Controllers\Api\ConvenioController;
use App\Http\Controllers\Api\ElectricidadController;
use App\Http\Controllers\Api\EmisionController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\EmpresaSedeController;
use App\Http\Controllers\Api\EstiercolController;
use App\Http\Controllers\Api\ExtintorController;
use App\Http\Controllers\Api\FermentacionController;
use App\Http\Controllers\Api\FertilizanteController;
use App\Http\Controllers\Api\FugaController;
use App\Http\Controllers\Api\LubricanteController;
use App\Http\Controllers\Api\ParametroController;
use App\Http\Controllers\Api\RefrigeranteController;
use App\Http\Controllers\Api\ViajeController;
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


Route::group(['middleware' => 'auth'], function () {
    // Convenios
    Route::get('/convenios',  function () {
        return view('administracion/convenio/index_convenio');
    });
    // Parametros
    Route::get('/parametros',  function () {
        return view('administracion/parametro/index_parametro');
    });
    Route::get('/parametros/create/{tipo_parametro_id}', [ParametroController::class, 'formParametro']);
    Route::get('/parametros/edit/{tipo_parametro_id}/{id_parametro}', [ParametroController::class, 'formParametro']);


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

    // Funtes 
    Route::get('/fuentes',  function () {
        return view('fuente/index_fuente');
    });

    //Combustibles
    Route::get('/combustibles/{tipo}/create', [CombustibleController::class, 'formCombustible']);
    Route::get('/combustibles/{tipo}/edit/{id}', [CombustibleController::class, 'formCombustible']);

    //Emisiones
    Route::get('/emisiones/{tipo}/create', [EmisionController::class, 'formEmision']);
    Route::get('/emisiones/{tipo}/edit/{id}', [EmisionController::class, 'formEmision']);

    //Estiercoles
    Route::get('/estiercoles/{tipo}/create', [EstiercolController::class, 'formEstiercol']);
    Route::get('/estiercoles/{tipo}/edit/{id}', [EstiercolController::class, 'formEstiercol']);

    //Fertilizantes
    Route::get('/fertilizantes/{tipo}/create', [FertilizanteController::class, 'formFertilizante']);
    Route::get('/fertilizantes/{tipo}/edit/{id}', [FertilizanteController::class, 'formFertilizante']);

    //Refrigerantes
    Route::get('/refrigerantes/create', [RefrigeranteController::class, 'formRefrigerante']);
    Route::get('/refrigerantes/edit/{id}', [RefrigeranteController::class, 'formRefrigerante']);

    //Extintores
    Route::get('/extintores/create', [ExtintorController::class, 'formExtintor']);
    Route::get('/extintores/edit/{id}', [ExtintorController::class, 'formExtintor']);

    //Lubricantes
    Route::get('/lubricantes/create', [LubricanteController::class, 'formLubricante']);
    Route::get('/lubricantes/edit/{id}', [LubricanteController::class, 'formLubricante']);

    //Fugas
    Route::get('/fugas/create', [FugaController::class, 'formFuga']);
    Route::get('/fugas/edit/{id}', [FugaController::class, 'formFuga']);

    //Aislamientos
    Route::get('/aislamientos/create', [AislamientoController::class, 'formAislamiento']);
    Route::get('/aislamientos/edit/{id}', [AislamientoController::class, 'formAislamiento']);

    //Fmentaciones
    Route::get('/fermentaciones/create', [FermentacionController::class, 'formFermentacion']);
    Route::get('/fermentaciones/edit/{id}', [FermentacionController::class, 'formFermentacion']);

    //Electricidades
    Route::get('/electricidades/create', [ElectricidadController::class, 'formElectricidad']);
    Route::get('/electricidades/edit/{id}', [ElectricidadController::class, 'formElectricidad']);

    //Viajes
    Route::get('/viajes/create', [ViajeController::class, 'formViaje']);
    Route::get('/viajes/edit/{id}', [ViajeController::class, 'formViaje']);

    // Autorizacion
    Route::get('/autorizaciones',  function () {
        return view('autorizacion/index_autorizacion');
    });

    // Resultado
    Route::get('/resultados',  function () {
        return view('resultado/index_resultado');
    });
});
