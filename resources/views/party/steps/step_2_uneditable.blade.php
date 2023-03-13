<div class="row h5">
    <div class="col-6">
            <div class="mx-2 my-3 mt-4">
                Party Name - {{$party_data['name']}}
            </div>
            <div class="mx-2 my-3 mt-4">
                Party Date - {{date("d M Y", strtotime($party_data['date']))}}
            </div>
            <div class="mx-2 my-3 mt-4">
                Person Count - {{$party_data['person_count']}}
            </div>

            <div class="mx-2 my-3 mt-4">
                Timming - {{$party_data['timming']['from']}} to {{$party_data['timming']['to']}}
            </div>

            @if (isset($package_data))
                <div class="mx-2 my-3">
                    Package - {{$package_data['name']}}
                </div>
            @endif
            <div class="mx-2 my-3">
                Venue - {{$venue_data['name']}}
            </div>
            <div class="mx-2 my-3">
                Contact Email - {{$contact_email}}
            </div>
            <div class="mx-2 my-3">
                Contact Phone - {{$contact_phone}}
            </div>
            @if (isset($package_data))
            <div class="mx-2 my-3">
                Approximate Total Cost - {{$party_data['person_count']*$package_data['cost']}} /-</span>
            </div>
            @endif
    </div>
    <div class="col-6 d-flex p-5 justify-content-center align-items-center">
        <div class="border border-dark border-2 row justify-content-center align-items-center template_background" style="height : 70vh; width:70%; background-image: url({{asset($invitation_data->invite_template->image_path)}})">
            <div class="text-center h3 mx-2 fw-bold" style="overflow:hidden">{!! $invitation_data['title'] !!}</div>
            <div class="text-center h4 mx-2 fw-bold" style="overflow:hidden">{!! $invitation_data['content'] !!}</div>
        </div>
    </div>
</div>