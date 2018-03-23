<?php

namespace StreetWorks\Http\Controllers\Auth;

use Illuminate\Http\Request;
use StreetWorks\Models\User;
use Illuminate\Support\Facades\Validator;
use StreetWorks\Http\Controllers\Controller;
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
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \StreetWorks\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['username'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password'])
        ]);
    }

    /**
     * After registration.
     *
     * @param Request $request
     * @param         $user
     */
    protected function registered(Request $request, $user)
    {
        return $this->successResponse(compact('user'));
    }

    /**
     * Register user using Facebook.
     *
     * @param Request $request
     *
     * @return array
     */
    public function registerUsingFacebook(Request $request)
    {
        $this->validate($request, [
            'id'    => 'required',
            'name'  => 'required|string',
            'email' => 'required|email',
            'token' => 'required'
        ]);
        // Check if a user has connected or not
        $user = User::where('username', $request->input('id'))
            ->orWhere('facebook_id', $request->input('id'))
            ->first();

        return $user instanceof User ? $this->connectToFacebook($request, $user) : $this->createFromFacebook($request);
    }

    /**
     * Connect user to Facebook account.
     *
     * @param Request $request
     * @param         $user
     *
     * @return array
     */
    public function connectToFacebook(Request $request, $user): array
    {
        // Connect user to Facebook
        $user->facebook_token = $request->input('token');
        $user->facebook_id = $request->input('id');

        $user->save();

        return $this->successResponse([
            'registered'   => "false",
            'email'        => $user->email,
            'access_token' => $user->createToken('facebook', ['*'])->accessToken
        ]);
    }

    /**
     * Create user from Facebook account.
     *
     * @param Request $request
     *
     * @return array
     */
    public function createFromFacebook(Request $request): array
    {
        // Create user from Facebook
        $firstName = $request->input('name');
        $lastName = $request->input('name');
        // Get first and last name
        if ($names = explode(' ', $request->input('name'))) {
            $firstName = array_first($names);
            $lastName = array_last($names);
        }

        $username = $firstName . $lastName;

        // Check does username already exist
        if (User::where(compact('username'))->exists()) {
            $username = $username . '-' . str_random(4);
        }

        // Persist to database
        $user = User::create([
            'username'       => $username,
            'email'          => $request->input('email'),
            'facebook_id'    => $request->input('id'),
            'facebook_token' => $request->input('token'),
            'first_name'     => $firstName,
            'last_name'      => $lastName,
            'password'       => bcrypt($request->input('id'))
        ]);

        return $this->successResponse([
            'registered'   => "true",
            'email'        => $user->email,
            'access_token' => $user->createToken('facebook', ['*'])->accessToken
        ]);
    }
}
