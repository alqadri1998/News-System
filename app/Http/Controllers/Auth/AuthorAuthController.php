<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorAuthController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $guard = 'author';
    protected $maxAttempts = 4;
    protected $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('guest:author')->except('logout');
    }

    public function showLoginView(){
        return view('cms.author.auth.login');
    }

    public function login(Request $request){

        $request->validate([
            'email'=>'required|email|string',
            'password'=>'required|string|min:3|max:10',
            'remember_me'=>'string|in:on'
        ]);

        $rememberMe = $request->remember_me == 'on' ? true : false;

        if ($this->hasTooManyLoginAttempts($request)){
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $credentials = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if (Auth::guard('author')->attempt($credentials, $rememberMe)){

            $user = Auth::guard('author')->user();
            if ($user->status == "Active"){
                return redirect()->route('cms.admin.dashboard');
            }else{
                // return redirect()->route('cms.author.blocked');
            }
        }else{
            $this->incrementLoginAttempts($request);
            return redirect()->back()->withInput();
        }
    }

    public function logout(Request $request){
        Auth::guard('author')->logout();
        $request->session()->invalidate();
        return redirect()->guest(route('cms.author.login_view'));
    }
}
