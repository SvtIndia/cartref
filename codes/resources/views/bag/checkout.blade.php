@extends('layouts.website')


@section('meta-seo')
    <title>{{ Config::get('seo.checkout.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.checkout.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.checkout.description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
@livewire('bag.checkout')
@endsection