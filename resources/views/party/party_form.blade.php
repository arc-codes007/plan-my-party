@extends('layouts.app')
@section('content')

<div id="wrapper">
    @include("party.steps_menu")
      
    <section id="content-wrapper">
        @include("party.steps.step_1")
    </section>
</div>

@endsection