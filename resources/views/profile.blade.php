@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white text-center">{{ __('Profile') }}</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Name</label>
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label text-md-end">{{Auth::user()->name;}}</label>
                        </div>
                    </div>

                    <form id="update_user_form">
                        <input type="hidden" id="id" name="id" value="{{Auth::user()->id}}">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone Number</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" required>
                            </div>
                        </div>
                        <div class="card-footer row bg-white m-1 p-2 justify-content-between">
                            <div class="col-md-3">
                                <button type="submit" id="save_btn" class="btn btn-danger text-white">Save</button>
                            </div>
                    </form>
                    <div class="col-md-9 text-end">
                        <button type="button" id="change_pass_btn" class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#change_pass_modal">Change Password</button>
                        <button type="reset" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#DeleteModal">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Delete Modal -->
<div class="modal fade" id="DeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="delete_form" method="post" action="{{ route('delete_user') }}">
                @csrf
            <input type="hidden" id="del_user_id" name="del_user_id" value="{{Auth::user()->id}}">
            <div class="modal-body">
                Please Enter Your Current Password to Delete Account
                <input type="text" id="delete_pass_confirm" name="delete_pass_confirm"><br><br>
                *Account deleted will never get restored
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="delete_btn" class="btn btn-danger text-white">Delete Account</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal end -->



<!--Change password Modal -->
<div class="modal fade" id="change_pass_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Change Your Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="change_pass_form" action="{{ route('update_password') }}">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                            <div class="row mb-3">
                                <label for="current_pass" class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                                <div class="col-md-6">
                                    <input id="current_pass" type="text" class="form-control @error('current_pass') is-invalid @enderror" name="current_pass" value="{{ $current_pass ?? old('current_pass') }}" required autocomplete="current_pass" autofocus>

                                    @error('current_pass')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password_confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password_confirm" type="password" class="form-control" name="password_confirm" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-danger text-white">
                                        {{ __('Change Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Change password modal end-->



<script>
    $(document).ready(function() {

        let user_id = "{{Auth::user()->id}}";
        console.log(user_id);
        $("#save_btn").prop('disabled', true);
        $.ajax({
            url: "{{ route('fetch_user_detail') }}",
            type: "GET",
            data: {
                user_id
            },
            success: function(res_data) {
                for (let key in res_data) {
                    $('#' + key).val(res_data[key]);
                }
                $("#save_btn").prop('disabled', false);
            },
            error: function(res_data) {
                alertify.alert('Error', res_data.responseJSON.error);
            }
        });


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
                    alertify.alert('Error', res_data.responseJSON.error);
                    console.log("error in update");
                    console.log(res_data);
                }
            });
        });
    });
</script>
@endsection