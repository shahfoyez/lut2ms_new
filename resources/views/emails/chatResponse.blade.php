@component('mail::message')
@component('mail::panel')
    "{{$data['user_message']}}"
@endcomponent

# Response from LUT2MS
Dear {{$data['name']}},

Thank you for contacting us.
{{$data['message']}}

Use this token for further inquiry.
@include('vendor.mail.html.promotion')

<br>Thanks,<br>
{{ config('app.name') }}
@endcomponent
