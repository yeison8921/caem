<?php

use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ParametroController;
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
        Route::get('getOptionsParametro/{id_parametro}', [ParametroController::class, 'getOptionsParametro']);
        Route::get('getOptionsCiudad/{departamento_id}', [ParametroController::class, 'getOptionsCiudad']);

        // Empresas
        Route::apiResource('empresas', EmpresaController::class);
        Route::get('getOptionsEmpresasSedes/{empresa_id}', [EmpresaController::class, 'getOptionsEmpresasSedes']);




        // Password Reset
        /*Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');*/
    });
});
