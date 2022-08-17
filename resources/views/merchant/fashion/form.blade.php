
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @csrf
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="product-image">Product Images</label>
            <div class="needsclick dropzone" id="product-image"></div>
            <span style="color:red"><i>Kindly upload your image in the following order: Front-View,Back-view,Side-view,Detailed-view, <b>Note:</b> You can only upload 4 images</i></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label for="product-name">Product Name</label>
                <input id="product-name" name="name"
                        type="text"
                        class="form-control"
                        value="{{ old('name', ($product) ? $product->name: '') }}"
                        placeholder="Enter Product Name"
                        required
                >

            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="product-description">
                    Product Description
                </label>
                <textarea id="product-description"  name="description"
                            class="form-control"
                            rows="5"
                            placeholder="Describe the product in more detail"
                            required
                >{{ old('description', ($product) ? $product->description: '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category_id"
                        class="custom-select"
                        required
                >
                    <option disabled value="" selected>Select Product
                        Category
                    </option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" data-id="{{ $category->id }}" {{ old('category_id', ($product && $product->category_id == $category->id) ? 'selected': '') }}>{{ $category->name }}</option>
                    @endforeach

                </select>
            </div>
        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label for="subcategory">Subcategory</label>

                <select id="subcategory"
                        name="subcategory"
                        class="custom-select"
                        required
                >
                    <option disabled value="" selected>Select Product
                        Subcategory
                    </option>
                </select>
            </div>

        </div>

        <div class="col-md-4">

            <div class="form-group">

                <label for="variant">Subcategory Variant</label>

                <select id="variant" name="variant"
                        class="custom-select"
                        required
                >
                    <option disabled value="" selected>Select Product
                        Subcategory Variant
                    </option>

                </select>

            </div>

        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label for="material">Material</label>
                <select id="material"
                        name="material_id"
                        class="custom-select"
                >
                    <option disabled value="" selected>
                        Select Product Material
                    </option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}" {{ old('material_id', ($product && $product->material_id == $material->id) ? 'selected': '') }}>{{ $material->name }}</option>
                    @endforeach

                </select>

            </div>

        </div>
        @php
            $col = 0;
        @endphp
        <div class="col-md-4">
            <div class="form-group">
                <label for="color">Color</label>
                <div class="input-group" id="color">
                    <input type="color" class="form-control color" id="{{$col}}" name="color[]" value="{{$colors[0] ?? '#00www0000'}}" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="{{count($colors ?? [])}}" onclick="addColor(event)" type="button" >+</button>
                    </div>
                    @if(isset($colors) && count($colors) > 0)
                        @for($i = 1; $i < count($colors); $i++)
                            <input type="color" class="form-control color {{$i}}" name="color[]" id="colo" value="{{$colors[$i]}}" aria-describedby="button-addon2">
                            <div class="input-group-append {{$i}}">
                                <button class="btn btn-outline-secondary {{$i}}" onclick="removeColor({{$i}})" type="button" id="button-addon2">-</button>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
            <div class="row">
                <!-- <div class="col-md-4"> -->
                    <!-- <div class="form-group">
                        <label for="color">Color 1</label>
                        <input type="color" class="form-control" name="color_1" value="{{ $product->color_id ?? ''}}">
                    </div> -->
                <!-- </div> -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="color">Color 2</label>
                        <input type="color" class="form-control" name="color_2" value="{{ $product->color_id ?? ''}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="color">Color 3</label>
                        <input type="color" class="form-control" name="color_3" value="{{ $product->color_id ?? ''}}">
                    </div>
                </div> -->
            </div>

        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label for="stock">Quantity in Stock</label>
                <input id="stock"
                        name="quantity"
                        class="form-control"
                        type="number"
                        min="0"
                        value="{{ old('quantity', ($product) ? $product->quantity: '') }}"
                />
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="price">Price</label>
                <input id="price"
                        name="price"
                        class="form-control"
                        type="number"
                        min="0"
                        value="{{ old('price', ($product) ? $product->price: '') }}"

                />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="sales-price">Discount Price</label>
                <input id="sales-price"
                        name="sales_price"
                        class="form-control"
                        type="number"
                        min="0"
                        value="{{ old('sales_price', ($product) ? $product->sales_price: '0') }}"
                />
            </div>
        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label for="size">Discount Schedule</label>
                <input name="discountSchedule" class="form-control daterange" />
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input id="weight"
                        name="weight"
                        class="form-control"
                        type="number"
                        min="0"
                        step="any"
                        value="{{ old('weight', ($product) ? $product->weight: '') }}"
                />
            </div>
        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label for="size-type">Product Size Type</label>
                <select id="size-type"
                        name="size_type_id"
                        class="custom-select"
                >
                    <option value="">
                        Select Product Size Type
                    </option>
                    @foreach ($sizeTypes as $sizeType)
                        <option value="{{ $sizeType->id }}" {{ old('size_type_id', ($product && $product->size_type_id == $sizeType->id) ? 'selected': '') }}>{{ $sizeType->name }}</option>
                    @endforeach

                </select>

            </div>

        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label for="size">Product Size</label>&nbsp;<small style="color:red">(Seperate with commas)</small>

                <input id="size"
                        name="size_value_id"
                        class="form-control"
                        type="text"
                        min="0"
                        value="{{old('size_value_id') ?? $sizes ?? ''}}"
                />
                {{-- <select id="size"
                        name="size_value_id"
                        class="custom-select"
                >
                    <option value="">
                        Select Product Size
                    </option>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}" {{ old('size_value_id', ($product && $product->size_value_id == $size->id) ? 'selected': '') }}>{{ $size->name }}</option>
                    @endforeach

                </select> --}}

            </div>

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="sales-price"><strong>Is item available for layaway?</strong></label>
                <select class="form-control" name="is_layaway">
                    <option value="0" {{ old('is_layaway', ($product && $product->is_layaway == 0) ? 'selected': '') }}>No</option>
                    <option value="1" {{ old('is_layaway', ($product && $product->is_layaway == 1) ? 'selected': '') }}>Yes</option>
                </select>
            </div>
        </div>


    </div>

    <div class="d-flex justify-content-end mt-3 mb-3">
        <button type="submit" class="btn btn-success">Submit
        </button>
    </div>

    <script>
        var newColor = 1;
        function addColor(event)
        {
            var next = eval(event.target.id + newColor);
            $( "#color" ).append( '<input type="color" name="color[]" value="#000000ss" class="form-control '+next+' color" aria-describedby="button-addon2"> ' );
            $( "#color" ).append( ' <div class="input-group-append '+next+'"> ' );
            $( "#color" ).append( ' <button class="btn btn-outline-secondary '+next+'" onclick="removeColor('+next+')" type="button" >-</button> ' );
            $( "#color" ).append( ' </div> ' );
            newColor++;
        }

        function removeColor(id)
        {
            console.log(id);
            $( "."+id ).remove();
            // $(event.target).parent().remove();
        }
    </script>
