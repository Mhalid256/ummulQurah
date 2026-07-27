@extends('layouts.public')
@section('title', 'Home')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="display-4 mb-4">Give hope. Change a life today.</h1>
                <p class="fs-5 mb-4">We connect generous donors and sponsors with children, families and communities in need &mdash; with full transparency on where every donation goes.</p>
                <a href="{{ route('public.campaigns') }}" class="btn btn-primary rounded-pill py-3 px-5">Donate to a Campaign</a>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('frontend/img/hero-img.png') }}" class="img-fluid" alt="Hero" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <h2 class="display-5 fw-bold text-primary">{{ number_format($stats['total_raised'], 0) }}</h2>
                <p class="fs-5">Total Raised</p>
            </div>
            <div class="col-md-4">
                <h2 class="display-5 fw-bold text-primary">{{ number_format($stats['total_donors']) }}</h2>
                <p class="fs-5">Donors &amp; Sponsors</p>
            </div>
            <div class="col-md-4">
                <h2 class="display-5 fw-bold text-primary">{{ number_format($stats['active_campaigns']) }}</h2>
                <p class="fs-5">Active Campaigns</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase">Featured Causes</h6>
            <h1>Active Campaigns You Can Support</h1>
        </div>
        <div class="row g-4">
            @forelse ($featuredCampaigns as $campaign)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        @if($campaign->cover_image)
                            <img src="{{ asset('storage/'.$campaign->cover_image) }}" class="card-img-top" style="height:200px;object-fit:cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $campaign->title }}</h5>
                            <p class="card-text">{{ $campaign->summary }}</p>
                            <div class="progress mb-2" style="height:6px;"><div class="progress-bar" style="width: {{ $campaign->progress_percent }}%"></div></div>
                            <p class="small text-muted">{{ number_format($campaign->raised_amount,0) }} raised of {{ number_format($campaign->goal_amount,0) }} {{ $campaign->currency }} goal</p>
                            <a href="{{ route('public.campaign.show', $campaign) }}" class="btn btn-outline-primary rounded-pill w-100">View &amp; Donate</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No active campaigns at the moment. Please check back soon.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
