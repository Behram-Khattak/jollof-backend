@extends('layouts.master')

@section('title', config('app.name', 'Refer a friend'))

@push('styles')


@endpush

@section('content')

<main>
    <article>
        <div class="my-orders-wrapper">
            <div class="container mb-5">
                <h4 class="text-center mt-4">Refer a Friend</h4>
                <hr />

                @include('partials._flash')

                <div class="row">

                    <div class="container">
                        <div class="profile-div">

                            <form action="{{ route('send.refer.friend') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Firstname<sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" name="firstname" placeholder="John"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Lastname<sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" name="lastname" placeholder="Doe"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Email<sup class="text-danger">*</sup></label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="john@email.com" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-check d-flex justify-content-between">
                                    <input id="policy" name="policy" type="checkbox" class="form-check-input" required>
                                    <label for="remember" class="form-check-label"><sup class="text-danger">*</sup>By clicking here you accept our <a href="{{route('privacy_policy')}}">Privacy Policy</a></label>
                                </div>

                                <div class="text-danger font-weight-light mb-5 text-size-5">
                                    We take your privacy seriously, and your information is protected with
                                    us. Jollof.com will not use or share your data with third parties without your
                                    consent, and you will be rightly notified why and how the information will be
                                    used. By accepting the query below, you are consenting to the <a href="{{route('terms_and_conditions')}}">terms of use</a> and
                                    our <a href="{{route('privacy_policy')}}">Privacy Policy</a>. You have the right to withdraw consent at any time.
                                </div>

                                <button type="submit" class="btn btn-info btn-start">Send Invite to Friend</button>

                            </form>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </article>
</main>

@endsection
