@extends('layouts.website')

@section('meta-seo')
    <title>
        @if (request('category'))
            {{ ucwords(str_replace('-', ' ', request('category'))) . ' - ' }}
        @elseif(request('subcategory'))
            {{ ucwords(str_replace('-', ' ', request('subcategory'))) . ' - ' }}
        @endif

        {{ Config::get('seo.catalog.title') }}
    </title>

    <meta name="keywords" content="{{ Config::get('seo.catalog.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.catalog.description') }}">

@endsection


@section('content')
    @livewire('catalog.products')
@endsection

@push('scripts')
    <script type="text/javascript">
        let action = 'inactive';

        window.addEventListener('makeInactive', (e) => {
            $('#loader').hide();
            action = 'inactive';
            window.scrollBy(0, 5);
        });

        window.addEventListener('reachedMaxLimit', (e) => {
            $('#loader').hide();
            action = 'reached-max-limit';
            window.scrollBy(0, 5);
        });

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() > $(".product-wrapper").height() && action == 'inactive') {
                action = 'active';
                $('#loader').show();
                window.livewire.emit('load-more');
            }
        });
    </script>
@endpush
