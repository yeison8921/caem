<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRegister\StoreRegisterRequest;
use App\Repositories\RegisterRepository;
use App\Rules\Captcha;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
 * Class RegisterController.
 */
class RegisterController extends Controller
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
     * @var RegisterRepository
     */
    protected $registerRepository;

    /**
     * RegisterController constructor.
     *
     * @param  RegisterRepository  $registerRepository
     */
    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }


    /**
     * Create a new user instance after a valid registration.
     */
    protected function store(StoreRegisterRequest $data)
    {
        return $this->registerRepository->create($data->all());
    }
}
