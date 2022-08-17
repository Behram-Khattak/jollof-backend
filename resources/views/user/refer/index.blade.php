@extends('layouts.master')

@section('title', config('app.name', 'Laravel'))

@push('styles')


@endpush

@section('content')

<main>
    <article>
        <div class="my-orders-wrapper">
            <div class="container mb-5">
                <h4 class="text-center mt-4">Referal Details</h4>
                <hr />

                @include('partials._flash')

                <div class="row justify-content-center">

                    <div class="col-md-8">
                        <p>Hi {{ auth()->user()->first_name }},</p>

                        <table class="table">
                            <tr>
                                <td>Total Referals sent</td>
                                <td>{{ count($totalReferals) }}</td>
                            </tr>

                            <tr>
                                <td>Total Referals signups</td>
                                <td>{{ count($totalSignups) }}</td>
                            </tr>
                        </table>


                    </div>
                </div>

                <div class="row justify-content-center">

                    <div class="col-md-8 text-center">
                        <p><a onclick="referafriend()" class="btn btn-primary btn-info">Send Referal to Friend</a></p>
                    </div>
                </div>
            </div>
        </div>
    </article>
</main>

@endsection
