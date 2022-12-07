@component('mail::message')
# Response from LUT2MS

Dear {{$data['name']}},

Thank you for contacting us.
{{$data['message']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
