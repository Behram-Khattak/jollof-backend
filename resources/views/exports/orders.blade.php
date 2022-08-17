 <div id="kt-datatable">
     <table class="table" id="" role="grid">
         <thead>
             <tr>
                 <th>S/N</th>
                 <th>Order Code</th>
                 <th>Order Time</th>
                 <th>Price * Quantity</th>
                 <th>Payment</th>
                 <th>Amount Paid</th>
                 <th>Delivery Status</th>
             </tr>
         </thead>
         <tbody>
             @foreach($orders as $item)
             <tr>
                 <td>{{ $loop->iteration }}</td>
                 <td>
                     <a href="{{ route('merchant.restaurant.order.details', [request()->route('business'), 'code'=>$item->order->order_code]) }}">{{ $item->order->order_code }}</a>
                     <p>
                         @if ($item->preorder)
                         <span class="badge border border-primary bg-white text-primary">{{ 'Pre-Order' }}</span><br />
                         @else
                         <span class="badge border border-danger bg-white text-danger">{{'Ordered Now' }}</span><br>
                         {{ $item->created_at}}
                         @endif
                     </p>
                 </td>
                 <td>
                     @if ($item->preorder)
                     <span class="badge bg-white border border-primary">{{ date('d-M-Y, h:i a', strtotime($item->delivery_on)) }}</span>
                     @else
                     {{'-' }}
                     @endif
                 </td>
                 <td>
                     {{ $item->name }} <br />
                     {{ $item->unit_price }} * {{ $item->quantity }} <br> <strong>NGN {{ $item->total_price }}</strong>
                 </td>
                 <td>
                     @if ($item->paid_on)
                     <span>{{ 'Paid' }}</span>
                     @else
                     <span>{{ 'Not Paid' }}</span>
                     @endif
                 </td>
                 <td>
                     @if(!is_null($item->paid_on))
                     {{$item->order->total}}
                     @else
                     0
                     @endif
                 </td>
                 <td>

                     <small>{{$item->status}}</small>
                 </td>
             </tr>

             @endforeach
         </tbody>

     </table>
 </div>
