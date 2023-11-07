<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo;

    public function redirectTo()
    {
        
        switch(Auth::user()->role()->first()->id){

            case 3:
                $this->redirectTo = '/';
                return $this->redirectTo;
                break;
            case 2:
                    $this->redirectTo = '/';
                return $this->redirectTo;
                break;
            case 1:
                $this->redirectTo = '/superadmin';
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;

        }
         
        // return $next($request);
    } 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout','showLoginFormSuperadmin']);
    }

    // Login
    public function showLoginForm()
    {
        
        $pageConfigs = ['bodyCustomClass' => 'login-bg', 'isCustomizer' => false];
        $formUrl = 'login';
        return view('/auth/login', [
            'pageConfigs' => $pageConfigs,
            'formUrl' => $formUrl
        ]);
    }

    // Login
    public function showLoginFormSuperadmin()
    {
        
        $pageConfigs = ['bodyCustomClass' => 'login-bg', 'isCustomizer' => false];
        $formUrl = 'superadmin-login';
        return view('/auth/login', [
            'pageConfigs' => $pageConfigs,
            'formUrl' => $formUrl
        ]);
    }

    public function login(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        $creadentials = array('email'=>$request->email,'password'=>$request->password);
        if(Auth::attempt($creadentials)){
            if(auth()->user()->option_for_block==1){
                Auth::logout();
                return redirect()->back()->with('error',__('auth.blocked'));
            }
            
            if(auth()->user()->role()->first()->id==1){
                return redirect()->intended('superadmin');
            }else{
                return redirect()->intended('/');
            }
        }
        else
        {
            return redirect()->back()->with('error',trans('auth.failed'));
        }
    }
    // // Login
    // public function postLoginFormSuperadmin()
    // {
        
    //     print_r(request()->all()); exit();
    // }

    public function logout()
    {
        //echo"hi";die;
        Auth::logout();
        return redirect()->to('login');
    }
}
