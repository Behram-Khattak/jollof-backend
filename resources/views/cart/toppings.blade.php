<div id="menu-toppings">

        <div class="row">

            <div class="col-lg-1 col-md-12">
                <input type="checkbox" value='1' checked name='addmainmenu'>
            </div>
            <div class="col-lg-7 col-md-12">
                <div class="d-flex">
                    <div class="img-wrapper rounded-lg">
                        <img src="{{ $menu->getFirstMediaUrl('menu') }}" class="img-fluid" alt="">
                        <!-- <a class="addToppings" data-id="{{ $menu->id }}" data-microsite="cuisine" style="cursor:pointer;">
                        </a> -->
                    </div>
                    <div class="event-details px-3">
                        <h6 class="mb-0">{{ $menu->menu }}</h6>
                        <p class="text-muted"><small>{{ $menu->description }}</small></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="d-flex margin-top-20 pull-right">
                    <p class="price ml-2">
                        @if($menu->type == "PROMO")
                            ₦{!! calculateMenuPrice($menu->price, $menu->sales_price, $menu->sales_start, $menu->sales_end) !!}</p>
                        @else
                        {{ number_format($menu->price, 2) }}
                        @endif
                </div>
            </div>
        </div>

        @if($menu->preorder)
        <link rel="stylesheet" href="{{ asset('datetimepicker/jquery.datetimepicker.min.css') }}">
        <div class="row">
            @if(!restaurantOpen($restaurant->hours) || $menu->in_stock == false)
            <div class="col-lg-12 col-md-12">
                <input type="checkbox" id="checkboxx" value='1' checked onchange='this.checked = true;' name='preorder'> <label><strong>Pre-Order Available.</strong> Would you like to place a preorder?</label>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="form-group preorderbox">
                    <label for="example-readonly">Pre Order Date</label>
                    <div class="input-group" style="position:relative;">
                        <input size="16" id="datetime" class="form-control" name="delivery_on" readonly type="text" placeholder="Delivery Date and Time">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            @else
            <div class="col-lg-12 col-md-12">
                    <input type="checkbox" value='1' name='preorder'> <label><strong>Pre-Order Available.</strong> Would you like to place a preorder?</label>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="form-group preorderbox" style="display: none;">
                    <label for="example-readonly">Pre Order Date</label>
                    <div class="input-group" style="position:relative;">
                        <input size="16" id="datetime" class="form-control" name="delivery_on" readonly type="text" placeholder="Delivery Date and Time">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- <script src="{{asset('datetimepicker/jquery.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
        <script src="{{asset('datetimepicker/jquery.datetimepicker.full.js')}}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            var checkPastTime = function(inputDateTime) {
            if (typeof(inputDateTime) != "undefined" && inputDateTime !== null) {
                var current = new Date();

                //check past year and month
                if (inputDateTime.getFullYear() < current.getFullYear()) {
                    $('#datetimepicker7').datetimepicker('reset');
                    alert("Sorry! Past date time not allow.");
                } else if ((inputDateTime.getFullYear() == current.getFullYear()) && (inputDateTime.getMonth() < current.getMonth())) {
                    $('#datetimepicker7').datetimepicker('reset');
                    alert("Sorry! Past date time not allow.");
                }

                // 'this' is jquery object datetimepicker
                // check input date equal to todate date
                if (inputDateTime.getDate() == current.getDate()) {
                    if (inputDateTime.getHours() < current.getHours()) {
                        $('#datetimepicker7').datetimepicker('reset');
                    }
                    this.setOptions({
                        minTime: current.getHours() + ':00' //here pass current time hour
                    });
                } else {
                    this.setOptions({
                        minTime: false
                    });
                }
                    }
                    };
                    var currentYear = new Date();
                    $('#datetime').datetimepicker({
                        format:'Y-m-d H:i',
                        minDate : 0,
                        yearStart : currentYear.getFullYear(), // Start value for current Year selector
                        onChangeDateTime:checkPastTime,
                        onShow:checkPastTime
                    });
        </script>
        @else
            <input type="hidden" name="delivery_on" value="null">
            <input type="hidden" name="preorder" value="0">
        @endif

    @if(empty($toppings))
        <div> No Toppings to add. Just add Item to Cart</div>
    @else
        <div class="row">
            <div class="col-md-12">
                <h5 class="modal-title mt-3 pb-3 border-bottom">Extras</h5>
            </div>
        </div>
        @foreach ($toppings as $extra)

            <div class="row">
                <div class="col-md-12">
                    <h6 class="modal-title py-2">{{ (isset($extra["title"])) ? $extra["title"] : "" }}</h6>
                </div>
            </div>
            @foreach($extra["items"] as $item )
            <div class="row mb-15">
                <div class="col-md-12">
                    <div class="extras-detail-att">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <input type="checkbox" class="topping" value='{{ (isset($item["price"])) ? $item["price"] : "" }}' name='{{ (isset($item["name"])) ? $item["name"] : "" }}'>
                                <label for="">
                                    <span class="extra-title">{{ (isset($item["name"])) ? $item["name"] : "" }}</span>
                                </label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-light px-2 p-0 minus-btn" data-price="{{ $item['price'] }}"><i class="fa fa-minus"></i></button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm rounded-0 p-2 mt-0 qty_input bg-light border-0" readonly value="1" min="1">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-light px-2 py-0 plus-btn" data-price="{{ $item['price'] }}"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                                <span class="extra-price">₦</span><span class="extra-price price">{{ (isset($item["price"])) ? $item["price"] : "" }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endforeach
    @endif


</div>
