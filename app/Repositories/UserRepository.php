<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
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

       /**
     * @param User  $user
     * @param array     $data
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(User $user, array $data) : User
    {
        return DB::transaction(function () use ($user, $data) {
            if ($user->update($data))
                return $user;

            throw new GeneralException("User update error");
        });
    }
}
