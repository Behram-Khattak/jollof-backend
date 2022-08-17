@component('mail::message')

Hi {{ $first_name }},

You have received a message via Jollof.com contact form

{{ $message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
