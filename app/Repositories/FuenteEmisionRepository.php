<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\FuenteEmision;
use Illuminate\Support\Facades\DB;

/**
 * Class FuenteEmisionRepository.
 */
class FuenteEmisionRepository extends BaseRepository
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
        return FuenteEmision::class;
    }

    /**
     * @param array $data
     *
     * @return FuenteEmision
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): FuenteEmision
    // {
    //     return DB::transaction(function () use ($data) {
    //         $fuente_emision = FuenteEmision::create($data);
    //         if ($fuente_emision) {
    //             return $fuente_emision;
    //         }

    //         throw new GeneralException(__('backend_Fuentes_emision.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_fuente_emision)
    {
        $fuente_emision = FuenteEmision::find($id_fuente_emision);
        $fuente_emision->update($request->all());
        return $fuente_emision;
    }
}
