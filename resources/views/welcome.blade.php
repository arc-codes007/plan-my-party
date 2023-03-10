@extends('layouts.app')

@section('content')
<section>
    <div class="container-fluid p-5 mb-2" style="background-image:linear-gradient(-45deg,#FA6573,#FE1D57); background-size: 100% 100%; margin-top: -1.1rem;">
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

@include('components.footer')

@endsection