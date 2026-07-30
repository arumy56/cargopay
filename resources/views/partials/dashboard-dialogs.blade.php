@php
    // Define the variables locally for this partial
    $biller = auth()->user()->billerAccount;
    $isBillerActive = $biller && $biller->is_completed;
@endphp

<dialog class="dashboard-dialog" id="biller-dialog">
    <button type="button" class="dialog-close" data-dialog-close aria-label="Close">&times;</button>
    <p class="dialog-kicker">Biller account</p>
    
    @if($isBillerActive)
        <!-- SHOW THIS IF BILLER ACCOUNT IS SETUP -->
        <h2>Your Biller Details</h2>
        <div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
            <p style="margin-bottom: 10px;"><strong>KRA PIN:</strong> {{ $biller->kra_pin }}</p>
            <p style="margin-bottom: 10px;"><strong>Biller Account:</strong> {{ $biller->biller_account }}</p>
            <p style="margin: 0; color: #28a745;"><strong>Status:</strong> Active & Completed</p>
        </div>
        <a href="{{ route('biller.create') }}" class="dialog-action" style="text-decoration: none; display: inline-block; text-align: center; width: 100%; margin-top: 15px;">Edit Details</a>
    @else
        <!-- SHOW THIS IF BILLER ACCOUNT IS NOT SETUP -->
        <h2>Link your biller account</h2>
        <p>
            Link your organization's biller account to unlock payment and role management features. 
            <a href="{{ route('biller.create') }}" class="dialog-link">Fill out the form here</a>.
        </p>
        <button type="button" class="dialog-action" data-dialog-close style="margin-top: 15px;">Got it</button>
    @endif
</dialog>