@component('mail::message')
@component('mail::panel')
    "{{$data['user_message']}}"
@endcomponent

# Response from LUT2MS
Dear {{$data['name']}},

Thank you for contacting us.
{{$data['message']}}

@component('mail::promotion')
    <button title="Copy promo code" id="copy" onClick="CopyToClipboard('to-copy')">
@endcomponent

Use this token for further inquiry.
@component('mail::panel')
    {{$data['token']}}
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
