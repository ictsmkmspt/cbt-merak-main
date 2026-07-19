<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'nama' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
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
        return User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected $username = 'email';

    /**
     * Redirect ke halaman guru setelah login berhasil.
     * Jika siswa login, middleware akan redirect ke halaman siswa.
     */
    protected $redirectTo = '/guru';
    protected $redirectAfterLogout = '/';

    /**
     * Dipanggil otomatis setelah login berhasil.
     * Membuat token sesi baru supaya sesi lama di perangkat lain otomatis
     * ter-invalidasi (deteksi multi-device / login bersamaan).
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        $token = str_random(40);
        $user->current_token = $token;
        $user->save();
        Session::put('current_token', $token);

        if ($user->status == 'P') {
            return redirect('/hasil-guru');
        }

        return redirect()->intended($this->redirectPath());
    }
}
