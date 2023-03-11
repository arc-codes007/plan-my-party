@extends('layouts.app')
@section('content')

<div id="wrapper">
    @include("party.steps_menu")
      
    <section id="content-wrapper">
        <div id="step_1_content" {{(empty($party_data)) ? '' : 'style="display:none"'}}>
            @if (empty($party_data))
                @include("party.steps.step_1")            
            @endif
        </div>
        <div id="step_2_content">
            @if (!empty($party_data))    
                @if ($is_planned)
                    @include("party.steps.step_2_uneditable")
                @else
                    @include("party.steps.step_2")            
                @endif
            @endif
        </div>
        @if ( ! $is_planned)
            <div id="step_3_content" style="display: none">
                @if (!empty($party_data))    
                    @include("party.steps.step_3")
                @endif
            </div>
        @endif
        <div id="step_4_content" style="display: none">
            @if (!empty($party_data))    
                @include("party.steps.step_4")
            @endif
        </div>

    </section>
</div>

<script>
    function navigate_to(step)
    {
        switch (step) 
        {
            case 2:

                $('#step_3_button').removeClass('active');
                $('#step_4_button').removeClass('active');
                $('#step_3_content').hide();
                $('#step_4_content').hide();
                $('#step_2_button').addClass('active');
                $('#step_2_content').show();

                window.location.href = window.location.href+'#step_1'

                break;        

            case 3:

                $('#step_2_button').removeClass('active');
                $('#step_4_button').removeClass('active');
                $('#step_2_content').hide();
                $('#step_4_content').hide();
                $('#step_3_button').addClass('active');
                $('#step_3_content').show();

                break;

            case 4:

                $('#step_2_button').removeClass('active');
                $('#step_3_button').removeClass('active');
                $('#step_2_content').hide();
                $('#step_3_content').hide();
                $('#step_4_button').addClass('active');
                $('#step_4_content').show();

                break;
        }
    }

    @if (!empty($party_data))    

        function set_to_planned()
        {
            alertify.confirm("Notification", "Are you sure?<br> Once a party is set to planned you won't be able to edit any party data except managing the guest. Proceed with caution.",
            function(){

                    let data = {
                        'party_id' : {{$party_data['id']}}
                    };
                    $.ajax({
                    url: "{{ route('set_party_to_planned') }}",
                    type: "POST",
                    data: data,
                    success: function(res_data) {
                        
                    },
                    error: function(res_data) {
                    }
                });
            },
            function(){}).set('labels', {ok:'Yes', cancel:'No'});
        }

    @endif
</script>

@endsection