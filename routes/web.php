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
use App\Http\Controllers\Api\OtroController;
use App\Http\Controllers\Api\ParametroController;
use App\Http\Controllers\Api\PorcentajeCombustibleController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\RefrigeranteController;
use App\Http\Controllers\Api\TrasversalController;
use App\Http\Controllers\Api\UserController;
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
    if (auth()->user()) {
        return view('welcome');
    } else {
        return view('auth/login');
    }
});


//Restablecer contraseña
Route::get('/forgot-password', function () {
    return view('auth/passwords/email');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/welcome', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Route::group(['middleware' => 'auth'], function () {
    // Perfil
    Route::get('/perfil',  function () {
        return view('auth/perfil');
    });

    // Usuarios
    Route::get('/usuarios',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN])) {
            return view('administracion/usuario/index_usuario');
        }
        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });
    Route::get('/usuarios/create', [UserController::class, 'formUsuario']);
    Route::get('/usuarios/edit/{id_usuario}', [UserController::class, 'formUsuario']);

    // empresarios
    Route::get('/empresarios',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM])) {
            return view('administracion/usuario/index_empresario');
        }
        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    });

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
        if (in_array(auth()->user()->rol_id, [User::TYPE_LIDER_CAEM, User::TYPE_EMPRESARIO])) {
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

    // Autorizacion
    Route::get('/autorizaciones/huella',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM])) {
            return view('autorizacion/index_autorizacion_huella');
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
    Route::get('/viajes/{tipo}/create', [ViajeController::class, 'formViaje']);
    Route::get('/viajes/{tipo}/edit/{id}', [ViajeController::class, 'formViaje']);

    //Productos
    Route::get('/productos/{tipo}/create', [ProductoController::class, 'formProducto']);
    Route::get('/productos/{tipo}/edit/{id}', [ProductoController::class, 'formProducto']);

    //Trasversales
    Route::get('/trasversales/create', [TrasversalController::class, 'formTrasversal']);
    Route::get('/trasversales/edit/{id}', [TrasversalController::class, 'formTrasversal']);

    //Sf6
    Route::get('/otros/create', [OtroController::class, 'formOtro']);
    Route::get('/otros/edit/{id}', [OtroController::class, 'formOtro']);

    //Porcentajes
    Route::get('/porcentajes/edit/{id}', [PorcentajeCombustibleController::class, 'formPorcentaje']);

    // Resultado
    Route::get('/resultados',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM, User::TYPE_EMPRESARIO, User::TYPE_LIDER_CONVENIO])) {
            return view('resultado/index_resultado');
        }
        return redirect()->route('welcome')->withFlashDanger(__('You do not have access to do that.'));
    })->name('resultados');

    Route::get('/resultados-excel',  function () {
        if (in_array(auth()->user()->rol_id, [User::TYPE_ADMIN, User::TYPE_LIDER_CAEM, User::TYPE_LIDER_CONVENIO])) {
            return view('resultado/index_resultado_excel');
        }
        return redirect()->route('resultados')->withFlashDanger(__('You do not have access to do that.'));
    });

    //Video tutoriales
    Route::get('/videotutoriales',  function () {
        return view('index_videotutoriales');
    });

    //Contraseñas
    Route::get('/cambiar-contrasena', function () {
        return view('auth/passwords/reset');
    });
});
