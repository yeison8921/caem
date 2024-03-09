<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResultadoFuenteEmision;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * The user has been authenticated.
     *
     * @param  Request  $request
     * @param $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->estado) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['error' => 'Su cuenta se encuentra bloqueda, por favor contacte al administrador']);
        }
        if ($user->rol_id != 2) {
            $this->redirectTo = RouteServiceProvider::RESULTADOS;
        } else {

            $resultados = ResultadoFuenteEmision::where([
                ['empresa_id', $user->empresa_id],
                ['sede_id', $user->sede_id]
            ])->get();

            if ($resultados->isEmpty()) {
                $this->redirectTo = RouteServiceProvider::PROCESOS;
            } else {
                $this->redirectTo = RouteServiceProvider::RESULTADOS;
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
