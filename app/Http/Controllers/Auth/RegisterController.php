<?php

namespace App\Http\Controllers\Auth;

use DB;
use Session;
use App\User;
use App\Invite;
use App\Http\Controllers\Controller;
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
     * Where to redirect users after login / registration.
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
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users|no_spaces',
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
    protected function create (array $data)
    {
        // explicity set user role, even though default is 'user'
        $role = 'user';

        // check user register code exists
        if ($data['code'] !== '') {
            // code is present and not empty, let's get the details of Invite from db
            $invite = DB::table('invites')->where('code', '=', $data['code'])->first();

            $register_using_code = false;

            // let's make sure the code was linked to a valid instance of Invite.
            if ($invite != null) {
                // set the role as per the invite
                $role = $invite->role;

                // delete the invite
                DB::table('invites')->where('email', '=', $invite->email)->delete();

                $register_using_code = true;

            }

            Session::put('register_using_code', $register_using_code);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $role,
            'password' => bcrypt($data['password']),
        ]);
    }
}
