<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\CallerPrefix;

class CallerPrefixController extends Controller
{
    public function index()
    {
         return view('admin.callerprefix.index')
        ->withUser(Auth::user())
        ->withCallerPrefixes(CallerPrefix::orderByDesc("prefix")->paginate(20));
    }

    public function show(CallerPrefix $callerPrefix)
    {
        return view('admin.callerprefix.show')
        ->withUser(Auth::user())
        ->withCallerPrefix($callerPrefix);
    }


    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $rules = [
            'prefix'     	=> 'required|numeric|unique:caller_prefixes,prefix',
        ];
        $messages = [
            'prefix.required'     				=> 'prefix is required',
            'prefix.number'     				=> 'prefix has to be a number',
            'prefix.unique'     				=> 'prefix exists already',

        ];
        $this->validate($request, $rules, $messages);

        // Create User
        $callerPrefix 						= New CallerPrefix;
        $callerPrefix->prefix         	= $request->prefix;

        if (!$callerPrefix->save()) {
            Session::flash('alert-danger', 'Cannot create caller prefix!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'Organisation Unit created!');
        return Redirect::to('/admin/callerprefixes/'.$callerPrefix->id);
    }

    public function update(Request $request, CallerPrefix $callerPrefix)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }


        if ($callerPrefix->prefix != $request->prefix)
        {
            $rules = [
                'prefix'     	=> 'required|numeric|unique:caller_prefixes,prefix',
            ];
            $messages = [
                'prefix.required'     				=> 'prefix is required',
                'prefix.number'     				=> 'prefix has to be a number',
                'prefix.unique'     				=> 'prefix exists already',

            ];
            $this->validate($request, $rules, $messages);

            $callerPrefix->prefix         	= $request->prefix;

            if (!$callerPrefix->save()) {
                Session::flash('alert-danger', 'Cannot update caller prefix!');
                return Redirect::back();
            }
        }



        Session::flash('alert-info', 'caller prefix updated!');
        return Redirect::to('/admin/callerprefixes/'.$callerPrefix->id);
    }

    public function remove(CallerPrefix $callerPrefix)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $callerPrefix->delete();

        return Redirect::to('/admin/callerprefixes/');
    }

}
