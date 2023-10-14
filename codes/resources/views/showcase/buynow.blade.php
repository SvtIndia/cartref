@extends('layouts.website')

@section('meta-seo')
    <title>Showroom at home Bag</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Riode - Ultimate eCommerce Template">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@livewire('showcase.buynow')
@endsection
