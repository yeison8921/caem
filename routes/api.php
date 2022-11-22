<?php

use App\Http\Controllers\Api\CombustibleController;
use App\Http\Controllers\Api\ConvenioController;
use App\Http\Controllers\Api\ConvenioEmailController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\EmpresaSedeController;
use App\Http\Controllers\Api\ExtintorController;
use App\Http\Controllers\Api\InformacionEmpresaController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LubricanteController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ParametroController;
use App\Http\Controllers\Api\RefrigeranteController;
use App\Http\Controllers\Api\TipoParametroController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['as' => 'auth.'], function () {
    Route::group(['middleware' => 'auth'], function () {
        // Authentication
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => 'guest'], function () {
        // Authentication
        //Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);

        // Registration
        Route::post('users', [RegisterController::class, 'store']);
        Route::apiResource('users', UserController::class);

        // Parametros
        Route::apiResource('tipo_parametros', TipoParametroController::class);
        Route::apiResource('parametros', ParametroController::class);
        Route::post('getEquiposConsumo', [ParametroController::class, 'getEquiposConsumo']);

        // Empresas
        Route::apiResource('empresas', EmpresaController::class);

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
