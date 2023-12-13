@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.welcome.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.welcome.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.welcome.description') }}">
@endsection

@section('content')
    @include('components.frontend.introsliders.01')

    <section id="statistics">
        <div class="container" style="padding:0.5em 1em !important;">
            <div class="stats owl-carousel">

                <div class="stat">
                    <div class="icon">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="info">
                        3+ Cities
                    </div>
                </div>


                <div class="stat">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="info">
                        10k+ Happy Customers
                    </div>
                </div>

                <div class="stat">
                    <div class="icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="info">
                        150+ Showroom at Home
                    </div>
                </div>

                <div class="stat">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="info">
                        300+ Sellers
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('components.frontend.cardcarousels.recentlyviewed')

    @include('components/frontend/collections/dynamiccollections')

    @include('components/frontend/collections/3column')

    @include('components/frontend/collections/2columnfreerows')

    @include('components/frontend/collections/3columnfreerows')

    @include('components/frontend/collections/5columnfreerows')

    {{-- @include('components.frontend.cardcarousels.flashsale') --}}

    @include('components/frontend/collections/2column')

    @include('components.frontend.cardcarousels.trending')

    @include('components.frontend.cardcolumns.blogs01')
@endsection



@section('bottomscripts')

    <script>
        $(document).ready(function () {
            $('.stats.owl-carousel').owlCarousel({
                items: 1,
                margin: 10,
                loop: true,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 2000,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 4
                    }
                }
            });
        });
    </script>

    @guest
        @if(!Session::get('showcasecity'))
            <script>
                $(document).ready(function () {
                    document.getElementById('showroom_popup').style.display = 'block'
                });
            </script>
        @endif
    @endguest
@endsection
