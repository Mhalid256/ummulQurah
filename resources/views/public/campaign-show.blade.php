@extends('layouts.public')
@section('title', $campaign->title)
@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                @if($campaign->cover_image)
                    <img src="{{ asset('storage/'.$campaign->cover_image) }}" class="img-fluid rounded mb-4" alt="{{ $campaign->title }}">
                @endif
                <h1>{{ $campaign->title }}</h1>
                <p class="text-muted">{{ $campaign->category }}</p>
                <p class="fs-5">{{ $campaign->summary }}</p>
                <div>{!! nl2br(e($campaign->description)) !!}</div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>{{ number_format($campaign->raised_amount,0) }} {{ $campaign->currency }} raised</h5>
                        <div class="progress mb-2" style="height:8px;"><div class="progress-bar" style="width: {{ $campaign->progress_percent }}%"></div></div>
                        <p class="text-muted">of {{ number_format($campaign->goal_amount,0) }} {{ $campaign->currency }} goal &mdash; {{ $campaign->progress_percent }}%</p>
                        <a href="{{ route('public.donate.form', $campaign) }}" class="btn btn-primary rounded-pill w-100 py-2">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
