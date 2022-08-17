@extends('layouts.master')

@section('title', 'Profile Settings')

@section('content')
<main>
    <article>
        <div class="my-orders-wrapper mb-5">
            <div class="container">

                <!-- <br /> -->
                    @include('partials._flash')
                <!-- <br /> -->

                <div class="">
                    <!-- <h4>My Account</h4> -->
                    <!-- @include('user.partials._myAccount') -->
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h6 class="text-uppercase">my profile</h6>
                    </div>

                    <div class="container" id="profile">

                        <div class="profile-div">
                            <form action="{{ route('user.settings.update.profile') }}" method="POST">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">First Name</label>
                                            <input type="text" class="form-control" value="{{ $user->first_name }}" name="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Last Name</label>
                                            <input type="text" class="form-control" value="{{ $user->last_name }}" name="last_name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input type="text" class="form-control" value="{{ $user->username }}" name="username" required readonly>
                                            @csrf
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" class="form-control" value="{{ $user->email }}" name="email" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Phone Number</label>
                                            <input type="text" class="form-control readonly" value="{{ $user->telephone }}" name="telephone" disabled required>
                                        </div>
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-info btn-start">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-12 mt-5 pt-5">

                        <hr />

                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6 class="text-uppercase">change password</h6>
                    </div>

                    <div class="container" id="profile">

                        <div class="profile-div">
                            <form action="{{ route('user.settings.update.password') }}" method="POST">

                                <div class="alert alert-warning alert-block">

                                    <strong>You will be automatically logged out when your password is changed successfully.</strong>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Current Password</label>
                                            <input type="password" class="form-control" name="current_password" required>
                                            @csrf
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">New Password</label>
                                            <input type="password" class="form-control" name="new_password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Confirm New Password</label>
                                            <input type="password" class="form-control" name="verify_password" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info btn-start">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </article>
</main>
<div id="state-data" style="display: none;">{{ json_encode(locations_json()) }}</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $("body").on("change", ".states", function(){
            var state = $(this).val();
            var data = JSON.parse($("#state-data").html());
            var areas = data[state];
            var options = $(this).parents(".shippingAddress").find(".userCity");
            $.each(areas, function(index, value) {
                options.append("<option value='"+ index +"'>" + value + "</option>");
            });
        });
    });

</script>


@endpush
