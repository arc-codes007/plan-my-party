@extends('layouts.app')
@section('content')

{{-- <div class="row">
    <div class="col-2 bg-danger px-0" style="overflow-y: hidden">
        @include("party.steps_menu")
    </div>
    <div class="col-10 mt-4">
        <div class="tabs" id="part_form_tabs">
            <div id="step_1" role="tabpanel">@include("party.steps.step_1")</div>
            <div id="step_2" role="tabpanel" style="display:none"></div>
            <div id="step_3" role="tabpanel" style="display:none"></div>
          </div>
    </div>
</div> --}}

<div id="wrapper">
    @include("party.steps_menu")
      
    <section id="content-wrapper">
        @include("party.steps.step_1")
    </section>
  
</div>

@endsection