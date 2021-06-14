<?php

namespace App\Http\Controllers\Admin;
use App\Models\OrganisationUnit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
class OrganisationUnitController extends Controller
{
    public function index()
    {
         return view('admin.organisationunits.index')
        ->withUser(Auth::user())
        ->withOrganisationUnits(OrganisationUnit::paginate(20));
    }

    public function show(OrganisationUnit $organisationUnit)
    {
        return view('admin.organisationunits.show')
        ->withUser(Auth::user())
        ->withOrganisationUnit($organisationUnit);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $rules = [
            'name'     	=> 'required|unique:organisation_units,name',
        ];
        $messages = [
            'name.required'     				=> 'Name is required',
            'name.unique'     				=> 'Name exists already',

        ];
        $this->validate($request, $rules, $messages);

        // Create User
        $organisationUnit 						= New OrganisationUnit;
        $organisationUnit->name         	= $request->name;

        if (!$organisationUnit->save()) {
            Session::flash('alert-danger', 'Cannot create Organisation Unit!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'Organisation Unit created!');
        return Redirect::to('/admin/organisationunits/'.$organisationUnit->id);
    }

    public function update(Request $request, OrganisationUnit $organisationUnit)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }


        if ($organisationUnit->name != $request->name)
        {
            $rules = [
                'name'     	=> 'required|unique:organisation_units,name',
            ];
            $messages = [
                'name.required'     				=> 'Name is required',
                'name.unique'     				=> 'Name exists already',
            ];
            $this->validate($request, $rules, $messages);

            $organisationUnit->name         	= $request->name;

            if (!$organisationUnit->save()) {
                Session::flash('alert-danger', 'Cannot update Organisation Unit!');
                return Redirect::back();
            }
        }



        Session::flash('alert-info', 'Organisation Unit updated!');
        return Redirect::to('/admin/organisationunits/'.$organisationUnit->id);
    }

    public function remove(OrganisationUnit $organisationUnit)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $organisationUnit->delete();

        return Redirect::to('/admin/organisationunits/');
    }
}
