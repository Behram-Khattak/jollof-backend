@component('mail::message')

## Hi {{ $recipient }}, {{ $message }}

{{ $message_line2 }}

The order details are shown below for your reference.

## OrderID: {{ $order_code }}


@foreach($items as $key => $item)

  - **Product:** {{ $item->name }}

  - **Description:** {{ $item->description }}

  - **Quantity:** {{ $item->quantity }}

  - **Unit Price:** NGN {{ number_format($item->unit_price, 2) }}

  - **Total Price:** NGN {{ number_format($item->total_price, 2) }}
  --------------------------------------------

@endforeach


- **Order Subtotal** -> {{ $subtotal }}

- **Order Total** -> {{ $total }}

## Details
**Email:** {{ $recipient_email }}

**Phone number:** {{ $recipient_phone }}

## Delivery Details
{{ $shipping->first_name }} {{  $shipping->last_name }}

{{ $shipping->address }}

{{ $shipping->city }} {{ $shipping->state }}

{{ $shipping->phone }}


--------------------------------------------------------------


From {{ $sender }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
