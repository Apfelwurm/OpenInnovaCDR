<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
      /**
     * Show Settings Index Page
     * @return Redirect
     */
    public function index()
    {


        return view('admin.settings.index')
            ->withUser(Auth::user())
            ->withSettings(Setting::all());
    }

        /**
     * Update Settings
     * @param  Request $request
     * @return Redirect
     */
    public function update(Request $request)
    {

        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $rules = [
            'automatic_caller_creation'       => 'in:on,off',
            'automatic_caller_update'       => 'in:on,off',

        ];
        $messages = [
            'automatic_caller_creation.in'                    => 'Publicuse must be true or false',
            'automatic_caller_update.in'                    => 'autostart must be true or false',

        ];
        $this->validate($request, $rules, $messages);

        if (($request->automatic_caller_creation ? true : false))
        {
            if (!Setting::enableAutomaticCallerCreation()) {
                Session::flash('alert-danger', "Could not Enable the Automatic Caller Creation!");
                return Redirect::back();
            }
        }
        else
        {
            if (!Setting::disableAutomaticCallerCreation()) {
                Session::flash('alert-danger', "Could not Disable the Automatic Caller Creation!");
                return Redirect::back();
            }

        }

        if (($request->automatic_caller_update ? true : false))
        {
            if (!Setting::enableAutomaticCallerUpdate()) {
                Session::flash('alert-danger', "Could not Enable the Automatic Caller Creation!");
                return Redirect::back();
            }
        }
        else
        {
            if (!Setting::disableAutomaticCallerUpdate()) {
                Session::flash('alert-danger', "Could not Disable the Automatic Caller Creation!");
                return Redirect::back();
            }

        }

        Session::flash('alert-success', "Successfully Saved Settings!");
        return Redirect::back();
    }


}
