<x-app :isDashboard="true" title="Setup Biller Account">
    <div class="container-fluid">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">🏦 Setup Biller Account</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        @if($account && $account->is_completed)
                            <div class="alert alert-success">
                                ✅ Your biller account is already set up.
                                <div class="mt-2 small">
                                    <strong>KRA PIN:</strong> {{ $account->kra_pin }}<br>
                                    <strong>Biller Account:</strong> {{ $account->biller_account }}
                                </div>
                            </div>
                            <a href="{{ route('dashboard.index') }}" class="btn btn-primary w-100">Go to Dashboard</a>
                        @else
                            <p class="text-muted mb-4">Complete this setup to unlock payments, role assignments, and other organization features.</p>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('biller.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="kra_pin" class="form-label">KRA PIN *</label>
                                    <input type="text" 
                                           class="form-control @error('kra_pin') is-invalid @enderror" 
                                           id="kra_pin" 
                                           name="kra_pin" 
                                           value="{{ old('kra_pin', $account->kra_pin ?? '') }}" 
                                           required>
                                    @error('kra_pin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="biller_account" class="form-label">Biller Account Number *</label>
                                    <input type="text" 
                                           class="form-control @error('biller_account') is-invalid @enderror" 
                                           id="biller_account" 
                                           name="biller_account" 
                                           value="{{ old('biller_account', $account->biller_account ?? '') }}" 
                                           required>
                                    @error('biller_account')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    {{ $account ? 'Update Biller Account' : 'Save & Unlock Features' }}
                                </button>
                            </form>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app>