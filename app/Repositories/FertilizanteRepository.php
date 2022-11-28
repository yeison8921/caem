<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Fertilizante;
use Illuminate\Support\Facades\DB;

/**
 * Class FertilizanteRepository.
 */
class FertilizanteRepository extends BaseRepository
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
        return Fertilizante::class;
    }

    /**
     * @param array $data
     *
     * @return Fertilizante
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): Fertilizante
    // {
    //     return DB::transaction(function () use ($data) {
    //         $fertilizante = Fertilizante::create($data);
    //         if ($fertilizante) {
    //             return $fertilizante;
    //         }

    //         throw new GeneralException(__('backend_fertilizantes.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function update($request, $id_refrigerante)
    // {
    //     $fertilizante = Fertilizante::find($id_refrigerante);
    //     $fertilizante->update($request->all());
    //     return $fertilizante;
    // }
}
