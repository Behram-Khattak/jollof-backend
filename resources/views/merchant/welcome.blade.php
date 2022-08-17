@extends('merchant.layouts.master')

@section('title', 'Welcome to Jollof'))

@section('content')

    <!-- begin:: Content -->
    <merchant-onboard-component
        route="{{ route('merchant.business.setup', $business) }}"
        redirect="{{ route('merchant.index') }}"
    />
    <!-- end:: Content -->

@endsection
