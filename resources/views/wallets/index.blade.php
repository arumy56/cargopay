<x-app :isDashboard="true" title="My Wallets - Kargo Pay">
    <main style="padding: 20px; max-width: 1000px; margin: 0 auto;">

        @if(session('success'))
        <div class="dashboard-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
        @endif

        <div class="subuser-management__header" style="margin-bottom: 30px;">
            <nav class="subuser-management__navigation" aria-label="Main navigation">
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
                <a class="is-active" href="{{ route('subuser.index') }}">Manage users</a>
            </nav>
            <div>
                <p class="subuser-management__eyebrow" style="color: #6c757d; text-transform: uppercase; font-size: 0.85em; font-weight: bold; margin-bottom: 5px;">Finance</p>
                <h1 style="margin: 0;">Manage Wallets</h1>
                <p style="color: #6c757d; margin-top: 5px;">Set up your KES and USD wallets for payments and transactions.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- KES Wallet Card --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #28a745 !important;">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center" style="background: #28a745 !important;">
                        <strong>🇰🇪 KES Wallet</strong>
                        @if($kesWallet)
                        <span class="badge {{ $kesWallet->is_active ? 'bg-white text-success' : 'bg-secondary' }}">
                            {{ $kesWallet->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($kesWallet)
                        <div class="mb-3">
                            <h3 class="text-success fw-bold" style="font-size: 1.8em;">{{ $kesWallet->formatted_balance }}</h3>
                            <p class="text-muted mb-1"><strong>Account:</strong> {{ $kesWallet->wallet_name }}</p>
                            <p class="text-muted mb-1"><strong>M-Pesa:</strong> {{ $kesWallet->mpesa_number }}</p>
                            <p class="text-muted mb-0"><strong>Updated:</strong> {{ $kesWallet->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- FIXED: Uses simple Vanilla JS to toggle the 'd-none' class. No flicker! -->
                            <button type="button" class="btn btn-outline-success btn-sm"
                                onclick="document.getElementById('kesForm').classList.toggle('d-none')">
                                ✏️ Edit
                            </button>

                            <form action="{{ route('wallets.toggle', $kesWallet) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                    {{ $kesWallet->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>

                        {{-- FIXED: Starts hidden with 'd-none', no Bootstrap collapse needed --}}
                        <div class="mt-3 d-none" id="kesForm" style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
                            <form action="{{ route('wallets.update', $kesWallet) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h6 class="mb-3">Edit KES Wallet</h6>
                                <div class="mb-2">
                                    <label class="form-label small text-muted">Account Name</label>
                                    <input type="text" name="wallet_name" class="form-control form-control-sm"
                                        value="{{ $kesWallet->wallet_name }}" placeholder="Account Name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted">M-Pesa Number</label>
                                    <input type="text" name="mpesa_number" class="form-control form-control-sm"
                                        value="{{ $kesWallet->mpesa_number }}" placeholder="254712345678">
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100">Save Changes</button>
                            </form>
                        </div>
                        @else
                        <p class="text-muted">No KES wallet set up yet.</p>
                        <form action="{{ route('wallets.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="currency" value="KES">
                            <div class="mb-3">
                                <label class="form-label">Account Name</label>
                                <input type="text" name="wallet_name" class="form-control" placeholder="e.g., Business KES" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">M-Pesa Number</label>
                                <input type="text" name="mpesa_number" class="form-control" placeholder="254712345678" required>
                                <small class="text-muted">Format: 254 followed by 9 digits</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Initial Balance (Optional)</label>
                                <input type="number" name="initial_balance" class="form-control" placeholder="0.00" step="0.01" min="0">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Create KES Wallet</button>
                        </form>
                        <div class="alert alert-info mt-3 mb-0 small">
                            💡 M-Pesa sandbox integration coming soon for deposits and withdrawals.
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- USD Wallet Card --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid #007bff !important;">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="background: #007bff !important;">
                        <strong>🇺🇸 USD Wallet</strong>
                        @if($usdWallet)
                        <span class="badge {{ $usdWallet->is_active ? 'bg-white text-primary' : 'bg-secondary' }}">
                            {{ $usdWallet->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($usdWallet)
                        <div class="mb-3">
                            <h3 class="text-primary fw-bold" style="font-size: 1.8em;">{{ $usdWallet->formatted_balance }}</h3>
                            <p class="text-muted mb-1"><strong>Account:</strong> {{ $usdWallet->wallet_name }}</p>
                            @if($usdWallet->bank_account)
                            <p class="text-muted mb-1"><strong>Bank Ref:</strong> {{ $usdWallet->bank_account }}</p>
                            @endif
                            <p class="text-muted mb-0"><strong>Updated:</strong> {{ $usdWallet->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- FIXED: Uses simple Vanilla JS to toggle the 'd-none' class. No flicker! -->
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="document.getElementById('usdForm').classList.toggle('d-none')">
                                ✏️ Edit
                            </button>

                            <form action="{{ route('wallets.toggle', $usdWallet) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                    {{ $usdWallet->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>

                        {{-- FIXED: Starts hidden with 'd-none', no Bootstrap collapse needed --}}
                        <div class="mt-3 d-none" id="usdForm" style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
                            <form action="{{ route('wallets.update', $usdWallet) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h6 class="mb-3">Edit USD Wallet</h6>
                                <div class="mb-2">
                                    <label class="form-label small text-muted">Account Name</label>
                                    <input type="text" name="wallet_name" class="form-control form-control-sm"
                                        value="{{ $usdWallet->wallet_name }}" placeholder="Account Name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Bank Reference</label>
                                    <input type="text" name="bank_account" class="form-control form-control-sm"
                                        value="{{ $usdWallet->bank_account ?? '' }}" placeholder="Bank Reference (Optional)">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Save Changes</button>
                            </form>
                        </div>
                        @else
                        <p class="text-muted">No USD wallet set up yet.</p>
                        <form action="{{ route('wallets.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="currency" value="USD">
                            <div class="mb-3">
                                <label class="form-label">Account Name</label>
                                <input type="text" name="wallet_name" class="form-control" placeholder="e.g., Business USD" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bank Reference (Optional)</label>
                                <input type="text" name="bank_account" class="form-control" placeholder="Account number or reference">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Initial Balance (Optional)</label>
                                <input type="number" name="initial_balance" class="form-control" placeholder="0.00" step="0.01" min="0">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create USD Wallet</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Wallet Summary --}}
        @if($kesWallet || $usdWallet)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white" style="border-bottom: 1px solid #dee2e6;">
                <strong>Wallet Summary</strong>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6 border-end">
                        <div class="text-muted small">KES Balance</div>
                        <div class="h4 text-success fw-bold mb-0">{{ $kesWallet ? $kesWallet->formatted_balance : '—' }}</div>

                        {{-- Add this right below the balance display in the KES card --}}
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6 class="mb-2">💳 Deposit via M-Pesa</h6>
                            @if(session('success'))
                            <div class="alert alert-success small">{{ session('success') }}</div>
                            @endif
                            <form action="{{ route('mpesa.stk-push') }}" method="POST">
                                @csrf
                                <input type="hidden" name="wallet_id" value="{{ $kesWallet->id }}">

                                <div class="mb-2">
                                    <input type="number" name="amount" class="form-control form-control-sm" placeholder="Amount (Min 1 KES)" min="1" required>
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="phone_number" class="form-control form-control-sm" value="{{ $kesWallet->mpesa_number }}" placeholder="254712345678" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    📲 Send STK Push
                                </button>
                            </form>
                        </div>
                        @php
                        $pendingTransactions = \App\Models\MpesaTransaction::where('wallet_id', $kesWallet->id)
                        ->where('status', 'pending')
                        ->latest()
                        ->get();
                        @endphp

                        @if($pendingTransactions->count())
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                // Collect all URLs for pending transactions silently
                                const pendingUrls = [
                                    @foreach($pendingTransactions as $pending)
                                    "{{ url('mpesa/status/' . $pending->id) }}",
                                    @endforeach
                                ];

                                let attempts = 0;
                                const maxAttempts = 120; // Stop checking after 6 minutes (120 * 3s)

                                const checkStatusSilently = async () => {
                                    if (attempts >= maxAttempts) return;
                                    attempts++;

                                    // Check all pending transactions in the background
                                    for (const url of pendingUrls) {
                                        try {
                                            const res = await fetch(url);
                                            const data = await res.json();

                                            // If any transaction is finished (completed, failed, or canceled)
                                            if (data.status === 'completed' || data.status === 'failed' || data.status === 'canceled') {
                                                // Silently reload the page to show the updated balance!
                                                location.reload();
                                                return;
                                            }
                                        } catch (e) {
                                            // Ignore network errors silently
                                        }
                                    }

                                    // If still pending, wait 3 seconds and check again
                                    setTimeout(checkStatusSilently, 3000);
                                };

                                // Start the hidden background polling immediately
                                checkStatusSilently();
                            });
                        </script>
                        @endif



                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">USD Balance</div>
                        <div class="h4 text-primary fw-bold mb-0">{{ $usdWallet ? $usdWallet->formatted_balance : '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </main>
</x-app>