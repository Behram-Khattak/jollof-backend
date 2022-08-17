<div class="form-group">
    <label for="example-readonly">Menu Type</label>
    <select name="type" class="form-control">
        <option value="REGULAR">REGULAR</option>
        <option value="PROMO">PROMO</option>
    </select>
    @error("category") <small style="color: red;"> {{ $message }} </small> @enderror
</div>
<div class="form-group">
    <label for="example-readonly">Cuisine Category </label>
    <span class="pull-right"><a class="" href="#" role="button" data-toggle="modal" data-target=".category_form" data-action="/merchant/restaurant/create_category">New Cuisine Category</a></span>
    <select name="category" class="form-control">
        <option value="">Select Cuisine Category</option>
        @foreach ($category as $c)
        <option value="{{ $c->id }}" {{ !$menus->cuisine_category_id ? '' : ($menus->cuisine_category_id  == $c->id ? 'selected' : '')  }}>{{ $c->name }}</option>
        @endforeach
    </select>
    @error("category") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Menu Item</label>
    <input name="menu" type="text" class="form-control" value="{{ $menus->menu ? old('menu', $menus->menu) : '' }}" placeholder="Menu Name">
    @error("menu") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Estimated Menu Delivery duration</label>
    <select name="delivery_time" class="form-control">
        <option value="15" {{ $menus->delivery_time && $menus->delivery_time == 15 ? 'selected' : '' }}>15 mins</option>
        <option value="30" {{ $menus->delivery_time && $menus->delivery_time == 30 ? 'selected' : '' }}>30 mins</option>
        <option value="45" {{ $menus->delivery_time && $menus->delivery_time == 45 ? 'selected' : '' }}>45 mins</option>
        <option value="60" {{ $menus->delivery_time && $menus->delivery_time == 60 ? 'selected' : '' }}>60 mins</option>
        <option value="120" {{ $menus->delivery_time && $menus->delivery_time == 120 ? 'selected' : '' }}>120 mins</option>
        <option value="150" {{ $menus->delivery_time && $menus->delivery_time == 150 ? 'selected' : '' }}>150 mins</option>
    </select>
    @error("menu") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Description</label>
    <textarea name="description" class="form-control" placeholder="Menu Decription">{{ $menus->description ? old('description', $menus->description) : '' }}</textarea>
    @error("menu") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label>Picture of Menu</label>
    <input type="file" name="picture" class="form-control">
</div>

<div class="form-group row">
    <div class="col-md-6">
        <label for="example-readonly">Regular Price</label>
        <input type="number" name="price" class="form-control" value="{{ $menus->price ? old('menu', $menus->price) : '' }}" placeholder="Regular Price">
        @error("price") <small style="color: red;"> {{ $message }} </small> @enderror
    </div>
    <div class="col-md-6">
        <label for="example-readonly">Discount Price</label>
        <input type="number" name="sales_price" class="form-control" value="{{ $menus->sales_price ? old('menu', $menus->sales_price) : '' }}" placeholder="Sales Price">
        @error("sales_price") <small style="color: red;"> {{ $message }} </small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="example-readonly">Sales Schedule</label>
    <input type="text" name="schedule" class="form-control daterange" value="" placeholder="Schedule of Sales ">
    @error("schedule") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Menu Location</label>
    @foreach ($locations as $location)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" name="locations[]">
        <label class="form-check-label px-3" for="defaultCheck1">
            {{ $location->address }},<br>
            {{ $location->city }} {{ $location->area }}, {{ $location->state }}
        </label>
    </div>
    @endforeach
    @error("locations") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Menu is Available</label>
    <select name="in_stock" class="form-control">
        <option value="1">Yes, menu is available</option>
        <option value="0">No, menu is not available</option>
    </select>
    @error("in_stock") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="form-group">
    <label for="example-readonly">Menu Pre-order</label>
    <select name="preorder" class="form-control">
        <option value="1">Yes, menu can be pre-ordered</option>
        <option value="0">No, menu cannot be pre-ordered</option>
    </select>
    @error("preorder") <small style="color: red;"> {{ $message }} </small> @enderror
</div>

<div class="extras" id="extrasMain">
    <h3>Extras</h3>
    @if(isset($toppings) && count($toppings) > 0)
    <!-- foreach toppings display title -->
    @foreach ($toppings as $topping)
    <div id="topping-{{$loop->iteration}}">
        <div class="slidex border rounded shadow-sm p-3 mt-4">
            <div class="text-right">
                <button onclick="removeMainTopping('{{$loop->iteration}}');" type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> Remove this extra group</button>
            </div>
            <div class="form-group">
                <label for="example-readonly">Extra Group Name</label>
                <input type="text" name="Old_toppings[{{$loop->iteration }}][title]" class="form-control thetitle" value="{{$topping['title']}}" placeholder="Title">
                @error("title") <small style="color: red;"> {{ $message }} </small> @enderror
            </div>
            <div class="inner-repeater">
                <div>
                    <div class="form-group extraitem" id="extraitems-{{$loop->iteration}}">
                        <?php
                        $last = 0;
                        $parent = $loop->iteration;
                        ?>
                        @foreach($topping['items'] as $item)
                        <div class="row" id="extraitem-{{$loop->iteration}}">
                            <div class="col-md-5">
                                <label for="example-readonly">Name</label>
                                <input type="text" name="Old_toppings[{{$loop->parent->iteration}}][items][{{$loop->iteration}}][name]" class="form-control thename" value="{{$item['name']}}" placeholder="Name" required>
                                @error("name") <small style="color: red;"> {{ $message }} </small> @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="example-readonly">Price</label>
                                <input type="number" name="Old_toppings[{{$loop->parent->iteration}}][items][{{$loop->iteration}}][price]" class="form-control theprice" value="{{$item['price']}}" placeholder="Price" required>
                                @error("price") <small style="color: red;"> {{ $message }} </small> @enderror
                            </div>
                            <div class="col-md-2">
                                <br>
                                <button onclick="removeTopping('{{$loop->parent->iteration}}', '{{$loop->iteration}}')" type="button" class="btn btn-outline-danger btn-sm mt-2"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        @if($loop->last)
                        <?php
                        $last = $loop->last
                        ?>
                        @endif
                        @endforeach
                    </div>
                    <!-- @foreach ($topping['items'] as $key => $item)
                                @endforeach -->
                    <div class="text-center mb-4">
                        <button type="button" onClick="AddExtraGroupItem('{{$parent}}','{{$loop->iteration}}', '{{$last}}')" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i> Add Extra Group Item</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
            @endforeach
            @endif
