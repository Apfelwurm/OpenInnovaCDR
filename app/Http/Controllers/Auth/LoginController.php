<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    public function index()
    {

        // Check for Event
        $user = Auth::user();
        if ($user) {
            return redirect('/');
        }
        return view("login");
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin)
            {
                return redirect('/admin/');
            }
            else
            {
                return redirect('/');
            }

        }
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);


    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        if (Auth::logout()) {

                return redirect('/');
        }
            return Redirect::back()->withError('logout failed');


    }


}
