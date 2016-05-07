<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if (Input::hasFile('image') && Input::file('image')->isValid()) 
        {
            $file = Input::file('image');
            $destinationPath = public_path(). '/users_pictures/';
            $extension = Input::file('image')->getClientOriginalExtension();
            $filename = $data['name'].'.'.$extension;
            Input::file('image')->move($destinationPath, $filename);
            $imagepath = '/users_pictures/'.$filename;
            return User::create([
            'name' => $data['name'],
            'image' => $imagepath,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);
        }
        else
        {
            
            return User::create([
            'name' => $data['name'],
            'image' => '/users_pictures/co.png',
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);
        }

        
    }
}
