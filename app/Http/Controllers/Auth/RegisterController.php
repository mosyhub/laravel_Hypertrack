<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
<<<<<<< HEAD
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

=======

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
>>>>>>> 0ccc2e41ec5bd0c2ba7c2d1ebc143c2df30d1264
    public function __construct()
    {
        $this->middleware('guest');
    }

<<<<<<< HEAD
=======
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
>>>>>>> 0ccc2e41ec5bd0c2ba7c2d1ebc143c2df30d1264
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
<<<<<<< HEAD
            'profile_picture' => ['nullable', 'image', 'max:2048'], // ✅ validate image
        ]);
    }

    protected function create(array $data)
    {
        $profilePicturePath = null;

        // ✅ Check and upload profile picture if exists
        if (request()->hasFile('profile_picture')) {
            $profilePicturePath = request()->file('profile_picture')->store('profile_pictures', 'public');
        }

=======
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
>>>>>>> 0ccc2e41ec5bd0c2ba7c2d1ebc143c2df30d1264
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
<<<<<<< HEAD
            'profile_picture' => $profilePicturePath, // ✅ save file path
=======
>>>>>>> 0ccc2e41ec5bd0c2ba7c2d1ebc143c2df30d1264
        ]);
    }
}
