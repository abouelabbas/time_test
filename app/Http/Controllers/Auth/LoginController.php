<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:client')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(url('/index'));
        }
        return redirect()->back()->withInput($request->only(['email', 'remember']));
    }

    
    public function logout(Request $request)
    {
        $this->guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();

         return $this->loggedOut($request) ?: redirect('/index');
    }
}
