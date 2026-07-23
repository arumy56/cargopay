<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SubuserDashboardController extends Controller
{
    //
    public function index(){
        $subuser=Auth::user();
        $organization= $subuser->organization;
        return view('subuser.dashboard', compact('subuser', 'organization'));
    }
}
