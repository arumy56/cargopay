<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SubuserDashboardController extends Controller
{
    //
    public function index(){
        $user=Auth::user();
        $organization= $user->organization;
        return view('subuser.dashboard', compact('user', 'organization'));
    }
}
