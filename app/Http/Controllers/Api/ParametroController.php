<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Api\UserRegister\StoreRegisterRequest;
use App\Repositories\ParametroRepository;


/**
 * Class ParametroController.
 */
class ParametroController extends Controller
{
    /**
     * @var ParametroRepository
     */
    protected $parametroRepository;

    /**
     * ParametroController constructor.
     *
     * @param  ParametroRepository  $parametroRepository
     */
    public function __construct(ParametroRepository $parametroRepository)
    {
        $this->parametroRepository = $parametroRepository;
    }

    /**
     * Obtiene el listado de opciones dependiendo el parametro.
     */
    public function getOptionsParametro($id_parametro)
    {
        return $this->parametroRepository->getOptionsParametro($id_parametro);
    }

    /**
     * Obtiene el listado de opciones de ciudades dependiendo el departamento.
     */
    public function getOptionsCiudad($departamento_id)
    {
        return $this->parametroRepository->getOptionsCiudad($departamento_id);
    }
}
