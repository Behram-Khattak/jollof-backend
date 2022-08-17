<div>

    @if($reviews->total() > 0)
    <div>
        @foreach ($reviews as $review)
        <div class="row mb-2">
            <div class="col-lg-8 col-md-8 col-sm-6">
                <p><strong>{{ $review->user->first_name .' '. $review->user->last_name }}</strong>, <small>{{ $review->created_at->format('d-M-Y') }}</small></p>
                <p class="not-bold mt--15">{{ $review->review }}</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="store-stars">
                    @for ($i = 1; $i <= 5; $i++)
                    <i

                        @if($i > $review->rating)

                        class="fa fa-star text-black-50"

                        @else

                        class="fa fa-star"

                        @endif
                    ></i>
                    @endfor
                </div>
            </div>
            <hr />
        </div>
        @endforeach
        
    </div>
    <div class="d-flex justify-content-center">
    {{$reviews->links() }}
    </div>
    @else

    <div class="py-5 text-center">
        <p>There are no reviews yet.</p>

    </div>

    @endif

   {{-- @auth
        @if(($hasreview->count() == 0))

            <h5>Enter your review for this restaurant</h5>
            <form method="post" action="{{ route('restaurant.review') }}">

                @csrf
                <input type="hidden" name="model_id" value="{{ $model_id }}" />
                <input type="hidden" name="model_type" value="{{ $model_type }}" />
                <div class="col-lg-12 col-md-12 px-0">
                    <div class="form-group">
                        <textarea class="form-control" name="review" rows="6"
                        placeholder="Enter your Review" required></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Rating</label>
                            <select class="form-control" name="rating" required>
                                <option value="5">Excellent</option>
                                <option value="4">Very Good</option>
                                <option value="3">Good</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info btn-join mt-30">Submit</button>
            </form>

        @endif
    @endauth --}}

</div>
