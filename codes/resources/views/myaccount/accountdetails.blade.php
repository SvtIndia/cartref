@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.myaccount.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.myaccount.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.myaccount.description') }}">
@endsection

@section('content')
@livewire('myaccount.myaccount')
@endsection

