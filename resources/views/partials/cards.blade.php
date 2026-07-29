@php
    // Fetch the biller account for the logged-in user
    $biller = auth()->user()->billerAccount;
    $isBillerActive = $biller && $biller->is_completed;
@endphp

<section class="row g-4 stat-grid" aria-label="Account overview">
    <div class="col-12 col-md-6 col-xl-3">
        <button class="stat-card card border-0 w-100 pending-card" type="button" >
            <span>Pending bills</span>
            <strong>0</strong>
            <small>View bills</small>
        </button>
    </div>
    
    <div class="col-12 col-md-6 col-xl-3">
        <button class="stat-card card border-0 w-100 transaction-card" type="button" >
            <span>Transaction history</span>
            <strong>0</strong>
            <small>View history</small>
        </button>
    </div>
    
    <div class="col-xl-3 d-none d-xl-block" aria-hidden="true"></div>
    
    <div class="col-12 col-xl-3">
        <button class="stat-card card border-0 w-100 biller-card" type="button" data-dialog-open="biller-dialog">
            <span>Biller account</span>
            <!-- Dynamic Status -->
            <strong>{{ $isBillerActive ? 'Active' : 'Not assigned' }}</strong>
            <small>{{ $isBillerActive ? 'View details' : 'Link account' }}</small>
        </button>
    </div>
</section>