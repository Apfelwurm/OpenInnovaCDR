<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
class InstallController extends Controller
{
    /**
     * Show Installation Page
     * @param  Event  $event
     * @return View
     */
    public function installation()
    {
        return view("install");
    }

    /**
     * Install App
     * @param  Request $request
     * @return Redirect
     */
    public function install(Request $request)
    {
        $rules = [
            'password1'     	=> 'required|same:password2|min:8',
            'username'      	=> 'required|unique:users,username',
        ];
        $messages = [
            'username.unique'       				=> 'Username must be unique',
            'username.required'     				=> 'Username is required',
            'password1.same'        				=> 'Passwords must be the same.',
            'password1.required'    				=> 'Password is required.',
            'password1.min'         				=> 'Password must be atleast 8 characters long.',
        ];
        $this->validate($request, $rules, $messages);

        // Create User
        $user 						= New User;
        $user->password       		= Hash::make($request->password1);
        $user->username         	= $request->username;
        $user->username_nice    	= strtolower(str_replace(' ', '-', $request->username));
        $user->isAdmin              = true;
        $user->save();
        Auth::login($user, true);


        // Clear Cache
        Artisan::call('config:clear');

        // Set Installed
        Setting::setInstalled();

        Session::flash('alert-info', 'Installation Complete. Have a look around the Settings to make sure everything is Hunky Dory and you are good to go!');
        return Redirect::to('/');
    }

}
