<?php

namespace App\Http\Controllers;

use App\Models\Newuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubuserController extends Controller
{
   
    // READ: List all subusers belonging to this superuser
    public function index()
    {
        $subuser = Newuser::where('organization_id', auth()->id())->latest()->get();
        return view('subuser.index', compact('subuser'));
    }

    public function create()
    {
        return view('subuser.create');
    }

    // CREATE: Superuser creates a subuser
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'secondname' => 'required|string|max:255',
            'email' => 'required|email|unique:newusers|max:255',
        ]);

        $tempPassword = Str::random(12);

        Newuser::create([
            'firstname' => $validated['firstname'],
            'secondname' => $validated['secondname'],
            'email' => $validated['email'],
            'password' => Hash::make($tempPassword),
            'role' => 'subuser',
            'is_active' => false,
            'organization_id' => auth()->id(),
        ]);

        // TODO: Email temp password via Mailtrap
        // Mail::to($validated['email'])->send(...);

        return redirect()->route('subuser.index')
            ->with('success', 'User created. Temporary password: ' . $tempPassword);
    }

    public function show(Newuser $subuser)
    {
        $this->authorizeOwnership($subuser);
        return view('subuser.show', compact('subuser'));
    }

    public function edit(Newuser $subuser)
    {
        $this->authorizeOwnership($subuser);
        return view('subuser.edit', compact('subuser'));
    }

    public function update(Request $request, Newuser $subuser)
    {
        $this->authorizeOwnership($subuser);

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'secondname' => 'required|string|max:255',
            'email' => 'required|email|unique:newusers,email,' . $subuser->id,
        ]);

        $subuser->update($validated);

        return redirect()->route('subuser.index')
            ->with('success', 'User updated.');
    }

    // ACTIVATE (soft delete restore)
    public function activate(Newuser $subuser)
    {
        $this->authorizeOwnership($subuser);
        $subuser->update(['is_active' => true]);

        return redirect()->route('subuser.index')
            ->with('success', 'User activated.');
    }

    // DEACTIVATE (soft delete)
    public function destroy(Newuser $subuser)
    {
        $this->authorizeOwnership($subuser);
        $subuser->update(['is_active' => false]);

        return redirect()->route('subuser.index')
            ->with('success', 'User deactivated.');
    }

    // Helper: prevent superusers from managing other superusers' subusers
    private function authorizeOwnership(Newuser $subuser)
    {
        if ($subuser->organization_id !== auth()->id()) {
            abort(403, 'This user does not belong to your organization.');
        }
    }
}