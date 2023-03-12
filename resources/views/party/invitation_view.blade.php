@extends('layouts.app')
@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="d-flex justify-content-center">
        <div class="border border-dark border-2 row justify-content-center align-items-center template_background" style="height : 45rem; width:35rem; background-image: url({{asset($invitation_image_path)}})">
            <div class="text-center h3" style="overflow:hidden">{!! $invitation_title !!}</div>
            <div class="text-center h4" style="overflow:hidden">{!! $invitation_content !!}</div>
        </div>
    </div>
    @if( ! $is_celebrated)
        @switch($guest_response_status)
            @case('No Response')
                <div class="alert alert-info m-0 mb-1 p-2 h5" role="alert" id="invitation_response_container" style="position:fixed; bottom:0">
                    <span class="me-3">
                    Are you coming?
                    </span>
                    <button onclick="record_response('Accepted')" class="btn btn-success">Yes</button>
                    <button onclick="record_response('Declined')" class="btn btn-danger text-white">No</button>
                </div>
                @break

            @case('Accepted')
                <div class="alert alert-success m-0 mb-1 p-2 h5" role="alert" id="invitation_response_container" style="position:fixed; bottom:0">
                    You are going! {{$host_name}} will be waiting for you at the party!
                </div>
                @break

            @case('Declined')
                <div class="alert alert-warning m-0 mb-1 p-2 h5" role="alert" id="invitation_response_container" style="position:fixed; bottom:0">
                    {{$host_name}} is sorry that you could not make it to the party.
                </div>
                @break
                
        @endswitch
    @endif

</div>

<script>
    function record_response(response)
    {
        let data = {
            'guest_id' : {{$guest_id}},
            response,
        };
        $.ajax({
            url: "{{ route('record_guest_response') }}",
            type: "POST",
            data: data,
            success: function(res_data) {

                alertify.alert('Notification', res_data.message, function()
                {
                    if(response == 'Accepted')
                    {
                        $("#invitation_response_container").html('You are going! {{$host_name}} will be waiting for you at the party!')
                        $("#invitation_response_container").removeClass('alert-info')
                        $("#invitation_response_container").addClass('alert-success')
                    }
                    else
                    {
                        $("#invitation_response_container").html('{{$host_name}} is sorry that you could not make it to the party.')
                        $("#invitation_response_container").removeClass('alert-info')
                        $("#invitation_response_container").addClass('alert-warning')
                    }
                });
            },
            error: function(res_data) {
            }
        });

    }
</script>

@endsection