<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class LogController extends Controller
{
    //
     public function showLoginForm(){
        return view('components.login');
    }



    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
             $user = auth()->user();
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account is inactive. Please contact your organization administrator.',
                ])->onlyInput('email');
            }
            $request->session()->regenerate();
            
            if($user->isSuperuser()){

                return redirect()->route('dashboard.index');
            } else{
                return redirect()->route('subuser.dashboard');
            }
 
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
