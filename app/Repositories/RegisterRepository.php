<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class RegisterRepository.
 */
class RegisterRepository extends BaseRepository
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
        return User::class;
    }

    /**
     * @param array $data
     *
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data) : User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create($data);
            if ($user) {
                return $user;
            }

            throw new GeneralException(__('backend_users.exceptions.create_error'));
        });
    }
}
