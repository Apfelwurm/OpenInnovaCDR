<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show Users Index Page
     * @return View
     */
    public function index()
    {
        return view('admin.users.index')
            ->withUser(Auth::user())
            ->withUsers(User::paginate(20));
    }

    /**
     * Show User Page
     * @return View
     */
    public function show(User $user)
    {
       return view('admin.users.show')
            ->withUser(Auth::user())
            ->withUserShow($user);
    }

    /**
     * Grant User Admin
     * @param  User  $user
     * @return View
     */
    public function grantAdmin(User $user)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $user->isAdmin = true;
        if (!$user->save()) {
            Session::flash('alert-danger', 'Cannot grant admin!');
            return Redirect::back();
        }
        Session::flash('alert-success', 'Successfully updated user!');
        return Redirect::back();
    }

    /**
     * Remove User Admin
     * @param  User  $user
     * @return View
     */
    public function removeAdmin(User $user)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $user->isAdmin = false;
        if (!$user->save()) {
            Session::flash('alert-danger', 'Cannot remove admin!');
            return Redirect::back();
        }
        Session::flash('alert-success', 'Successfully updated user!');
        return Redirect::back();
    }

    /**
     * Remove User
     * @param  User  $user
     * @return View
     */
    public function remove(User $user)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        if (!$user->delete()) {
            Session::flash('alert-danger', 'Cannot remove user!');
            return Redirect::back();
        }
        Session::flash('alert-success', 'Successfully removed user!');
        return Redirect::to('/admin/users/');
    }

     /**
     * Install App
     * @param  Request $request
     * @return Redirect
     */
    public function add(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
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
        $user->isAdmin              = ($request->isAdmin ? true : false);

        if (!$user->save()) {
            Session::flash('alert-danger', 'Cannot create user!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'User Created!');
        return Redirect::to('/admin/users/'.$user->id);
    }




}
