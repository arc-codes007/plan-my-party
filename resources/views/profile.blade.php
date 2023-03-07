@extends('layouts.app')
@section('content')

<div class="container p-3">
    <div class="row text-center text-danger">
        <h2 class="fw-bolder">Profile Info</h2>
    </div>
    <div class="row fs-3">
        <div class="col-2">Name</div>
        <div class="col-2">{{Auth::user()->name}}</div>
    </div>
    <div class="row fs-3">
        <div class="col-2">E-mail</div>
        <div class="col-2">{{Auth::user()->email}}</div>
    </div>
    <div class="row fs-3">
        <div class="col-2">Mobile</div>
        <div class="col-2">{{Auth::user()->phone}}</div>
    </div>
    <div class="row fs-3">
        <div class="col-2">My Parties</div>
        <div class="col-1"><a href="" class="btn btn-danger" role="button">Browse</a></div>
        <div class="col-2"><a href="{{route('reco_form')}}" class="btn btn-danger" role="button">Plan a Party</a></div>
    </div>
    <div class="row fs-3">
        <div class="col-2">My reviews</div>
        <div class="col-1"><a href="" class="btn btn-danger" role="button">Browse</a></div>
        <div class="col-2"><a href="" class="btn btn-danger" role="button">Review Now</a></div>
    </div>
    <a href="{{route('edit_user_profile')}}" class="btn btn-outline-danger">Edit Profile Info</a>
</div>

@endsection