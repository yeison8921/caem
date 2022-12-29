<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Trasversal;
use Illuminate\Support\Facades\DB;

/**
 * Class TrasversalRepository.
 */
class TrasversalRepository extends BaseRepository
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
        return Trasversal::class;
    }

    /**
     * @param array $data
     *
     * @return Trasversal
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Trasversal
    {
        return DB::transaction(function () use ($data) {
            $trasversal = Trasversal::create($data);
            if ($trasversal) {
                return $trasversal;
            }

            throw new GeneralException(__('backend_trasversales.exceptions.create_error'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_trasversal)
    {
        $trasversal = Trasversal::find($id_trasversal);
        $trasversal->update($request->all());
        return $trasversal;
    }

    public function formTrasversal($id_trasversal)
    {
        $data = [];
        $data['id_trasversal'] = $id_trasversal;
        if ($id_trasversal != '') {
            $data['accion'] = 'Actualizar';
        } else {
            $data['accion'] = 'Crear';
        }
        return view('fuente/trasversal/form_trasversal', $data);
    }
}
