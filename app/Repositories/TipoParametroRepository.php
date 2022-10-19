<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\TipoParametro;

/**
 * Class TipoParametroRepository.
 */
class TipoParametroRepository extends BaseRepository
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
        return TipoParametro::class;
    }
}
