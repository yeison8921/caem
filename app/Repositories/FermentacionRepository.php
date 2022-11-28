<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Fermentacion;
use Illuminate\Support\Facades\DB;

/**
 * Class FermentacionRepository.
 */
class FermentacionRepository extends BaseRepository
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
        return Fermentacion::class;
    }

    /**
     * @param array $data
     *
     * @return Fermentacion
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): Fermentacion
    // {
    //     return DB::transaction(function () use ($data) {
    //         $fermentacion = Fermentacion::create($data);
    //         if ($fermentacion) {
    //             return $fermentacion;
    //         }

    //         throw new GeneralException(__('backend_fermentaciones.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function update($request, $id_fermentacion)
    // {
    //     $fermentacion = Fermentacion::find($id_fermentacion);
    //     $fermentacion->update($request->all());
    //     return $fermentacion;
    // }
}
