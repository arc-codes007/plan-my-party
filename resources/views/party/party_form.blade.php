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
                @include("party.steps.step_2")            
            @endif
        </div>
        <div id="step_3_content" style="display: none">
            @if (!empty($party_data))    
                @include("party.steps.step_3")
            @endif
        </div>
        <div id="step_4_content" style="display: none">
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
</script>

@endsection