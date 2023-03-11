@component('mail::message')
 
Hey there! You have been invited to a Party by {{$host_name}}
<br><br>
Please click below to open the invite :- <br>
@component('mail::button', ['url' => $invitation_link])
View Invitation
@endcomponent
<br>
Or paste this link in your browser to view invitation :- <br>
{{$invitation_link}} 
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent