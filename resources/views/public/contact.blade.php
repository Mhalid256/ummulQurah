@extends('layouts.public')
@section('title', 'Contact Us')
@section('content')
<div class="container-fluid py-5">
    <div class="container" style="max-width:700px;">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase">Get In Touch</h6>
            <h1>Contact Us</h1>
        </div>
        <div class="row g-3">
            <div class="col-md-6"><input type="text" class="form-control" placeholder="Your Name"></div>
            <div class="col-md-6"><input type="email" class="form-control" placeholder="Your Email"></div>
            <div class="col-12"><input type="text" class="form-control" placeholder="Subject"></div>
            <div class="col-12"><textarea class="form-control" rows="5" placeholder="Message"></textarea></div>
            <div class="col-12"><button class="btn btn-primary rounded-pill py-2 px-5">Send Message</button></div>
        </div>
    </div>
</div>
@endsection
