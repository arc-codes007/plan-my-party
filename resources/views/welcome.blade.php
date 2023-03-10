@extends('layouts.app')

@section('content')
<div class="mt-5">
    @include('components.packages')
</div>

<section>
    <div class="container-fluid p-1 mb-2" style="background-image:linear-gradient(-45deg,#FA6573,#FE1D57); background-size: 100% 100%; margin-top: -1.1rem;">
        <div class="container py-3">
            <h1 class="text-center text-white">PLAN-my-PARTY</h1>
            <h5 class="text-center text-white">One stop destination for all your PARTIES <i class="fa-solid fa-champagne-glasses"></i></h5>
            <h3 class="text-center text-white pt-3"><a href="#" class="btn rounded-pill btn-outline-warning text-white"><strong>PLAN a PARTY Now <i class="fa-solid fa-champagne-glasses"></i></strong></a></h3>
        </div>
    </div>
</section>
<div id="venue">
    @include('components.venues')
    <hr>
</div>
<div id="package">
    @include('components.packages')
    <hr>
</div>

<section id="footer" class="pt-4 pb-2 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-around">
            <div>
                <h4>About</h4>
                <a href="#" class="text-black">Home</a><br>
                <a href="#" class="text-black">About Us</a><br>
                <a href="#" class="text-black">Contact US</a>
            </div>
            <div>
                <h4>Quick Links</h4>
                <a href="#venue" class="text-black">Venues</a><br>
                <a href="#package" class="text-black">Packages</a><br>
                <a href="{{ route('login') }}" class="text-black">Login</a><br>
                <a href="{{ route('register') }}" class="text-black">Register</a>
            </div>
            <div>
                <h4>Socials</h4>
                <a href="#" class="text-primary text-semibold" style="text-decoration: none"><i class="fa-brands fa-facebook-f fa-lg"></i> Facebook</a><br>
                <a href="#" class="text-danger text-semibold" style="text-decoration: none"><i class="fa-brands fa-instagram fa-lg"></i> Instagram</a><br>
                <a href="#" class="text-primary text-semibold" style="text-decoration: none"><i class="fa-brands fa-linkedin-in fa-lg"></i> Linked In</a><br>
            </div>
        </div>

        <hr>
        <p class="text-center">Plan-my-Party | Designed and Developed by Utkarsh, Yash, Ritik, Pratik and Vaibhav</p>
    </div>
</section>

@endsection