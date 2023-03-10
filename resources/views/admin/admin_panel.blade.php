@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row align-items-center my-3">
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-user icon_6em"></i>
                        </div>
                        <div class="col-8">
                            <div class="row justify-content-center">
                                <h1 class="text-center"><span id="user_count">0</span> Users</h1>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mx-1 text-center"><a href="{{ route('user_list') }}" class="btn btn-outline-light">List</a></div>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row align-items-center my-3">
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-utensils icon_6em"></i>
                        </div>
                        <div class="col-8">
                            <div class="row justify-content-center">
                                <h1 class="text-center"><span id="venue_count">0</span> Venues</h1>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mx-1 text-center"><a href="{{ route('venue_form') }}" class="btn btn-outline-light">Add</a></div>
                                <div class="mx-1 text-center"><a href="{{ route('venue_list') }}" class="btn btn-outline-light">List</a></div>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row align-items-center my-3">
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-box icon_6em"></i>
                        </div>
                        <div class="col-8">
                            <div class="row justify-content-center">
                                <h2 class="text-center"><span id="package_count">0</span> Packages</h2>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mx-1 text-center"><a href="{{ route('package_form') }}" class="btn btn-outline-light">Add</a></div>
                                <div class="mx-1 text-center"><a href="{{ route('package_list') }}" class="btn btn-outline-light">List</a></div>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row align-items-center my-3">
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-gifts icon_6em"></i>
                        </div>
                        <div class="col-8">
                            <div class="row justify-content-center">
                                <h1 class="text-center"><span id="party_count">0</span> Parties</h1>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mx-1 text-center"><a href="" class="btn btn-outline-light">Add</a></div>
                                <div class="mx-1 text-center"><a href="" class="btn btn-outline-light">List</a></div>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
        </div>        
    </div>
    <div class="row justify-content-start">
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="row align-items-center ">
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-user icon_6em"></i>
                        </div>
                        <div class="col-8">
                            <div class="row justify-content-center">
                                <h1 class="text-center"><span id="templates_count">0</span> Template</h1>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mx-1 text-center"><a href="{{ route('template_form') }}" class="btn btn-outline-light">Add</a></div>
                                <div class="mx-1 text-center"><a href="{{ route('template_list') }}" class="btn btn-outline-light">List</a></div>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
        </div>

    </div>


</div>

<script>

$(document).ready(function()
{
    $.ajax({
            url: "{{ route('fetch_admin_dash_stats') }}",
            type: "GET",
            success: function(response) {
                $('#user_count').html(response.data.users);
                $('#venue_count').html(response.data.venues);
                $('#package_count').html(response.data.packages);
            },
            error: function(res_data) {
            }
        });
});

</script>
@endsection