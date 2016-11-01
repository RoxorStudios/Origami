<?php

namespace Origami\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Origami\Models\User;
use Origami\Models\Module;

use Auth;

class AuthController extends Controller
{

    /**
     * Login
     */
    public function login(Request $request)
    {	
    	return view('origami::auth.login');
    }

    /**
     * Do login
     */
    public function doLogin(Request $request)
    {
        $remember = $request->input('remember') ? true : false;

    	if(Auth::guard('origami')->attempt(['email'=>$request->input('email'),'password'=>$request->input('password')], $remember)) {
            return redirect()->intended('/origami');
        }

        return $this->login($request)->withError(true);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {   
        Auth::guard('origami')->logout();
        return redirect('/origami/login');
    }

}
