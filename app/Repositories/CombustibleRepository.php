<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Combustible;
use Illuminate\Support\Facades\DB;

/**
 * Class CombustibleRepository.
 */
class CombustibleRepository extends BaseRepository
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
        return Combustible::class;
    }

    /**
     * @param array $data
     *
     * @return Combustible
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): Combustible
    // {
    //     return DB::transaction(function () use ($data) {
    //         $combustible = Combustible::create($data);
    //         if ($combustible) {
    //             return $combustible;
    //         }

    //         throw new GeneralException(__('backend_combustibles.exceptions.create_error'));
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
    //     $combustible = Combustible::find($id_refrigerante);
    //     $combustible->update($request->all());
    //     return $combustible;
    // }
}
