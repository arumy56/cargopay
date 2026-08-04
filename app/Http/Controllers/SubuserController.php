<?php

namespace App\Http\Controllers;

use App\Models\Newuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubuserController extends Controller
{
    // READ: List all subusers belonging to this superuser
    public function index()
    {
        return redirect()->route('organization.users');
    }

    public function create()
    {
        return view('subuser.create');
    }

    // CREATE: Superuser creates a subuser
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|min:4|max:255',
            'secondname' => 'required|string|min:4|max:255',
            'email' => 'required|email|unique:newusers|max:255',
            'password' => 'required|string|min:4|max:255',
        ]);

        $tempPassword = $validated['password'];

        Newuser::create([
            'firstname' => $validated['firstname'],
            'secondname' => $validated['secondname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'subuser',
            'is_active' => false,
            'organization_id' => auth()->id(),
        ]);

        return redirect()->route('organization.users')
            ->with('success', 'User created. Temporary password: ')->with('temp_password', $tempPassword);
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
            'email' => 'required|email|unique:newusers,email,'.$subuser->id,
        ]);

        $subuser->update($validated);

        return redirect()->route('organization.users')
            ->with('success', 'User updated.');
    }

    // ACTIVATE (soft delete restore)
    public function activate(Newuser $subuser)
    {
        $this->authorizeOwnership($subuser);
        $subuser->update(['is_active' => true]);

        return redirect()->route('organization.users')
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

    public function resetPassword(Request $request, Newuser $subuser)
    {
        if ($subuser->role !== 'subuser' || $subuser->organization_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        $subuser->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('organization.users')->with('success', 'Password reset successfully!');
    }

    // Display the "Manage Organization" role assignment page
    public function manageRoles()
    {
        // Get all users belonging to the logged-in admin's organization
        $users = Newuser::where('organization_id', auth()->id())->where('is_active', true)  // Only show active users for role assignment
            ->get();

        return view('organization.index', [
            'section' => 'roles',
            'subusers' => $users,
            'activeMembers' => $users,
        ]);
    }

    // Process the role update
    public function updateRole(Request $request, $id)
    {
        $user = Newuser::findOrFail($id);

        // Security check: ensure admin is only updating their own employees
        if ($user->organization_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            // nullable allows them to leave it blank (No Role)
            'role' => 'nullable|in:finance,clearance,operations,manager',
        ]);

        // $user->role = $validated['role']; // Will be null if blank is selected
        // $user->save();
        $user->update(['role' => $validated['role']]);

        return redirect()->route('organization.roles')->with('success', 'Role updated successfully.');
    }

    // Helper: prevent superusers from managing other superusers' subusers
    private function authorizeOwnership(Newuser $subuser)
    {
        if ($subuser->organization_id !== auth()->id()) {
            abort(403, 'This user does not belong to your organization.');
        }
    }
}
