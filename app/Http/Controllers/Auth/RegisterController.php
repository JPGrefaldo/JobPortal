<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthServices;
use App\Services\UsersServices;
use App\Models\Site;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // @todo: create a validator for phone
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|confirmed|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:15',
            'receive_text' => 'required|numeric',
            'terms' => 'required|numeric'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /** @var UsersServices $service */
        $service = app(UsersServices::class);
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone']
        ];
        $notificationSettingsData = [
            'receive_sms' => $data['receive_text']
        ];

        return $service->create($userData, $notificationSettingsData);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        /** @var AuthServices $authServices */
        $user = $this->create($request->all());
        $site = Site::where('hostname', $request->getHost())->first();
        $authServices = app(AuthServices::class);

        $authServices->createCrew($user, $site);

        event(new Registered($user));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function redirectPath()
    {
        return 'login';
    }
}
