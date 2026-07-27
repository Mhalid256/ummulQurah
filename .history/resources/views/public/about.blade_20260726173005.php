@extends('layouts.public')
@section('title', 'About Us')
@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase">Who We Are</h6>
            <h1>About {{ config('app.name') }}</h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-6">
                <p class="fs-5">We are a multi-organization charity platform dedicated to connecting donors, sponsors and volunteers with beneficiaries and communities that need support the most.</p>
                <p>Our mission is to run every donation, sponsorship and grant with complete transparency &mdash; from the moment a gift is given to the moment it changes a life.</p>
            </div>
            <div class="col-lg-6">
                <ul class="list-unstyled fs-5">
                    <li><i class="fas fa-check text-primary me-2"></i> Transparent fund allocation</li>
                    <li><i class="fas fa-check text-primary me-2"></i> Verified beneficiary registration</li>
                    <li><i class="fas fa-check text-primary me-2"></i> Real-time campaign progress</li>
                    <li><i class="fas fa-check text-primary me-2"></i> Sponsor-to-beneficiary matching</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
