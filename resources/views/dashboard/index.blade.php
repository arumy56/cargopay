@extends('layouts.app', ['title' => 'Dashboard | Kargo Pay'])
@vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])
@section('content')
    <main class="dashboard-content container-fluid">
        <p class="breadcrumbs">KargoPay <span>/</span> Dashboard</p>
        @if(session('success'))
            <div class="dashboard-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-12">
                @include('partials.welcome-banner')
            </div>
        </div>

        @include('partials.cards')

        @include('partials.quick-links')
    </main>
@endsection

@push('dialogs')
    @include('partials.dashboard-dialogs')
@endpush
