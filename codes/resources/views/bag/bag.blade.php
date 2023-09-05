@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.cart.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.cart.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.cart.description') }}">
@endsection

@section('content')
@livewire('bag.bag')
@endsection