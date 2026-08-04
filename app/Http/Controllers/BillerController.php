<?php

namespace App\Http\Controllers;

use App\Models\BillerAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BillerController extends Controller
{
    //
    public function create(): View
    {
        $account = auth()->user()->billerAccount;

        return view('organization.index', [
            'section' => 'biller',
            'account' => $account,
            'subusers' => collect(),
            'activeMembers' => collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $account = auth()->user()->billerAccount;

        $validated = $request->validate([
            'kra_pin' => ['required', 'string', 'min:10', 'max:50', Rule::unique('biller_accounts')->ignore($account?->id)],
            'biller_account' => ['required', 'string', 'min:10', 'max:50', Rule::unique('biller_accounts')->ignore($account?->id)],

        ]);

        // $validated['user_id'] = auth()->id();
        // $validated['is_completed'] = true;

        BillerAccount::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'kra_pin' => $validated['kra_pin'],
                'biller_account' => $validated['biller_account'],
                'is_completed' => true,
            ]
        );

        return redirect()->route('organization.biller')->with('success', 'Biller account saved successfully.');
    }
}
