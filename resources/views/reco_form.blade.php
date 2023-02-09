@extends('layouts.app')
@section('content')
<div class="container-fluid row">
    <div class="container col-sm-12 col-md-9 border-end border-3 border-danger p-3 justify-content-around">
        <div class="row text-center text-danger">
            <h3 class="fw-bolder">Plan your Party!!</h3>
        </div>
        <form id="party_form" class="row">
            <div class="card-body col-4 fs-5 border border-danger p-2 m-1" name="type">
                <label class="form-label">Your party type?</label><br>
                <table>
                    <tr>
                        <td><input class="form-check-input" type="radio" name="type" value="bday" id="bday" onchange="selected()"> Birthday</td>
                        <td><input class="form-check-input" type="radio" name="type" value="anni" id="anni"> Anniversary</td>
                    </tr>
                    <tr>
                        <td><input class="form-check-input" type="radio" name="type" value="coorp" id="coorp"> Coorporate Event</td>
                        <td><input class="form-check-input" type="radio" name="type" value="casual" id="casual"> Casual</td>
                    </tr>
                </table>

            </div>
            <div class="card-body col-4 fs-5 border border-danger p-2 m-1" name="venue_type">
                <label class="form-label">Venue Type</label><br>
                <table>
                    <tr>
                        <td> <input class="form-check-input" type="radio" name="venue_type" value="cafe" id="cafe" onchange="selected()"> Cafe
                        </td>
                        <td> <input class="form-check-input" type="radio" name="venue_type" value="fine dining" id="fd"> Fine Dining <br>
                        </td>
                    </tr>
                    <tr>
                        <td> <input class="form-check-input" type="radio" name="venue_type" value="multi cuisine" id="mc"> Multi Cuisine
                        </td>
                        <td> <input class="form-check-input" type="radio" name="venue_type" value="all" id="all"> All
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-body col-4 fs-5 border border-danger p-2 m-1" name="must_have">
                <label class="form-label">Must have facility at venue</label><br>
                <table>
                    <tr>
                        <td> <input class="form-check-input" type="radio" name="must_have" value="parking" id="parking" onchange="selected()"> Parking
                        </td>
                        <td> <input class="form-check-input" type="radio" name="must_have" value="ambience" id="ambience"> Ambience <br>
                        </td>
                    </tr>
                    <tr>
                        <td> <input class="form-check-input" type="radio" name="must_have" value="casual" id="space"> Ample Space for sitting
                        <!-- </td>
                        <td> <input class="form-check-input" type="radio" name="must_have" value="casual" id="casual">
                        </td> -->
                    </tr>
                </table>
            </div>
            <div class="card-body col-4 fs-5 border border-danger p-2 m-1" name="members">
                <label class="form-label">Members</label><br>
                <table>
                    <tr>
                        <td> <input class="form-check-input" type="radio" name="members" value="5" id="1to5" onchange="selected()"> 1-5
                        </td>
                        <td> <input class="form-check-input" type="radio" name="members" value="10" id="6to10"> 6-10 <br>
                        </td>
                    </tr>
                    <tr>
                        <td> <input class="form-check-input" type="radio" name="members" value="15" id="10to15"> 10-15
                        </td>
                        <td> <input class="form-check-input" type="radio" name="members" value="16" id="15p"> 15+
                        </td>
                    </tr>
                </table>
            </div>
            <div class="row p-3 justify-content-start">
                <div class="col-sm-3">
                    <button type="submit" id="save_btn" class="btn btn-danger text-white">Done</button>
                    <button type="reset" class="btn btn-outline-danger">Reset</button>
                </div>
            </div>
        </form>
    </div>
    <!-- form div ending -->



    <div class="row col-md-3 p-3 justify-content-center">
        <div class="row text-center text-danger">
            <h3 class="fw-bold">Featured Restaurants</h3>
        </div>
        <div class="card m-1" style="width: 14rem; height: 16rem;">
            <img src="https://www.jodhpursearch.com/wp-content/uploads/2021/12/unnamed-2.jpg " class="card-img-top img-fluid" alt="..." style="width: 16rem; height: 12rem;">
            <div class="card-body">
                <a href="{{route('reco_form')}}">
                    <h5 class="card-title text-black">FOMO</h5>
                </a>
            </div>
        </div>
        <div class="card m-1" style="width: 14rem; height: 16rem;">
            <img src="https://www.jodhpursearch.com/wp-content/uploads/2021/12/unnamed-2.jpg " class="card-img-top img-fluid" alt="..." style="width: 16rem; height: 12rem;">
            <div class="card-body">
                <a href="{{route('reco_form')}}">
                    <h5 class="card-title text-black">FOMO</h5>
                </a>
            </div>
        </div>
    </div>
    <!-- Recommendations div ends -->
</div>


<script>
    $.ajax({
        url: "{{ route('fetch_venues') }}",
        type: "GET",
        success: function(res_data){
            console.log(res_data);
            // for (let key in res_data) {

            // }
        },
    });


    function selected(){
        let form_data = new FormData(document.getElementById("party_form")); 
        console.log(form_data);
            $.ajax({
                url: "{{ route('party_pref') }}",
                type: "POST",
                data: form_data,
                processData: false,
                contentType: false,
                success: function(res_data) {
                    $("#save_btn").prop('disabled', false);
                    console.log("success");
                    console.log(res_data);
                },
                error: function(res_data) {
                    $("#save_btn").prop('disabled', false);
                    console.log("error in party form");
                    console.log(res_data);
                }
            });
    }

    // $('#party_form').submit(function(e) {
    //         e.preventDefault();
    //         let form_data = new FormData(document.getElementById("party_form"));
    //         // console.log(form_data);
    //         $.ajax({
    //             url: "{{ route('party_pref') }}",
    //             type: "POST",
    //             data: form_data,
    //             processData: false,
    //             contentType: false,
    //             success: function(res_data) {
    //                 $("#save_btn").prop('disabled', false);
    //                 console.log("success");
    //             },
    //             error: function(res_data,status,error) {
    //                 $("#save_btn").prop('disabled', false);
    //                 console.log("error in party form");
    //                 // console.log(res_data.responseText);
    //             }
    //         });
    //     });
</script>
@endsection