<div class="h5">
    <div class="mx-2 mb-3 pt-3 text-danger fw-bold h2 d-flex align-items-center">
        <span class="me-2">
            Guests
        </span>
        <span class="mx-2">
            <span data-bs-toggle="modal" data-bs-target="#add_guest_form_modal">
                <button class="btn btn-primary text-white" data-bs-toggle="tooltip" title="Add Guest">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </span>
        </span>
        <span class="mx-2">
            <button onclick="send_invitation({{$party_data['id']}}, 'all')" class="btn btn-primary text-white">
                Send Invite to all Guests
            </button>                
        </span>
    </div>
    <div class="row mt-4" id="party_guests_container">
        @if (count($party_guests) > 0)
            @foreach ($party_guests as $guest)
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-2" id="party_guest_container_{{$guest->id}}">
                    <div class="card h-100">
                        <div class="d-flex justify-content-center p-3 w-100">
                            <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width:100px;height:100px" alt="Avatar">
                                <i class="fas fa-user-alt fa-3x text-info"></i>
                            </div>
                        </div>
                
                        <div class="card-body">
                            <h5 class="card-title text-center" id="party_guest_name_{{$guest->id}}">{{$guest->name}}</h5>
                            <div class="card-text text-center">
                                <div id="party_guest_email_{{$guest->id}}">
                                    {{$guest->email}}
                                </div>
                                <div class="mt-1">
                                    Status - 
                                    @switch($guest->status)
                                        @case('No Response')
                                            <span class="text-warning">No Response</span>        
                                            @break

                                        @case('Accepted')
                                            <span class="text-success">Accepted</span>        
                                            @break

                                        @case('Declined')
                                            <span class="text-danger">Declined</span>        
                                            @break
                                                                                
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        @if ($guest->status != 'Accepted')                            
                            <div class="card-footer bg-white d-flex justify-content-center">
                                @if ($guest->status == 'No Response')
                                    <button onclick="send_invitation({{$guest->id}}, 'single')" class="btn btn-success mx-1 text-nowrap">Send Invite</button>                            
                                    <button onclick="edit_party_guest({{$guest->id}}, '{{$guest->name}}', '{{$guest->email}}')" class="btn btn-primary text-white mx-1" data-bs-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                @endif
                                @if (in_array($guest->status, ['No Response', 'Declined']))
                                    <button onclick="delete_party_guest({{$guest->id}})" class="btn btn-danger text-white mx-1" data-bs-toggle="tooltip" title="Delete"><i class="fa-solid fa-trash-can"></i></button>                            
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>

<div class="modal" tabindex="-1" id="add_guest_form_modal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Guest</h5>
            </div>
            <form id="add_guest_form">
                <input type="hidden" name="guest_id" id="guest_id">
                <input type="hidden" name="party_id" id="guest_form_party_id" value="{{$party_data['id']}}">
                <div class="modal-body">
                        <div class="my-3">
                            <label for="guest_name" class="mb-2 form-label">Name:</label>
                            <input type="text" name="guest_name" id="guest_name" class="form-control" required>
                        </div>
                        <div class="my-3">
                            <label for="guest_email" class="mb-2 form-label">Email:</label>
                            <input type="email" name="guest_email" id="guest_email" class="form-control" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" id="party_guest_form_close_btn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="party_guest_form_save_btn" class="btn btn-primary text-white">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

$(document).ready(function (){

    $("#add_guest_form").submit((e) => {
        e.preventDefault();

        let is_edit = false;
        let data = {
            'party_id' : $("#guest_form_party_id").val(),
            'guest_name' : $("#guest_name").val(),
            'guest_email' : $("#guest_email").val(),
        };

        if($("#guest_id").val())
        {
            data['guest_id'] = $("#guest_id").val();
            is_edit = true;
        }

        $("#party_guest_form_save_btn").prop('disabled', true);

        $.ajax({
            url: "{{ route('create_update_guest') }}",
            type: "POST",
            data: data,
            success: function(res_data) {

                if(is_edit)
                {
                    $('#party_guest_name_'+data['guest_id']).html(data['guest_name']);
                    $('#party_guest_email_'+data['guest_id']).html(data['guest_email']);
                }
                alertify.alert('Notification', res_data.message, function()
                {
                    $("#party_guest_form_close_btn").click();

                    if( ! is_edit)
                    {
                        $("#party_guests_container").append(
                            `
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-2" id="party_guest_container_${res_data.guest_id}">
                                <div class="card h-100">
                                    <div class="d-flex justify-content-center p-3 w-100">
                                        <div class="rounded-circle border d-flex justify-content-center align-items-center" style="width:100px;height:100px" alt="Avatar">
                                            <i class="fas fa-user-alt fa-3x text-info"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-center" id="party_guest_name_${res_data.guest_id}">${data['guest_name']}</h5>
                                        <div class="card-text text-center">
                                            <div id="party_guest_email_${res_data.guest_id}">
                                                ${data['guest_email']}
                                            </div>
                                            <div class="mt-1">
                                                Status - <span class="text-warning">No Response</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white d-flex justify-content-center">
                                        <button onclick="send_invitation(${res_data.guest_id}, 'single')" class="btn btn-success mx-1 text-nowrap">Send Invite</button>                            
                                        <button onclick="edit_party_guest(${res_data.guest_id}, '${data['guest_name']}', '${data['guest_email']}')" class="btn btn-primary text-white mx-1" data-bs-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button onclick="delete_party_guest(${res_data.guest_id})" class="btn btn-danger text-white mx-1" data-bs-toggle="tooltip" title="Delete"><i class="fa-solid fa-trash-can"></i></button>                            
                                    </div>
                                </div>
                            </div>
                            `
                        );
                    }
                });
                
                $("#party_guest_form_save_btn").prop('disabled', false);

            },
            error: function(res_data) {
                $("#party_guest_form_save_btn").prop('disabled', false);
            }
        });
    })

});

function edit_party_guest(guest_id, guest_name, guest_email)
{
    $("#guest_name").val(guest_name);
    $("#guest_email").val(guest_email);
    $("#guest_name").val(guest_name);
    $("#guest_id").val(guest_id);

    var add_guest_form_modal = new bootstrap.Modal(document.getElementById('add_guest_form_modal'));
    add_guest_form_modal.toggle();
}

function delete_party_guest(guest_id)
{
    alertify.confirm('Notification', 'Are you sure?', function(){

        $.ajax({
            url: "{{ route('delete_guest') }}",
            type: "POST",
            data: {guest_id},
            success: function(res_data) {

                alertify.alert('Notification', res_data.message, function()
                {
                    $('#party_guest_container_'+guest_id).remove();
                });
            },
            error: function(res_data) {
            }
        });
    },
    function(){});
}

function send_invitation(id, type)
{
    let data = {
        'action_type': type
    };

    if(type == 'single')
    {
        data['guest_id'] = id;
    }
    else
    {
        data['party_id'] = id;
    }

    alertify.confirm('Notification', "Are you sure?", function(){

            $.ajax({
                url: "{{ route('send_invitation') }}",
                type: "POST",
                data: data,
                success: function(res_data) {

                    alertify.alert('Notification', res_data.message);
                },
                error: function(res_data) {
                }
            });
        },
    function(){}).set('labels', {ok: 'Yes', cancel: 'No'});



}

</script>