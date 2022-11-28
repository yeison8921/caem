<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Estiercol;
use Illuminate\Support\Facades\DB;

/**
 * Class EstiercolRepository.
 */
class EstiercolRepository extends BaseRepository
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
        return Estiercol::class;
    }

    /**
     * @param array $data
     *
     * @return Estiercol
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): Estiercol
    // {
    //     return DB::transaction(function () use ($data) {
    //         $estiercol = Estiercol::create($data);
    //         if ($estiercol) {
    //             return $estiercol;
    //         }

    //         throw new GeneralException(__('backend_estiercoles.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function update($request, $id_estiercol)
    // {
    //     $estiercol = Estiercol::find($id_estiercol);
    //     $estiercol->update($request->all());
    //     return $estiercol;
    // }
}
