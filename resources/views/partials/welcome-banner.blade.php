<section class="welcome-banner card border-0">
    <img src="{{ asset('images/mombasa port.jpg') }}" alt="Mombasa Port containers">
    <span class="banner-shape banner-shape-left" aria-hidden="true"></span>
    <span class="banner-shape banner-shape-right" aria-hidden="true"></span>
    <div class="welcome-banner-content">
        <div class="welcome-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->firstname, 0, 1)) }}</div>
        <p>Kargo Pay dashboard</p>
        <h1>Welcome back, {{ auth()->user()->firstname }}!</h1>
        <span>What would you like to do today?</span>
        <button class="btn" type="button" data-dialog-open="biller-dialog">Link Biller Account</button>
    </div>
</section>
