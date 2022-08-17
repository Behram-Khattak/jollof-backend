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
                <option value="{{ $category->id }}" data-id="{{ $category->id }}" >{{ $category->name }}</option>
            @endforeach

        </select>
    </div>
    <!-- small link to add category -->
    <div class="kt-portlet__head-toolbar">
        <a class="btn btn-primary" href="#" role="button" data-toggle="modal" data-target="#exampleModal"><i class="la la-plus"></i> Add New caegory</a>
    </div>
    <br>
</div>

<div class="col-md-4">

    <div class="form-group" id="subcat">
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
    <!-- small link to add sub category -->
    <div class="kt-portlet__head-toolbar" id="addsubcat">
        <a class="btn btn-primary" id="addsubcatlink" href="#" role="button" data-toggle="modal" data-target="#exampleModal2"><i class="la la-plus"></i> Add sub caegory</a>
    </div>
    <br>
</div>

<div class="col-md-4">

    <div class="form-group" id="subvar">

        <label for="variant">Subcategory Variant</label>

        <select id="variant" name="subvariant"
                class="custom-select"
                required
        >
            <option disabled value="" selected>Select Product
                Subcategory Variant
            </option>

        </select>

    </div>
    <!-- small link to add sub variant -->
    <div class="kt-portlet__head-toolbar" id="addsubvar">
        <a class="btn btn-primary" id="addsubcatlink" href="#" role="button" data-toggle="modal" data-target="#exampleModal3"><i class="la la-plus"></i> Add sub variant</a>
    </div>
    <br>

</div>


@csrf
