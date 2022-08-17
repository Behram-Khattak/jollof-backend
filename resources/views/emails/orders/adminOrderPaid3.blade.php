@extends('emails.layout')

@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnCaptionRightContentOuter" width="100%">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Details</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item)
                        <tr>
                            <td valign="top" class="mcnCaptionRightContentInner" width="25%" style="padding:0 9px 9px 9px ;">
                                <a href="https://testing.jollof.com/fashion/wears/jackets" title="" class="" target="_blank">
                                    <img alt="" src="{{ $item->img }}"
                                                        width="176" style="max-width:1080px;" class="mcnImage">
                                </a>
                            </td>
                            <td valign="top" class="mcnCaptionRightContentInner" width="45%" style="padding:0 9px 9px 9px ;">
                                <h4>{{ $item->name }}</h4>
                                <p>{{ $item->description }}</p>
                            </td>
                            <td valign="top" class="mcnCaptionRightContentInner" width="15%" style="padding:0 9px 9px 9px ;">
                                {{ $item->quantity }}
                            </td>
                            <td valign="top" class="mcnCaptionRightContentInner" width="15%" style="padding:0 9px 9px 9px ;">
                                {{ number_format($item->total_price, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>




            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="min-width: 100%;border-top: 2px solid #EAEAEA;">
                    <tbody>
                        <tr>
                            <td>
                                <span></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!--
                <td class="mcnDividerBlockInner" style="padding: 18px;">
                <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
-->
            </td>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->

                <!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;"
                    width="100%" class="mcnTextContentContainer">
                    <tbody>
                        <tr>

                            <td valign="top" class="mcnTextContent"
                                style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                <p>
                                    <strong>Order Subtotal:</strong> {{ $subtotal }}<br/>
                                    <strong>Order Total: </strong> {{ $total }}
                                </p>

                                <h4>Details</h4>
                                <p>
                                    <strong>Email:</strong> {{ $recipient_email }}<br/>
                                    <strong>Phone number:</strong> {{ $recipient_phone }}<br/>
                                </p>

                                <h4>Delivery Details</h4>
                                <p>
                                    {{ $shipping->first_name }} {{ $shipping->last_name }}<br/>
                                    {{ $shipping->address }}<br/>
                                    {{ $shipping->city }} {{ $shipping->state }}<br/>
                                    {{ $shipping->phone }}
                                </p>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <!--[if mso]>
				</td>
				<![endif]-->

                <!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table>

@endsection





{{--  @component('mail::message')

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
{{ $shipping->first_name }} {{ $shipping->last_name }}

{{ $shipping->address }}

{{ $shipping->city }} {{ $shipping->state }}

{{ $shipping->phone }}


--------------------------------------------------------------


From {{ $sender }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent--}}
