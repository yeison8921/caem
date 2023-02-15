<?php

use App\Http\Controllers\Api\AislamientoController;
use App\Http\Controllers\Api\CombustibleController;
use App\Http\Controllers\Api\ConvenioController;
use App\Http\Controllers\Api\ConvenioEmailController;
use App\Http\Controllers\Api\ElectricidadController;
use App\Http\Controllers\Api\EmisionController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\EmpresaSedeController;
use App\Http\Controllers\Api\EstiercolController;
use App\Http\Controllers\Api\ExtintorController;
use App\Http\Controllers\Api\FermentacionController;
use App\Http\Controllers\Api\FertilizanteController;
use App\Http\Controllers\Api\FuenteEmisionController;
use App\Http\Controllers\Api\FugaController;
use App\Http\Controllers\Api\InformacionEmpresaController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LubricanteController;
use App\Http\Controllers\Api\OtroController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ParametroController;
use App\Http\Controllers\Api\ProcesoController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\RefrigeranteController;
use App\Http\Controllers\Api\ResultadoFuenteEmisionController;
use App\Http\Controllers\Api\Sf6Controller;
use App\Http\Controllers\Api\TipoParametroController;
use App\Http\Controllers\Api\TrasversalController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViajeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    // Empresas
});

Route::group(['as' => 'auth.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::apiResource('empresas', EmpresaController::class);
        // Authentication
        //Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);

        // Registration
        Route::post('users', [RegisterController::class, 'store']);
        Route::apiResource('users', UserController::class);

        // Parametros
        Route::apiResource('tipo_parametros', TipoParametroController::class);
        Route::apiResource('parametros', ParametroController::class);


        // Informacion Empresas
        Route::apiResource('informacion_empresas', InformacionEmpresaController::class);

        // Sedes
        Route::apiResource('empresa_sedes', EmpresaSedeController::class);

        // Combustibles
        Route::apiResource('combustibles', CombustibleController::class);

        // Refrigerantes
        Route::apiResource('refrigerantes', RefrigeranteController::class);

        // Extintores
        Route::apiResource('extintores', ExtintorController::class);

        // Lubricantes
        Route::apiResource('lubricantes', LubricanteController::class);

        // Fugas
        Route::apiResource('fugas', FugaController::class);

        // Aislamientos
        Route::apiResource('aislamientos', AislamientoController::class);

        // Emisiones
        Route::apiResource('emisiones', EmisionController::class);

        // Fermentaciones
        Route::apiResource('fermentaciones', FermentacionController::class);

        // Estiercoles
        Route::apiResource('estiercoles', EstiercolController::class);

        // Fertilizantes
        Route::apiResource('fertilizantes', FertilizanteController::class);

        // Electricidades
        Route::apiResource('electricidades', ElectricidadController::class);

        // Viajes
        Route::apiResource('viajes', ViajeController::class);

        // Productos
        Route::apiResource('productos', ProductoController::class);

        // Trasversales
        Route::apiResource('trasversales', TrasversalController::class);

        // Sf6
        Route::apiResource('otros', OtroController::class);

        // Procesos
        Route::apiResource('procesos', ProcesoController::class);
        Route::post('guardarProcesos', [ProcesoController::class, 'guardarProcesos']);
        Route::post('recargarProcesos', [ProcesoController::class, 'recargarProcesos']);

        // Fuentes emisión
        Route::apiResource('fuentes_emision', FuenteEmisionController::class);
        Route::post('guardarFuentesEmision', [FuenteEmisionController::class, 'guardarFuentesEmision']);
        Route::post('recargarFuentesEmision', [FuenteEmisionController::class, 'recargarFuentesEmision']);
        Route::post('getFuentesEmision', [FuenteEmisionController::class, 'getFuentesEmision']);

        // Resultados fuente emision
        Route::apiResource('resultados_fuente_emision', ResultadoFuenteEmisionController::class);
        Route::post('guardarDatosConsumos', [ResultadoFuenteEmisionController::class, 'guardarDatosConsumos']);
        Route::post('getDatosGraficas', [ResultadoFuenteEmisionController::class, 'getDatosGraficas']);

        // Convenios
        Route::apiResource('convenios', ConvenioController::class);
        Route::apiResource('convenio_emails', ConvenioEmailController::class);
        Route::post('cambiarEstadoConvenio', [ConvenioController::class, 'cambiarEstadoConvenio']);
        Route::post('crearConvenioEmpresa', [ConvenioController::class, 'crearConvenioEmpresa']);

        // Password Reset
        /*Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');*/
    });
});
