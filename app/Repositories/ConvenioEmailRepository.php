<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\ConvenioEmail;
use Illuminate\Support\Facades\DB;

/**
 * Class ConvenioEmailRepository.
 */
class ConvenioEmailRepository extends BaseRepository
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
        return ConvenioEmail::class;
    }

    /**
     * @param array $data
     *
     * @return Convenio
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): ConvenioEmail
    {
        return DB::transaction(function () use ($data) {
            $convenio_email = ConvenioEmail::create($data);
            if ($convenio_email) {
                return $convenio_email;
            }

            throw new GeneralException(__('backend_convenio_email.exceptions.create_error'));
        });
    }
}
