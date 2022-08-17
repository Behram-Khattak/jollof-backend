@push('styles')
<style>
.input-group > .form-control:not(:first-child){
        text-align: left;
        margin-top: 0px;
        background: #fff;
        border-radius: 0px;
}

@media screen and (max-width: 780px) {
    .searchbtn{
        margin-top: 10px;
    }
}

</style>
@endpush

<div class="row">
    <form action="{{ route('fashion.search') }}" method="POST" class="form-inline w-100">
        <div class="col-lg-9 col-md-9 input-group-col">
            <div class="input-group">
                <div class="input-group-prepend">
                    <select name="category" style="border: none;" class="form-control text-grey" >
                        <option selected value="0">All Categories</option>
                        @foreach ($categories as $category)

                        <option value="{{ $category->id }}">{{ $category->name }}</option>

                        @endforeach

                    </select>
                </div>
                <input type="text" name="fashion" class="form-control py-0"
                placeholder="Search Product">
            </div>
            @csrf
        </div>
        <div class="col-lg-3 col-md-3 searchbtn">
            <button type="submit" class="btn btn-info btn-join mt-0">search</button>
        </div>
    </form>
</div>
