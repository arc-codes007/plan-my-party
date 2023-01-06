
@extends('layouts.app')

@section('content')

<div class="container">
    <form id="package_form">

         @if (!empty($package_id))
            <input type="hidden" name="package_id" value="{{$package_id}}">
        @endif 

    <div class="card mb-5">
        <div class="card-body">
            <div class="card-title display-5 text-center">Package Form</div>
            <div class="row gap-4 justify-content-center">
                {{-- ***************************************** --}}                    
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Venue</label>
                    <select name="venue_id" id="venue_id" class="form-control select2-tags" disabled>
                        <option value="" selected disabled>Select Venue</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Type</label>
                    <input type="text" class="form-control" id="type" name="type" required>
                </div>
                
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Venue Type</label>
                    <input type="text" class="form-control" id="venue_type" name="venue_type" required>
                </div>   

                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Billing Type</label>
                    <select name="billing_config[]" id="billing_config" class="form-control" required>
                        <option value="per_person">Per Person</option>
                        <option value="per_hour">Per Hour </option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label h5">Cost (INR)</label>
                            <input type="number" class="form-control" id="cost" name="cost" required min="0">
                        </div>
                        <div class="col-1">
                            <label class="form-label h5">/</label>
                            <label class="form-label h5 mt-2">/</label>
                        </div>
                        <div class="col-5">
                            <label class="form-label h5" id="billing_type">Person(s)</label>
                            <input type="number" class="form-control" id="cost_per_amount" name="cost_per_amount" required min="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Minimum Person</label>
                    <input type="number" class="form-control" id="min_persons" name="min_persons" required min="0">
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Maximum Person</label>
                    <input type="number" class="form-control" id="max_persons" name="max_persons" required >
                </div>
                
                
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Contact Email**</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email">
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Contact Phone Number**</label>
                    <input type="number" class="form-control" id="contact_phone" name="contact_phone">
                </div>
                
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Additional Details</label>
                    <select name="additional_details[]" id="additional_details" class="form-control select2-tags" multiple>
                        <option value="Take Away">Take Away</option>
                        <option value="Delivery">Delivery</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Active</label>
                    <div class="form-check form-switch mt-1">
                        <input class="form-check-input" type="checkbox" role="switch" id="active" name="active">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Menu</label>
                    <div class="d-flex align-items-center">
                        <input type="text" id="menu_type" placeholder="Type (Starter,Main...)" class="form-control">
                        <input type="number" min=1 id="number_of_dishes" placeholder="Number fo Dishes" class="form-control ms-1">
                        <button role="button" data-bs-toggle="tooltip" title="Add" class="btn btn-sm btn-success mx-2" onclick="add_menu_section(event)"><i class="fa-solid fa-plus fa-lg"></i></button>
                    </div>
                    <div class="accordion mt-3" id="menu_area"></div>
                </div>  
                <div class="col-md-4 col-sm-12">
                    <label class="form-label h5">Timmings**</label>
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
            </div>
            <div>** If these fields are not filled then data will be shown as saved in venue.</div>
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
    $(document).ready(function()
    {
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
                        else if(key == 'billing_config')
                        {
                            $('#'+key).val(res_data.billing_config.type).trigger('change');
                            $('#cost_per_amount').val(res_data.billing_config.cost_per_amount);
                        }
                        else if(key == 'additional_details')
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
                        else if(key == 'menu')
                        {
                            for(let menu_type in res_data.menu)
                            {
                                let dishes = res_data.menu[menu_type];

                                let dishes_str = '';
                                for(let [dish_count,dish] of dishes.entries())
                                {
                                    dishes_str += `<input type="text" class="form-control mt-1" name="menu[${menu_type}][]" placeholder="${dish_count+1} Dish Name" value="${dish}" required>`;
                                }

                                let prepared_accordion_str = `
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${menu_type}_collapse">
                                            ${menu_type} - ${dishes.length} Dishes
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" onclick="remove_menu_section(event,this)">
                                                <i class="fa-solid fa-xmark"></i>
                                            </span>
                                        </button>
                                        </h2>
                                        <div id="${menu_type}_collapse" class="accordion-collapse collapse" data-bs-parent="#menu_area">
                                            <div class="accordion-body bg-white">
                                                ${dishes_str}
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#menu_area').append(prepared_accordion_str);
                            }
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
                $("#venue_id").prop("disabled", false);
            },
            error:function(){
                console.log("error");
            }
        });

        $('#package_form').submit(function(e) {
            console.log('test');
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

        $('#billing_config').on('change', function(){
            if($('#billing_config').val() == 'per_person')
            {
                $('#billing_type').text('Person(s)');
            }
            else
            {
                $('#billing_type').text('Hour(s)');
            }
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

    function add_menu_section(e)
    {
        e.preventDefault();
        let menu_type = $('#menu_type').val().trim();
        let number_of_dishes = $('#number_of_dishes').val();

        if( ! menu_type && number_of_dishes < 1)
        {
            alertify.alert('Error','Please enter type and number of dishes first!');
            return false;
        }

        $('#menu_type').val('');
        $('#number_of_dishes').val('');

        let dishes_str = '';
        for(let dish_count = 1; dish_count <= number_of_dishes; ++dish_count)
        {
            dishes_str += `<input type="text" class="form-control mt-1" name="menu[${menu_type}][]" placeholder="${dish_count} Dish Name" required>`;
        }

        let prepared_accordion_str = `
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#${menu_type}_collapse">
                    ${menu_type} - ${number_of_dishes} Dishes
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" onclick="remove_menu_section(event,this)">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                </button>
                </h2>
                <div id="${menu_type}_collapse" class="accordion-collapse collapse show" data-bs-parent="#menu_area">
                    <div class="accordion-body bg-white">
                        ${dishes_str}
                    </div>
                </div>
            </div>
        `;
        $('.accordion-collapse').removeClass('show');
        $('.accordion-button').addClass('collapsed');
        $('#menu_area').append(prepared_accordion_str);

    }

    function remove_menu_section(e,self)
    {
        e.preventDefault();
        $(self).closest('.accordion-item').remove();
    }
      
</script>

@endsection