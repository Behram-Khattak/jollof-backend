@component('mail::message')

# Restaurant Booking Details

Hi Team,

You have a table booking.

@component('mail::table')
| Field         | Value              |
| ------------- |:------------------:|
| First Name    | {{ $first_name }}  | 
| Last Name     | {{ $last_name }}   |
| Phone         | {{ $phone }}       | 
| Email         | {{ $email }}       |
| Guest         | {{ $guest }}       | 
| Date          | {{ $date }}        |
| Time          | {{ $time  }}       | 
| Instructions  | {{ $instructions }}|
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
