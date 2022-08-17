@component('mail::message')

Hi {{ $first_name }},

You were refered to join Jollof.com come by {{ $referer }}


<a href="{{ $code }}">Click here to get started on jollof.com</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
