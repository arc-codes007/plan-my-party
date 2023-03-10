@extends('layouts.app')
@section('content')

<div id="wrapper">
    @include("party.steps_menu")
      
    <section id="content-wrapper">
        <div id="step_1_search_content" {{(empty($party_data)) ? '' : 'style="display:none"'}}>
            @if (empty($party_data))
                @include("party.steps.step_1")            
            @endif
        </div>
        <div id="step_2_planning_content">
            @include("party.steps.step_2")            
        </div>
    </section>
</div>

@endsection