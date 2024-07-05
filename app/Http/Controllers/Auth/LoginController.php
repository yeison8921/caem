<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResultadoFuenteEmision;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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


    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {

            if (!$this->guard()->user()->estado) {
                auth()->logout();
                return redirect()->route('login')->withErrors(['error' => 'Su cuenta se encuentra bloqueda, por favor contacte al administrador']);
            } else {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }

                return $this->sendLoginResponse($request);
            }
        } else {
            $userState = $this->incrementLoginAttempts($request);

            if ($userState == 0) {
                return redirect()->route('login')->withErrors(['error' => 'Su cuenta se encuentra bloqueda, por favor contacte al administrador']);
            } else {
                return $this->sendFailedLoginResponse($request);
            }
        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->boolean('remember')
        );
    }

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
        $userTemp = User::where('email', $user->email)->first();
        $userTemp->intentos_fallidos_ingreso = 0;
        $userTemp->save();

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

    protected function incrementLoginAttempts(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $user->intentos_fallidos_ingreso = $user->intentos_fallidos_ingreso + 1;
            $user->save();

            if ($user->intentos_fallidos_ingreso >= 5) {
                $user->estado = 0;
                $user->save();
                return 0;
            } else {
                return 1;
            }
        } else {
            return $this->sendFailedLoginResponse($request);
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
