@component('mail::message')
 
@if (isset($package_name))
    Hello! There is a booking request for {{$pacakge_name}} package at your place.
@else
    Hello! There is a booking request for a Custom Party at your place.
@endif
<br>
Client Details : -
<br>
Name - {{$name}} <br>
Email - {{$email}} <br>
Phone - {{$phone}} <br>
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent