@component('mail::message')

Hi {{ $firstName }},

Thank you for ordering from Jollof.com. Your order has been place and details for delivery are below:

- **First Name:** {{ $firstName }}

- **Last Name:** {{ $lastName }}

- **Address:** {{ $address }}

You are not a registered customer, kindly use the details below to login and track or complete your order

- **Email:** {{ $email }}

- **Password:** {{ $password }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
