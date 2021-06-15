<?php

namespace App\Http\Controllers\Admin;

use App\Models\Caller;
use App\Http\Controllers\Controller;
use App\Models\OrganisationUnit;
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
        ->withOrganisationUnits(OrganisationUnit::paginate(20))
        ->withCaller($caller);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $rules = [
            'name'     	=> 'required',
            'number'     	=> 'required|unique:callers,number',
        ];
        $messages = [
            'name.required'     				=> 'Name is required',
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
                'name'     	=> 'required',
            ];
            $messages = [
                'name.required'     				=> 'Name is required',
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


    public function assign(Caller $caller, OrganisationUnit $organisationUnit)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $caller->organisation_unit_id = $organisationUnit->id;

        if (!$caller->save()) {
            Session::flash('alert-danger', 'Cannot update Caller!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'Caller assigned to OU');
        return Redirect::back();
    }

    public function unassign(Caller $caller)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $caller->organisation_unit_id = null;

        if (!$caller->save()) {
            Session::flash('alert-danger', 'Cannot update Caller!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'Caller unassigned from OU');
        return Redirect::back();
    }




}
