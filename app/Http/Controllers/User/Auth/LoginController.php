<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// class LoginController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Login Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles authenticating users for the application and
//     | redirecting them to your home screen. The controller uses a trait
//     | to conveniently provide its functionality to your applications.
//     |
//     */

//     use AuthenticatesUsers;

//     /**
//      * Where to redirect users after login.
//      *
//      * @var string
//      */
//     protected $redirectTo = '/home';

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }
// }



namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        return $this->loggedOut($request);
    }
    /**
     * ログアウトの処理
     * ルート指定 route('user.login')
     */
    public function loggedOut(Request $request)
    {
        return redirect(route('user.login'));
    }
    /**
     * ログイン後のリダイレクト先指定
     */
    public function redirectPath()
    {
        return 'board/index';
        //例）return 'costs/index';
    }

    /**
     * ゲストログイン機能
     * ゲストユーザー用のid指定
     * ゲストログイン処理
     */

    private const GUEST_USER_ID = 1;

    public function guestLogin()
    {
        if (Auth::loginUsingId(self::GUEST_USER_ID)) {
            return redirect('board/index');
        }
        return redirect('user/login');
    }
}
