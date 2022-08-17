@component('mail::message')

Hi Team,

You have received a message via Jollof.com contact form

- **First Name:** {{ $first_name }}

- **Last Name:** {{ $last_name }}

- **Email:** {{ $email }}

- **Address:** {{ $address }}

- **Message:** {{ $message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent