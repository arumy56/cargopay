<?php

namespace App\Http\Controllers;

use App\Models\Subusers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubuserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function index()
    {
        //
        $subuser=Subusers::all();
        return view('subuser.index', compact('subuser'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('subuser.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'firstname'=>'required|string|max:255',
            'secondname'=>'required|string|max:255',
            'email' => 'required|string|max:255',
            'password'=> 'required|string|min:8'

        ]);
        
        Subusers::create([
            'firstname'=>$request->firstname,
            'secondname'=>$request->secondname,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'is_active'=>false,

        ]);

        return redirect()->route('subuser.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('subuser.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Subusers $subuser)
    {
        //
        $subuser->update(['is_active'=>true]);
        return redirect()->route('subuser.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subusers $subuser)
    {
        //
        $subuser->update(['is_active'=>false]);
        return redirect()->route('subuser.index');

    }
}
