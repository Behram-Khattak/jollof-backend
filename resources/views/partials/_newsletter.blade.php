<div class="newsletter">
    <div class="container">
        <h4>Subscribe to our newsletter</h4>
        <hr>
        <form method="POST" action="{{ route('newsletter.post') }}">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="form-input">
                        <input type="text" class="form-control" name="user_name" placeholder="Your name" required>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-input">
                        <input type="email" class="form-control" name="user_email" placeholder="yourname@gmail.com" required>
                    </div>
                    @csrf
                </div>
                <div class="col-lg-4 col-md-4">
                    <button type="submit" class="btn btn-info btn-join">Subscribe</button>
                </div>
            </div>
        </form>
    </div>
</div>
