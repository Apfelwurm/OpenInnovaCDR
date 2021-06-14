<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        // Check for Event
        $user = Auth::user();
        if ($user) {
            if ($user->isAdmin)
            {
                return redirect('/admin/');
            }
        return view('userhome');
        }
        else
        {
            return redirect('/login');

        }
    }
}
