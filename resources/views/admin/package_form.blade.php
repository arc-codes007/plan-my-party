
@extends('layouts.app')

@section('content')

<div class="container">
    <form id="package_form">

         @if (!empty($package_id))
            <input type="hidden" name="package_id" value="{{$package_id}}">
        @endif 

    <div class="card mb-5">
        <div class="card-body" style="background-color: indianred">
            <div class="card-title display-5 text-center">Package Form</div>
                <div class="row gap-4 justify-content-center">
                    {{-- ***************************************** --}}                    
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Venue</label>
                        <select name="venue_id" id="venue_id" class="form-control select2-tags">
                            <option value="">Select Venue</option>
                        </select>
                    </div>
                    {{-- ***************************************** --}}
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>
                    {{-- ***************************************** --}}
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Menu</label>
                        <select name="menu[]" id="menu" class="form-control select2-tags" multiple>
                            <option value="Indian">Indian</option>
                            <option value="Thai">Thai</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Billing Type</label>
                        <select name="billing_config[]" id="billing_config" class="form-control select2-tags" multiple required>
                            <option value="per_person">Per Person</option>
                            <option value="per_hour">Per Hour </option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Cost</label>
                        <input type="number" class="form-control" id="cost" name="cost" required min="0">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Minimum Person</label>
                        <input type="number" class="form-control" id="min_persons" name="min_persons" required min="0">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Maximum Person</label>
                        <input type="number" class="form-control" id="max_persons" name="max_persons" required >
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Venue Type</label>
                        <input type="text" class="form-control" id="venue_type" name="venue_type" required>
                    </div>                    
                    {{-- ***************************************** --}}
                    
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Contact Phone Number</label>
                        <input type="number" class="form-control" id="contact_phone" name="contact_phone">
                    </div>

                    {{-- ***************************************** --}}
                    
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Additional Details</label>
                        <select name="additional_details[]" id="additional_details" class="form-control select2-tags" multiple>
                            <option value="Take Away">Take Away</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                    {{-- <div class="col-md-4 col-sm-12">
                        <label class="form-label">Rating</label>
                        <input type="number" class="form-control" id="venue_rating" name="venue_rating" max=5>
                    </div> --}}
                    {{-- ***************************************** --}}
                    
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Timmings</label>
                        <table class="table table-borderless">
                            <tr>
                                <th>Day</th>
                                <th></th>
                                <th>From :</th>
                                <th>To :</th>
                            </tr>
                            @php
                               $weekdays = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday'); 
                            @endphp
                            @foreach ($weekdays as $day)
                                <tr>
                                    <td>
                                        {{ucfirst($day)}}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="{{$day}}" onclick="enable_disable_time('{{$day}}')" >
                                        </div>     
                                    </td>
                                    <td>
                                        <select disabled name="timmings[{{$day}}][from]" id="{{$day}}_from" class="{{$day.'time'}}" data-width="100%">
                                            <option value="12am">12 AM</option>
                                            @for ($hour = 1; $hour < 12; ++$hour)
                                                <option value="{{$hour.'am'}}">{{$hour.' AM'}}</option>
                                            @endfor
                                            <option value="12pm">12 PM</option>
                                            @for ($hour = 1; $hour < 12; ++$hour)
                                                <option value="{{$hour.'pm'}}">{{$hour.' PM'}}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td>
                                        <select disabled name="timmings[{{$day}}][to]" id="{{$day}}_to" class="{{$day.'time'}}" data-width="100%">
                                            <option value="12am">12 AM</option>
                                            @for ($hour = 1; $hour < 12; ++$hour)
                                                <option value="{{$hour.'am'}}">{{$hour.' AM'}}</option>
                                            @endfor
                                            <option value="12pm">12 PM</option>
                                            @for ($hour = 1; $hour < 12; ++$hour)
                                                <option value="{{$hour.'pm'}}">{{$hour.' PM'}}</option>
                                            @endfor
                                        </select>
                                    </td>
                                </tr>   
                            @endforeach

                        </table>                        
                    </div>    
                    <div class="form-check form-switch col-md-4 col-sm-12">
                        <label class="form-label">Active</label>                        
                        <input class="form-check-input" type="checkbox" role="switch" id="active" name="active">
                    </div>     
 
                </div>


        </div>
    </div>
    <div class="fixed-bottom row bg-white p-3 justify-content-end">
        <div class="col-sm-3">
            <button type="submit" id="save_btn" class="btn btn-danger text-white">Save</button>
            <button type="reset" class="btn btn-outline-danger">Reset</button>
        </div>
    </div>
    </form>
</div>

<script>
     $(document).ready(function(){


        @if(!empty($package_id))

            let package_id = "{{$package_id}}";
            $("#save_btn").prop('disabled', true);
            $.ajax({
                url: "{{ route('fetch_package_details') }}",
                type: "GET",
                data: {package_id},
                success: function(res_data) {
                    for(let key in res_data)
                    {
                        if(key == 'timmings')
                        {
                            for(let day in res_data.timmings)
                            {
                                $('#'+day).prop("checked", true);
                                $('.'+day+'time').prop("disabled", false);
                                $('#'+day+'_from').val(res_data.timmings[day]['from']).trigger('change');
                                $('#'+day+'_to').val(res_data.timmings[day]['to']).trigger('change');
                            }
                        }else if(key == 'active'){
                            $('#'+key).prop("checked",true);
                        }
                        else if(['menu', 'billing_config', 'additional_details'].includes(key))
                        {
                           $('#'+key+' option').each(function (){
                                let val = $(this).val();
                                if(res_data[key].includes(val))
                                {
                                    $(this).prop('selected', true);
                                    delete res_data[key][val];
                                }
                           }); 

                           for(let remaining_val in res_data[key])
                           {
                                $('#'+key).append(`<option selected value="${res_data[key][remaining_val]}">${res_data[key][remaining_val]}</option>`);
                           }
                           $('#'+key).trigger('change')
                        }
                        else
                        {
                            $('#'+key).val(res_data[key]);
                        }
                    }
                    $("#save_btn").prop('disabled', false);
                },
                error: function(res_data) {
                }
            });
        @endif








        $.ajax({
            url: "{{ route('fetch_venue_list') }}",
            type: "GET",
            success: function (response) {
                let data=response.data;
                let option_str="";
                for(let key in data){
                    option_str +=`<option value="${data[key]['id']}"> ${data[key]['name']} </option>`;              
                    }                
                $("#venue_id").append(option_str);
            },
            error:function(){
                console.log("error");
            }
        });

        $('#package_form').submit(function(e) {
            e.preventDefault();
            $("#save_btn").prop('disabled', true);

            let form_data = $('#package_form').serializeArray();

            $.ajax({
                url: "{{ route('add_update_package') }}",
                type: "POST",
                data: form_data,
                success: function(res_data) {
                    $("#save_btn").prop('disabled', false);
                },
                error: function(res_data) {
                    $("#save_btn").prop('disabled', false);
                }
            });

        });

      });

      function enable_disable_time(day)
    {
        if($('#'+day).is(":checked"))
        {
            $('.'+day+'time').prop('disabled', false);
        }
        else
        {
            $('.'+day+'time').prop('disabled', true);
        }
    }
      
</script>

@endsection