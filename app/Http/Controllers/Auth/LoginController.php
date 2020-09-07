<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function authenticate()
    {
        $data = session()->has('status');
          if ($data=="admin" or $data=="notulen" or $data=="pimpinan") {
             $username="nengki";
             $password="12345678";
          }
          else {
            Auth::logout();
        session()->flush();
             return redirect('/login');
          }
        
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            // Authentication passed...
            return redirect("/dashboard");
        }
    }

    function logout(){
        Auth::logout();
        session()->flush();
        session()->flash("alert","Membutuhkan Login...!!!");
        return redirect("/login");
    }
}
