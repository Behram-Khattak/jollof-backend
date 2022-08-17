<div class="cartItem">
    <ul class="list-unstyled">
        <li class="text-right"><button class="removeCart btn btn-link" data-id="{{ $item->id }}"><i class="fa fa-times text-danger"></i></button></li>
        <li class="font-weight-light">{{ $item->name }}</li>
        <li class="font-weight-bold">NGN {{ $item->price }}</li>
        <li class="linebr pt-3"><hr></li>
    </ul>
</div>