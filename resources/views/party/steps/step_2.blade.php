<div class="row h5">
    <div class="col-6">
        <form id="party_plan_form">
            <input type="hidden" name="party_id" value="{{$party_data['id']}}">
            <div class="mx-2">
                <div class="my-3">
                    <label for="party_name" class="mb-2 form-label">Party Name:</label>
                    <input type="text" class="form-control" name="party_name" id="party_name" value="{{$party_data['name']}}">
                </div>
            </div>
            <div class="mx-2">
                <div class="my-3">
                    <label for="party_date" class="mb-2 form-label">Party Date:</label>
                    <input type="date" class="form-control" name="party_date" id="party_date" value="{{date('Y-m-d', strtotime($party_data['date']))}}">
                </div>
            </div>
            <div class="mx-2">
                <div class="my-3">
                    <label for="party_person_count" class="mb-2 form-label">Person Count:</label>
                    <input type="number" class="form-control" name="party_person_count" id="party_person_count" value="{{$party_data['person_count']}}">
                </div>
            </div>
            <div class="mx-2">
                <div class="my-3">
                    <label for="party_timming" class="mb-2 form-label">Timming:</label>
                    <table class="table table-borderless">
                        <tr>
                            <th>From : -</th>
                            <th>To : -</th>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" name="party_timming['from']" data-width="100%">
                                    <option value="12:00am">12:00 AM</option>
                                    @for ($hour = 1; $hour < 12; $hour+=0.5) 
                                        @php
                                            $temp_hour = explode('.' , $hour);
                                            $time_str = $temp_hour[0];
                                            if(isset($temp_hour[1]) && $temp_hour[1] == '5')
                                            {
                                                $time_str .=  ':30';
                                            } 
                                            else 
                                            {
                                                $time_str .=  ':00';
                                            }
                                        @endphp
                                        <option value="{{$time_str.'am'}}">{{$time_str.' AM'}}</option>
                                    @endfor
                                    
                                    <option value="12:00pm">12:00 PM</option>
                                    
                                    @for ($hour = 1; $hour < 12; $hour+=0.5) 
                                        @php
                                            $temp_hour = explode('.' , $hour);
                                            $time_str = $temp_hour[0];
                                            if(isset($temp_hour[1]) && $temp_hour[1] == '5')
                                            {
                                                $time_str .=  ':30';
                                            } 
                                            else 
                                            {
                                                $time_str .=  ':00';
                                            }
                                        @endphp
                                        <option value="{{$time_str.'pm'}}">{{$time_str.' PM'}}</option>
                                    @endfor
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="party_timming['to']" data-width="100%">
                                    <option value="12:00am">12:00 AM</option>
                                    @for ($hour = 1; $hour < 12; $hour+=0.5) 
                                        @php
                                            $temp_hour = explode('.' , $hour);
                                            $time_str = $temp_hour[0];
                                            if(isset($temp_hour[1]) && $temp_hour[1] == '5')
                                            {
                                                $time_str .=  ':30';
                                            } 
                                            else 
                                            {
                                                $time_str .=  ':00';
                                            }
                                        @endphp
                                        <option value="{{$time_str.'am'}}">{{$time_str.' AM'}}</option>
                                    @endfor
                                    
                                    <option value="12:00pm">12:00 PM</option>
                                    
                                    @for ($hour = 1; $hour < 12; $hour+=0.5) 
                                        @php
                                            $temp_hour = explode('.' , $hour);
                                            $time_str = $temp_hour[0];
                                            if(isset($temp_hour[1]) && $temp_hour[1] == '5')
                                            {
                                                $time_str .=  ':30';
                                            } 
                                            else 
                                            {
                                                $time_str .=  ':00';
                                            }
                                        @endphp
                                        <option value="{{$time_str.'pm'}}">{{$time_str.' PM'}}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @if (isset($package_data))
                <div class="mx-2 my-3">
                    Package - {{$package_data['name']}}
                </div>
            @endif
            <div class="mx-2 my-3">
                Venue - {{$venue_data['name']}}
            </div>
            @if (isset($package_data))
            <div class="mx-2 my-3">
                Approximate Total Cost - <span id="party_total_cost">{!!(empty($party_data['person_count'])) ? '<span class="text-danger h5">Enter Person Count</span>' : $party_data['person_count']*$package_data['cost']." /-"!!}</span>
            </div>
            @endif
            <div class="mx-2 my-3">
                <button type="submit" id="party_save_btn" class="btn btn-success text-white">Save</button>
            </div>
        </form>
    </div>
    <div class="col-6 d-flex p-5 justify-content-center align-items-center">
        <div class="border border-dark border-2 row justify-content-center align-items-center" style="height : 70vh; width:70%">
            <div class="text-center">
                Invitation Not Created
            </div> 
            <div class="text-center">
                <button role="button" class="btn btn-success text-white">Create Now!</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(() => {
    $('#party_person_count').change(function(){
        let cost = "{{$package_data['cost']}}";

        $("#party_total_cost").html(cost*$(this).val()+" /-");
    });

    $("#party_plan_form").submit(function(e){
        e.preventDefault();

        $("#party_save_btn").prop('disabled', true);

        let form_data = new FormData(document.getElementById("party_plan_form"));

        $.ajax({
            url: "{{ route('save_party_data') }}",
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(res_data) {
                alertify.alert('Notification', res_data.message);
                $("#party_save_btn").prop('disabled', false);
            },
            error: function(res_data) {
                $("#party_save_btn").prop('disabled', false);
            }
        });
    })
});
</script>