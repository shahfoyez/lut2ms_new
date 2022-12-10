@component('mail::message')
@component('mail::panel')
    "{{$data['user_message']}}"
@endcomponent

# Response from LUT2MS
Dear {{$data['name']}},

Thank you for contacting us.
@if ($data['message'])
    {{$data['message']}}
@else
    The concerned team will contact you shortly.
@endif

Use this token for further inquiry.
@include('vendor.mail.html.promotion')

<br>Thanks,<br>
{{ config('app.name') }}
@endcomponent
