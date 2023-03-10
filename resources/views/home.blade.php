@extends('layouts.app')

@section('content')

@if (count($user_parties) > 0)
<div class="container mt-5 p-2">
    <div class="h1">Your Parties</div>
    <div class="row">
        @foreach ($user_parties as $party)
            <div class="my-2 col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100">
                    <img src="{{$party['image_src']}}" class="card-img-top" alt="party_image">
                    <div class="card-body">
                        <h5 class="card-title">{{$party['name']}}</h5>
                        <div class="badge {{config('pmp.party_status_class.'.$party['status'])}} p-2 fs-6 my-2">Draft</div>
                        <div class="card-text">
                            <div class="my-1">
                                Date - {{$party['date']}}
                            </div>
                            <div class="my-1">
                                Venue - <a href="{{route('venue_details',$party['venue_id'])}}">{{$party['venue_name']}}</a>
                            </div>
                            @if (!empty($party['package_name']))
                                <div class="my-1">
                                    Package - <span style="text-decoration: underline; cursor: pointer;" onclick="toggle_package_view_modal({{$party['package_id']}},'{{ route('get_package_data') }}')">{{$party['package_name']}}</span>
                                </div>                                
                            @endif
                        </div>
                    </div>
                    <div class="d-grid card-footer bg-white">
                        <a href="{{route('party_planning', $party['id'])}}" class="btn btn-danger text-white">Edit</a>
                    </div>
                </div>
            </div>            
        @endforeach
    </div>
</div>    
@endif
@include('components.venues')
@include('components.packages')

<div class="container p-2">
    <div class="row">
        <h1 class="text-danger">My Parties</h1>
    </div>
</div>

@endsection
