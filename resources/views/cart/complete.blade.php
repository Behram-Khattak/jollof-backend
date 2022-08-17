@extends('layouts.master')

@push('styles')
<style>
    .services-wrapper table {
        background: #FFF;
    }
</style>
@endpush

@section('title', 'menu items')

@section('content')

<main style="background: #f7f7f7;">
    <article>
        <div class="container">
            <div class="services-wrapper">
                <h3>Order Confirmation <a href="/"><button class="btn btn-success btn-lg float-right" type="submit">EXPLORE JOLLOF</button><br><br><br></a></h3>
                @include('partials._order_summary')

            </div>
        </div>
    </article>
</main>

@endsection
