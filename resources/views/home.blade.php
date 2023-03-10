@extends('layouts.app')

@section('content')

@include('components.venues')
@include('components.packages')

<div class="container p-2">
    <div class="row">
        <h1 class="text-danger">My Parties</h1>
    </div>
</div>

@endsection
