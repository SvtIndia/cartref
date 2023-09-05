@extends('layouts.website')

@section('meta-seo')

    <title>
        @if (request('category'))
            {{ ucwords(str_replace('-', ' ', request('category'))).' - ' }}
        @elseif(request('subcategory'))
        {{ ucwords(str_replace('-', ' ', request('subcategory'))).' - ' }}
        @endif

        {{ Config::get('seo.catalog.title') }}
    </title>

    <meta name="keywords" content="{{ Config::get('seo.catalog.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.catalog.description') }}">
@endsection


@section('content')
    @livewire('catalog.products')
@endsection
