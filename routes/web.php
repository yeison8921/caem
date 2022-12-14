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
use App\Http\Controllers\Api\Sf6Controller;
use App\Http\Controllers\Api\TrasversalController;
use App\Http\Controllers\Api\ViajeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
Route::get('/welcome', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Route::group(['middleware' => 'auth'], function () {
    // Convenios
    Route::get('/convenios',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return view('administracion/convenio/index_convenio');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });
    // Parametros
    Route::get('/parametros',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return view('administracion/parametro/index_parametro');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });
    Route::get('/parametros/create/{tipo_parametro_id}', [ParametroController::class, 'formParametro']);
    Route::get('/parametros/edit/{tipo_parametro_id}/{id_parametro}', [ParametroController::class, 'formParametro']);


    Route::get('/convenios/create', [ConvenioController::class, 'formConvenio']);
    Route::get('/convenios/edit/{id_convenio}', [ConvenioController::class, 'formConvenio']);

    // Empresas
    Route::get('/empresas',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM])) {
            return view('administracion/empresa/index_empresa');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });
    Route::get('/empresas/edit/{id_empresa}', [EmpresaController::class, 'formEmpresa']);

    // Sedes
    Route::get('/sedes',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM])) {
            return view('administracion/sede/index_sede');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });
    Route::get('/sedes/create/{empresa_id}', [EmpresaSedeController::class, 'crearSede']);
    Route::get('/sedes/edit/{id_empresa_sede}', [EmpresaSedeController::class, 'actualizarSede']);

    // Proceseo
    Route::get('/procesos',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM, User::TYPE_EMPRESARIO])) {
            return view('proceso/index_proceso');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });

    // Autorizacion
    Route::get('/autorizaciones',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM])) {
            return view('autorizacion/index_autorizacion');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });

    // Funtes
    Route::get('/fuentes',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return view('fuente/index_fuente');
        }

        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
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

    //Trasversales
    Route::get('/trasversales/create', [TrasversalController::class, 'formTrasversal']);
    Route::get('/trasversales/edit/{id}', [TrasversalController::class, 'formTrasversal']);

    //Sf6
    Route::get('/sf6s/create', [Sf6Controller::class, 'formSf6']);
    Route::get('/sf6s/edit/{id}', [Sf6Controller::class, 'formSf6']);

    // Resultado
    Route::get('/resultados',  function () {
        return view('resultado/index_resultado');
    });
});
