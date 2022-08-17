<!-- <div class="row">
    <div class="col-12 mt-5 pt-5">

        <hr />

    </div>
</div> -->

<div class="row">
    <div class="col-12 text-center">
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
</div>