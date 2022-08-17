@extends('layouts.master')

@section('title', 'Contact - Jollof')

@push('styles')
    <style>
        <blade media|%20screen%20and%20(max-width%3A%20768px)%20%7B>.logo-wrapper .navbar-collapse {
            margin: 0px 15px;
        }
        }

    </style>
@endpush

@section('content')

<main>
    <article>
        <div class="my-orders-wrapper">
            <div class="container mb-5">
                <h4 class="text-center mt-4">Contact</h4>
                <hr />

                @include('partials._flash')

                <div class="row">

                    <div class="container">
                        <div class="profile-div">
                            <h4>Personal Data</h4>
                            <form action="{{ route('contact') }}" method="POST">
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
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Email<sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" name="email"
                                                placeholder="john@email.com" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Address<sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="12 Range Street" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Message</label>
                                    <textarea class="form-control rounded" name="message" rows=5 placeholder="Message"></textarea>
                                </div>

                                <div class="form-group form-check d-flex justify-content-between">
                                    <input id="policy" name="policy" type="checkbox" class="form-check-input" required>
                                    <label for="remember" class="form-check-label"><sup class="text-danger">*</sup>by clicking here you accept our <a href="{{route('privacy_policy')}}">Privacy Policy</a></label>
                                </div>

                                <div class="text-danger font-weight-light mb-5 text-size-5">
                                    We take your privacy seriously, and your information is protected with
                                    us. Jollof.com will not use or share your data with third parties without your
                                    consent, and you will be rightly notified why and how the information will be
                                    used. By accepting the query below, you are consenting to the <a href="{{route('terms_and_conditions')}}">terms of use</a> and
                                    our <a href="{{route('privacy_policy')}}">Privacy Policy</a>. You have the right to withdraw consent at any time.
                                </div>


                                <span class="text-muted"><sup class="text-danger">*</sup> required field</span>
                                <button type="submit" class="btn btn-info btn-start">Contact Us</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <!-- Settings End -->
</main>

@endsection
