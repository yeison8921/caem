<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\User;
use App\Notifications\SolicitudAprobarNotification;
use App\Notifications\AprobacionUsuarioSinConvenioNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param array $data
     *
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create($data);
            if ($user) {
                return $user;
            }

            throw new GeneralException(__('backend_users.exceptions.create_error'));
        });
    }

    /**
     * @param User  $user
     * @param array     $data
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            if ($user->update($data))
                return $user;

            throw new GeneralException("User update error");
        });
    }

    public function formUsuario($id_usuario)
    {
        $data = [];
        $data['id_usuario'] = $id_usuario;
        if ($id_usuario != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('administracion/usuario/form_usuario', $data);
    }

    public function checkContrasenaActual($request)
    {
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['success' => 'Contraseña correcta'], 200);
        } else {
            return response()->json(['error' => 'Contraseña incorrecta'], 500);
        }
    }

    public function actualizarContrasena($request)
    {
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function enviarNotificacionRegistroSinConvenio()
    {
        $users_admin = User::where('rol_id', 1)->get();

        foreach ($users_admin as $u) {
            Notification::route('mail', $u->email)->notify(new SolicitudAprobarNotification($u->first_name));
        }
    }

    public function enviarNotificacionAprobacionSinConvenio($request)
    {
        $user = User::where("email", $request->email)->first();
        $name = $user->first_name;
        $user->notify(new AprobacionUsuarioSinConvenioNotification($name));
    }
}
