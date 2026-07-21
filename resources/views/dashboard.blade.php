<x-app :isDashboard="true" title="Dashboard - Kargo Pay">
    <div class="container-fluid">
        <div class="row min-vh-100">
            
            <!-- Sidebar Navigation Column -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse border-end p-3">
                <div class="position-sticky">
                    <h5 class="text-primary fw-bold mb-4 px-2">🚢 Kargo Pay</h5>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a class="nav-link active bg-light text-primary rounded px-3 py-2 fw-semibold" href="#">
                                📊 Dashboard Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark rounded px-3 py-2" href="#">
                                📦 My Shipments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark rounded px-3 py-2" href="#">
                                💳 Payments
                            </a>
                        </li>
                    </ul>
                    
                    <hr class="my-4">
                    
                    
                </div>
            </nav>

            <!-- Main Content Grid Column -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-light">
                
                <!-- Welcome Section Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div>
                        <h1 class="h2 fw-bold">Welcome back, {{ Auth::user()->firstname }}! 👋</h1>
                        <p class="text-muted">Here is what is happening with Kargo Pay today.</p>
                    </div>
                </div>

                <!-- Metrics Component Row -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="text-muted small uppercase fw-bold">Total Balance</div>
                            <div class="h3 fw-bold text-primary my-1">$2,400</div>
                            <div class="text-success small">Jan 1st - Jul 15th</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="text-muted small uppercase fw-bold">Active Cargo Shipments</div>
                            <div class="h3 fw-bold text-secondary my-1">12 Active</div>
                            <div class="text-muted small">↗︎ 14% new this week</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="text-muted small uppercase fw-bold">Account Status</div>
                            <div class="h3 fw-bold text-success my-1">Verified</div>
                            <div class="text-success small">Email authorized</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions Data Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Recent Transactions</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code class="small">#TRX-98210</code></td>
                                        <td>Ocean Freight Booking</td>
                                        <td class="fw-bold">$1,200.00</td>
                                        <td><span class="badge bg-success-subtle text-success border border-success">Success</span></td>
                                    </tr>
                                    <tr>
                                        <td><code class="small">#TRX-87114</code></td>
                                        <td>Customs Clearance Fee</td>
                                        <td class="fw-bold">$350.00</td>
                                        <td><span class="badge bg-warning-subtle text-warning border border-warning">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</x-app>
