<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Viaje;
use Illuminate\Support\Facades\DB;

/**
 * Class ViajeRepository.
 */
class ViajeRepository extends BaseRepository
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
        return Viaje::class;
    }

    /**
     * @param array $data
     *
     * @return Viaje
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): Viaje
    // {
    //     return DB::transaction(function () use ($data) {
    //         $viaje = Viaje::create($data);
    //         if ($viaje) {
    //             return $viaje;
    //         }

    //         throw new GeneralException(__('backend_viajes.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function update($request, $id_viaje)
    // {
    //     $viaje = Viaje::find($id_viaje);
    //     $viaje->update($request->all());
    //     return $viaje;
    // }
}
