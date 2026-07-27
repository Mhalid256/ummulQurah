@extends('layouts.public')
@section('title', 'Campaigns')
@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase">Support a Cause</h6>
            <h1>All Active Campaigns</h1>
        </div>
        <div class="row g-4">
            @forelse ($campaigns as $campaign)
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
                <p class="text-center text-muted">No active campaigns at the moment.</p>
            @endforelse
        </div>
        <div class="mt-5">{{ $campaigns->links() }}</div>
    </div>
</div>
@endsection