</div>
    <div data-repeater-list="toppings">
        <div data-repeater-item>
            <div class="slidex border rounded shadow-sm p-3 mt-4">
                <div class="text-right">
                    <button data-repeater-delete type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> Remove this extra group</button>
                </div>
                <div class="form-group">
                    <label for="example-readonly">Extra Group Name</label>
                    <input type="text" name="title" class="form-control thetitle" placeholder="Title">
                    @error("title") <small style="color: red;"> {{ $message }} </small> @enderror
                </div>
                <div class="inner-repeater">
                    <div data-repeater-list="items">
                        <div class="text-center mb-4">
                            <button data-repeater-create type="button" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i> Add Extra Group Item</button>
                        </div>
                        <div data-repeater-item>
                            <div class="form-group row extraitem">
                                <div class="col-sm-5">
                                    <label for="example-readonly">Name</label>
                                    <input type="text" name="name" class="form-control thename" placeholder="Name" required>
                                    @error("name") <small style="color: red;"> {{ $message }} </small> @enderror
                                </div>
                                <div class="col-sm-5">
                                    <label for="example-readonly">Price</label>
                                    <input type="number" name="price" class="form-control theprice" placeholder="Price" required>
                                    @error("price") <small style="color: red;"> {{ $message }} </small> @enderror
                                </div>
                                <div class="col-sm-2">
                                    <br>
                                    <button type="button" class="btn btn-outline-danger btn-sm mt-2" data-repeater-delete><i class="fa fa-times"></i></button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function removeTopping(i, j) {
            $('#extraitems-' + i + ' #extraitem-' + j).remove();
        }

        function removeMainTopping(i) {
            $('#topping-' + i).remove();
        }

        function AddExtraGroupItem(p, i, j) {
            // get total children in extraitems div
            var total = $('#extraitems-' + i).children().length;
            var form = '<br> <div class="row" id="extraitem-' + i + '">'
            form += '<div class="col-md-5">';
            form += '<label for="example-readonly">Name</label>';
            form += `<input type="text" name="Old_toppings[${p}][items][${eval(total + 1)}][name]" class="form-control thename" placeholder="Name" required>`;
            form += '@error("name") <small style="color: red;"> {{ $message }} </small> @enderror';
            form += '</div>';
            form += '<div class="col-sm-5">';
            form += '<label for="example-readonly">Price</label>';
            form += `<input type="number" name="Old_toppings[${p}][items][${eval(total + 1)}][price]" class="form-control theprice" placeholder="Price" required>`;
            form += '@error("price") <small style="color: red;"> {{ $message }} </small> @enderror';
            form += '</div>';
            form += '<div class="col-sm-2">';
            form += '<br>';
            form += '<button onclick="removeTopping(' + i + ',' + eval(j + 1) + ')" type="button" class="btn btn-outline-danger btn-sm mt-2"><i class="fa fa-times"></i></button>';
            form += '</div>';
            form += '</div>';
            // console.log(form)
            $('#extraitems-' + i).append(form);

        }

        function AddExtra() {
            console.log('add exsstra');
            var form = '<br> <div class="row" id="extraitem-' + i + '">'
            form += '<div class="col-md-5">';
            form += '<label for="example-readonly">Name</label>';
            form += `<input type="text" name="Old_toppings[${p}][items][${eval(total + 1)}][name]" class="form-control thename" placeholder="Name" required>`;
            form += '@error("name") <small style="color: red;"> {{ $message }} </small> @enderror';
            form += '</div>';
            form += '<div class="col-sm-5">';
            form += '<label for="example-readonly">Price</label>';
            form += `<input type="number" name="Old_toppings[${p}][items][${eval(total + 1)}][price]" class="form-control theprice" placeholder="Price" required>`;
            form += '@error("price") <small style="color: red;"> {{ $message }} </small> @enderror';
            form += '</div>';
            form += '<div class="col-sm-2">';
            form += '<br>';
            form += '<button onclick="removeTopping(' + i + ',' + eval(j + 1) + ')" type="button" class="btn btn-outline-danger btn-sm mt-2"><i class="fa fa-times"></i></button>';
            form += '</div>';
            form += '</div>';
            // append to the end of the div
            $('#extrasMain').append(form);
        }
    </script>
