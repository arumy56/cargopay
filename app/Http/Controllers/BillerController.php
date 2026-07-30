<?php
namespace App\Http\Controllers;
use App\Models\BillerAccount;
use Illuminate\Http\Request;

class BillerController extends Controller
{
    //
    public function create()
    {
        $account = auth()->user()->billerAccount;
        return view('biller.create', compact('account'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kra_pin' => 'required|string|unique:biller_accounts|min:10|max:50',
            'biller_account' => 'required|string|unique:biller_accounts|min:10|max:50',

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

        return redirect()->route('dashboard.index')->with('success', 'Biller account set up successfully');
    }

    
}
