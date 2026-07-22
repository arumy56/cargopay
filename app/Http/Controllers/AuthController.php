<?php

namespace App\Http\Controllers;

use App\Models\Newuser;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
class AuthController extends Controller
{
    //
    public function showRegisterForm(){
        return view('components.register');

    }

    

    public function register(Request $request){
        $validated=$request->validate([
            'firstname'=> 'required|string|max:255',
            'secondname' => 'required|string|max:255',
            'email' => 'required|string|unique:newusers|max:255',
            'password'=> ['required','confirmed', Password::min(8)->symbols()] ,
            

        ]);

        $validated['password']=Hash::make($validated['password']);

        $user=Newuser::create(array_merge($validated, [
            'role'=>'superuser',
            'is_active'=>true,
            'organization_id' => null,

        ]));
        Auth::login($user);


        event(new Registered($user));
        

        // return redirect('/')->with('success', 'account created successfully');
         return redirect('/email/verify')->with('sucess', 'check ur email to verify ur account we sent a link');
        

    
    }
}
