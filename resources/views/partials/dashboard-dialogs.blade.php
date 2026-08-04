@php
    // Define the variables locally for this partial
    $biller = auth()->user()->billerAccount;
    $isBillerActive = $biller && $biller->is_completed;
@endphp

<dialog class="dashboard-dialog" id="biller-dialog">
    <button type="button" class="dialog-close" data-dialog-close aria-label="Close">&times;</button>
    <p class="dialog-kicker">Biller account</p>
    
    @if($isBillerActive)
        <h2>Your Biller Details</h2>
        <div class="biller-dialog-details">
            <p><strong>KRA PIN</strong><span>{{ $biller->kra_pin }}</span></p>
            <p><strong>Biller Account</strong><span>{{ $biller->biller_account }}</span></p>
            <p class="biller-dialog-status">● Active &amp; completed</p>
        </div>
        <a href="{{ route('organization.biller') }}" class="dialog-action dialog-action--full">Edit details</a>
    @else
        <h2>Link your biller account</h2>
        <p>Connect your organization’s biller account to keep payments, records, and team access in one secure workspace.</p>
        <div class="biller-dialog-benefits"><span>✓ Pay and track bills</span><span>✓ Give your team the right access</span><span>✓ Keep company records together</span></div>
        <a href="{{ route('organization.biller') }}" class="dialog-action dialog-action--full">Link biller account <span>→</span></a>
    @endif
</dialog>

<dialog class="dashboard-dialog" id="profile-dialog">
    <button type="button" class="dialog-close" data-dialog-close aria-label="Close">&times;</button>
    <p class="dialog-kicker">My profile</p>
    <h2>{{ auth()->user()->fullName() }}</h2>
    <p>{{ auth()->user()->email }}</p>
    <button type="button" class="dialog-action" data-dialog-close>Close</button>
</dialog>
