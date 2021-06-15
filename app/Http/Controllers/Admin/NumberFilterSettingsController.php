<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NumberFilterSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class NumberFilterSettingsController extends Controller
{
    public function index()
    {
         return view('admin.numberfiltersettings.index')
        ->withUser(Auth::user())
        ->withNumberFilterSettings(NumberFilterSetting::orderBy('priority')->paginate(20));
    }

    public function show(NumberFilterSetting $numberFilterSetting)
    {
        return view('admin.numberfiltersettings.show')
        ->withUser(Auth::user())
        ->withNumberFilterSetting($numberFilterSetting);
    }

    public function add(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }
        $rules = [
            'priority'     	=> 'required|integer|unique:number_filter_settings,priority',
            'direction'     	=> 'required|in:sender,receiver',
            'filter'     	=> 'required|string',
            'cost'     	=> 'required|numeric|between:0.00,999.99',
            'cost_multiplier'     	=> 'required|in:second,minute',
            'ignore_on_timereport'     	=> 'in:on,off',
            'ignore_on_costreport'     	=> 'in:on,off',
        ];
        $messages = [
            'priority.required'     				=> 'priority is required',
            'priority.unique'     				=> 'another entry already has that priority!',
            'priority.integer'     				=> 'priority has to be a number',
            'direction.required'     				=> 'direction is required',
            'direction.in'     				=> 'direction must be sender or receiver',
            'filter.required'     				=> 'filter is required',
            'filter.string'     				=> 'filter must be a string',
            'cost.required'     				=> 'cost is required',
            'cost.numeric'     				=> 'cost must be a double',
            'cost_multiplier.required'     				=> 'cost_multiplier is required',
            'cost_multiplier.in'     				=> 'cost_multiplier must be second or minute',
            'ignore_on_costreport.in'     				=> 'ignore_on_costreport must be true or false',
            'ignore_on_timereport.in'     				=> 'ignore_on_timereport must be true or false',
        ];
        $this->validate($request, $rules, $messages);

        // Create User
        $numberFilterSetting 						= New NumberFilterSetting;
        $numberFilterSetting->priority         	= $request->priority;
        $numberFilterSetting->direction         	= $request->direction;
        $numberFilterSetting->filter         	= $request->filter;
        $numberFilterSetting->cost         	= $request->cost;
        $numberFilterSetting->cost_multiplier         	= $request->cost_multiplier;
        $numberFilterSetting->ignore_on_timereport         	= ($request->ignore_on_timereport ? true : false);
        $numberFilterSetting->ignore_on_costreport         	= ($request->ignore_on_costreport ? true : false);

        if (!$numberFilterSetting->save()) {
            Session::flash('alert-danger', 'Cannot create number filter setting!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'number filter setting created!');
        return Redirect::to('/admin/numberfiltersettings/'.$numberFilterSetting->id);
    }

    public function update(Request $request, NumberFilterSetting $numberFilterSetting)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }

        if ($request->priority != $numberFilterSetting->priority)
        {
            $rules = [
                'priority'     	=> 'required|integer|unique:number_filter_settings,priority',
            ];
            $messages = [
                'priority.required'     				=> 'priority is required',
                'priority.unique'     				=> 'another entry already has that priority!',
                'priority.integer'     				=> 'priority has to be a number',
                ];
            $this->validate($request, $rules, $messages);
        }


        $rules = [
            'direction'     	=> 'required|in:sender,receiver',
            'filter'     	=> 'required|string',
            'cost'     	=> 'required|numeric|between:0.00,999.99',
            'cost_multiplier'     	=> 'required|in:second,minute',
            'ignore_on_timereport'     	=> 'in:on,off',
            'ignore_on_costreport'     	=> 'in:on,off',
        ];
        $messages = [
            'direction.required'     				=> 'direction is required',
            'direction.in'     				=> 'direction must be sender or receiver',
            'filter.required'     				=> 'filter is required',
            'filter.string'     				=> 'filter must be a string',
            'cost.required'     				=> 'cost is required',
            'cost.numeric'     				=> 'cost must be a double',
            'cost_multiplier.required'     				=> 'cost_multiplier is required',
            'cost_multiplier.in'     				=> 'cost_multiplier must be second or minute',
            'ignore_on_costreport.in'     				=> 'ignore_on_costreport must be true or false',
            'ignore_on_timereport.in'     				=> 'ignore_on_timereport must be true or false',
        ];
        $this->validate($request, $rules, $messages);


        $numberFilterSetting->priority         	= $request->priority;
        $numberFilterSetting->direction         	= $request->direction;
        $numberFilterSetting->filter         	= $request->filter;
        $numberFilterSetting->cost         	= $request->cost;
        $numberFilterSetting->cost_multiplier         	= $request->cost_multiplier;
        $numberFilterSetting->ignore_on_timereport         	= ($request->ignore_on_timereport ? true : false);
        $numberFilterSetting->ignore_on_costreport         	= ($request->ignore_on_costreport ? true : false);



        if (!$numberFilterSetting->save()) {
            Session::flash('alert-danger', 'Cannot update number filter setting!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'number filter setting updated!');
        return Redirect::to('/admin/numberfiltersettings/'.$numberFilterSetting->id);

    }

    public function remove(NumberFilterSetting $numberFilterSetting)
    {
        if (!Auth::user()->isAdmin) {
            Session::flash('alert-danger', 'You do not have permissions to do this!');
            return Redirect::back();
        }

        if (!$numberFilterSetting->delete()) {
            Session::flash('alert-danger', 'Cannot delete number filter setting!');
            return Redirect::back();
        }

        Session::flash('alert-info', 'number filter setting deleted!');
        return Redirect::to('/admin/numberfiltersettings/');

    }

}
