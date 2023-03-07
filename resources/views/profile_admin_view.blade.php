@extends('layouts.app')
@section('content')

<div class="container p-3">
    <div class="row text-center text-danger">
        <h2 class="fw-bolder">Profile Info</h2>
    </div>
    <div class="row fs-3">
        <div class="col-2">Name</div>
        <div class="col-2">{{$user->name}}</div>
    </div>
    <div class="row fs-3">
        <div class="col-2">E-mail</div>
        <div class="col-2">{{$user->email}}</div>
    </div>
    <div class="row fs-3">
        <div class="col-2">Mobile</div>
        <div class="col-2">{{$user->phone}}</div>
    </div>
    <div class="row fs-3">
        <div class="col-2">Parties</div>
        <div class="col-2"><a href="" class="btn btn-danger" role="button">Browse Parties</a></div>
    </div>
    <div class="row fs-3">
        <div class="col-2">Reviews</div>
        <div class="col-2"><a href="" class="btn btn-danger" role="button">Browse Reviews</a></div>
    </div>
</div>

@endsection