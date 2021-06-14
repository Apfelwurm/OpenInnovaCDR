<?php

namespace App\Http\Controllers\Admin;

use App\Models\Caller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class CallerController extends Controller
{
    public function index()
    {
         return view('admin.callers.index')
        ->withUser(Auth::user())
        ->withCallers(Caller::paginate(20));
    }

    public function show(Caller $caller)
    {
        return view('admin.callers.show')
        ->withUser(Auth::user())
        ->withCaller($caller);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $rules = [
            'name'     	=> 'required|unique:callers,name',
            'number'     	=> 'required|unique:callers,number',
        ];
        $messages = [
            'name.required'     				=> 'Name is required',
            'name.unique'     				=> 'Name exists already',
            'number.required'     				=> 'Number is required',
            'number.unique'     				=> 'Number exists already',

        ];
        $this->validate($request, $rules, $messages);

        // Create User
        $caller 						= New Caller;
        $caller->number         	= $request->number;
        $caller->name         	= $request->name;

        if (!$caller->save()) {
            Session::flash('alert-danger', 'Cannot create Caller!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'Caller created!');
        return Redirect::to('/admin/callers/'.$caller->id);
    }

    public function update(Request $request, Caller $caller)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $changed = false;

        if ($caller->name != $request->name)
        {
            $rules = [
                'name'     	=> 'required|unique:callers,name',
            ];
            $messages = [
                'name.required'     				=> 'Name is required',
                'name.unique'     				=> 'Name exists already',
            ];
            $this->validate($request, $rules, $messages);

            $caller->name         	= $request->name;
            $changed = true;

        }

        if ($caller->number != $request->number)
        {
            $rules = [
                'number'     	=> 'required|unique:callers,number',
            ];
            $messages = [
                'number.required'     				=> 'Number is required',
                'number.unique'     				=> 'Number exists already',
            ];
            $this->validate($request, $rules, $messages);

            $caller->number         	= $request->number;
            $changed = true;
        }

        if ($changed)
        {
            if (!$caller->save()) {
                Session::flash('alert-danger', 'Cannot update Caller!');
                return Redirect::back();
            }
        }

        Session::flash('alert-info', 'Caller updated!');
        return Redirect::to('/admin/callers/'.$caller->id);
    }

    public function remove(Caller $caller)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $caller->delete();

        return Redirect::to('/admin/callers/');
    }
}
