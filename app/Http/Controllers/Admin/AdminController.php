<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Caller;
use App\Models\Report;

class AdminController extends Controller
{
    /**
     * Show Admin Index Page
     * @return view
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.index')
        ->withUser($user)
        ->withReports(Report::orderBy('created_at')->paginate(20))
        ->withUnassignedCallers(Caller::getUnassignedPaginated());
    }
}
