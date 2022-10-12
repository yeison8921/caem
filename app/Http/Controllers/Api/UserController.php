<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Registration\UpdateRegistrationRequest;
use App\Http\Requests\Api\UserRegister\StoreRegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param  UserRepository  $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = QueryBuilder::for(User::class)
            ->allowedIncludes([
                'role',
            ])
            ->allowedSorts([
                'id',
            ])
            ->defaultSort('-id')
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::exact('email'),
            ]);

        if (request('limit')) {
            return $query->paginate(request('limit') ?? 15);
        }

        return $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        var_dump("entra a show");
        return QueryBuilder::for(User::whereId($user->id))
            ->allowedIncludes([
                'role',
            ])
            ->allowedAppends([
                'last_name',
            ])->first();
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function store(StoreRegisterRequest $data)
    {
        return $this->userRepository->create($data->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegistrationRequest $request, User $user)
    {
        $this->userRepository->update($user, $request->all());

        return $user->fresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return $user->delete();
    }
}
