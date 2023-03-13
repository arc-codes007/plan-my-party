@component('mail::message')
 
Hey there! We hope you enjoyed the Party hosted by {{$host_name}}.
<br>
Please give us your valuable time to post a review about your exprience.
<br><br>
Please click below :- <br>
@component('mail::button', ['url' => $invitation_link])
Post Review
@endcomponent
<br>
Or paste this link in your browser to post review :- <br>
{{$invitation_link}} 
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent