@extends('layouts.app')

@section('content')

@if (isset($user_parties) &&  is_array($user_parties) && count($user_parties) > 0)
<div class="container mt-5 p-2">
    <div class="h1 text-danger">Your Parties</div>
    <div class="row">
        @foreach ($user_parties as $party)
            <div class="my-2 col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100">
                    <img src="{{$party['image_src']}}" class="card-img-top" alt="party_image">
                    <div class="card-body">
                        <h5 class="card-title">{{$party['name']}}</h5>
                        <div class="badge {{config('pmp.party_status_class.'.$party['status'])}} p-2 fs-6 my-2">{{$party['status']}}</div>
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
                    @if (! $party['rated_by_user'])
                        <div class="d-grid card-footer bg-white">
                            @if ($party['status'] == config('pmp.party_statuses.celebrated'))
                                <button class="btn btn-danger text-white" onclick="open_review_modal({{$party['id']}})">Rate the Party</button>
                            @else
                                <a href="{{route('party_planning', $party['id'])}}" class="btn btn-danger text-white">Edit</a>
                            @endif
                        </div>                        
                    @endif
                </div>
            </div>            
        @endforeach
    </div>
</div>    

<script>
    function open_review_modal(party_id)
    {
        $("#review_for_party_id").val(party_id);

        var add_review_modal = new bootstrap.Modal(document.getElementById('add_review_modal'));
        add_review_modal.toggle();

    }
</script>
@endif
@include('components.venues')
@include('components.packages')

@endsection
