@props(['type' => 'info', 'message'])

<div {{ $attributes->merge(['class' => 'alert-dismissible fade show alert alert-'.$type]) }}>
    {!! $message !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
