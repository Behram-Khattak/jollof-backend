@if ($message = session('success') )
<div class="alert alert-success alert-block container">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = session('error'))
<div class="alert alert-danger alert-block container">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif



{{--  @if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block container">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block container">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger container">
    <button type="button" class="close" data-dismiss="alert">×</button>
    Please check the form below for errors
</div>
@endif  --}}
