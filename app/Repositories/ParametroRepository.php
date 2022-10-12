<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Parametro;

/**
 * Class ParametroRepository.
 */
class ParametroRepository extends BaseRepository
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
        return Parametro::class;
    }

    public function getOptionsParametro($id_parametro)
    {
        $options = Parametro::where("tipo_parametro_id", $id_parametro)->get(['id as value', 'nombre as label']);
        return $options;
    }

    public function getOptionsCiudad($departamento_id)
    {
        $options = Parametro::where("parametro_id", $departamento_id)->get(['id as value', 'nombre as label']);
        return $options;
    }
}
