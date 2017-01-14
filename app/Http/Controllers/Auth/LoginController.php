<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

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
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function login(Request $request)
    {
        try {
            Auth::attempt(array('email' => $request->get('email'), 'password' => ($request->get('senha'))));
            return Redirect::intended('/'); //acessa o 'home'
            
        } catch (Exception $e) { dd($e);//caso nao tenha sido logado com sucesso 
            return back()->withErrors($e->getMessage())->withInput();
        }
    }
    
    public function logout() {

        if(Auth::check()) {
            Auth::logout(); 
        }
        return redirect("/");
    }
}
