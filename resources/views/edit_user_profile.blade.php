@extends('layouts.app')
@section('content')

<div class="container p-3">
    <div class="row text-center text-danger">
        <h2 class="fw-bolder">Edit Profile Info</h2>
    </div>
    <div>
        <form id="update_user_form">
            <div class="row fs-3">
                <div class="col-2">Name</div>
                <div class="col-2">{{Auth::user()->name}}</div>
            </div>
            <div>
                <input type="hidden" id="id" name="id" value="{{Auth::user()->id}}">
            </div>
            <div class="row fs-3">
                <div class="col-2">E-mail</div>
                <input type="email" id="email" name="email" class="col-3" placeholder="{{Auth::user()->email}}" required>
            </div>
            <div class="row fs-3">
                <div class="col-2">Mobile</div>
                <input type="text" id="phone" name="phone" class="col-3" placeholder="{{Auth::user()->phone}}" required>
            </div>
            <div class="p-2">
                <button type="submit" id="save_btn" onclick="update_user()" class="btn btn-danger text-white">Done</button>
                <a href = "{{route('reset_password')}}" id="changepass_btn" onclick="" class="btn btn-danger text-white">Change Password</a>
            </div>
        </form>
    </div>
</div>
<script>
    // function update_user() {


        function change_pass(e,user_id){
            e.preventDefault();
            console.log(user_id);
            $.ajax({
            url: "{{route('reset_password')}}",
            type: "get",
            data: {user_id},
            success: function(res_data) 
            {
                $(e.target).parent().parent().remove();
                alertify.alert('Success', res_data.responseJSON.message);
            },
            error: function(res_data) {
                alertify.alert('Error', res_data.responseJSON.error);
            }
        });
        }



    $('#update_user_form').submit(function(e) {
        e.preventDefault();
        $("#save_btn").prop('disabled', true);
        let form_data = new FormData(document.getElementById("update_user_form"));
        // console.log(form_data);
        $.ajax({
            url: "{{ route('update_user') }}",
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(res_data) {
                $("#save_btn").prop('disabled', false);
                console.log("successfully updated");
                console.log(res_data);
            },
            error: function(res_data) {
                $("#save_btn").prop('disabled', false);
                console.log("error in update");
                console.log(res_data);
            }
        });
    });
    // }
</script>
@endsection