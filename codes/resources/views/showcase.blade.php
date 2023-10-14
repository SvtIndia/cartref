@extends('layouts.website')

@section('meta-seo')
    <title>Showroom At Home</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Riode - Ultimate eCommerce Template">
@endsection

@section('content')
<nav class="breadcrumb-nav">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
            <li>Showroom At Home</li>
        </ul>
    </div>
</nav>
<div class="page-header pl-4 pr-4">
    {{-- style="background-image: url(images/page-header/showcase-at-home.jpg)" --}}
    <h3 class="page-subtitle font-weight-bold">{{ setting('showcase-at-home.title_1') }}</h3>
    <h1 class="page-title font-weight-bold lh-1 text-white text-capitalize">{{ setting('showcase-at-home.title_2') }}</h1>
    <p class="page-desc text-white mb-0">{{setting('showcase-at-home.description')}}</p>
</div>
<div class="page-content mt-10 pt-10">

    @if (!empty(setting('showcase-at-home.body')))
        <div class="container">
            {!! setting('showcase-at-home.body') !!}
        </div>
    @endif


    <section class="about-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 mb-10 mb-lg-4">
                    {{-- <h5 class="section-subtitle lh-2 ls-md font-weight-normal">01. What We Do</h5> --}}
                    <h3 class="section-title lh-1 font-weight-bold">{{ setting('showcase-widget.title') }}
                    </h3>
                    <p class="section-desc">{{setting('showcase-widget.description')}}</p>
                </div>
                <div class="col-lg-8 ">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="counter text-center text-dark">
                                <span class="count-to" data-fromvalue="0" data-tovalue="{{ setting('showcase-widget.widget_1_count') }}" data-duration="900" data-delimiter=",">{{ setting('showcase-widget.widget_1_count') }}</span>
                                <h5 class="count-title font-weight-bold text-body ls-md">{{ setting('showcase-widget.widget_1_title') }}</h5>
                                <p class="text-grey mb-0">{{setting('showcase-widget.widget_1_description')}}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="counter text-center text-dark">
                                <span class="count-to" data-fromvalue="0" data-tovalue="{{ setting('showcase-widget.widget_2_count') }}" data-duration="900" data-delimiter=",">{{ setting('showcase-widget.widget_2_count') }}</span>
                                <h5 class="count-title font-weight-bold text-body ls-md">{{ setting('showcase-widget.widget_2_title') }}</h5>
                                <p class="text-grey mb-0">{{setting('showcase-widget.widget_2_description')}}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="counter text-center text-dark">
                                <span class="count-to" data-fromvalue="0" data-tovalue="{{ setting('showcase-widget.widget_3_count') }}" data-duration="900" data-delimiter=",">{{ setting('showcase-widget.widget_3_count') }}</span>
                                <h5 class="count-title font-weight-bold text-body ls-md">{{ setting('showcase-widget.widget_3_title') }}</h5>
                                <p class="text-grey mb-0">{{setting('showcase-widget.widget_3_description')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section-->

    @isset($components)
        @if (count($components) > 0)
            @foreach ($components as $key => $component)
                @if ($key % 2 == 0)


                    <section class="customer-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-7 mb-4">
                                    <figure>
                                        <img src="{{ Voyager::image($component->image) }}" alt="{{ $component->title_1 }}" class="banner-radius" style="background-color: #BDD0DE;" width="580" height="507">
                                    </figure>
                                </div>
                                <div class="col-md-5 mb-4">
                                    <h5 class="section-subtitle lh-2 ls-md font-weight-normal">{{ $component->title_1 }}</h5>
                                    <h3 class="section-title lh-1 font-weight-bold">{{ $component->title_2 }}</h3>
                                    <p class="section-desc text-grey">
                                        {{ $component->description }}
                                    </p>
                                    <a href="{{ $component->url }}" class="btn btn-dark btn-link btn-underline ls-m">{{ $component->button }}<i class="d-icon-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </section>


                @else


                    <section class="store-section pb-10 appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6 order-md-first mb-4">
                                    <h5 class="section-subtitle lh-2 ls-md font-weight-normal">{{ $component->title_1 }}</h5>
                                    <h3 class="section-title lh-1 font-weight-bold">{{ $component->title_2 }}</h3>
                                    <p class="section-desc text-grey">
                                        {{ $component->description }}
                                    </p>
                                    <a href="{{ $component->url }}" class="btn btn-dark btn-link btn-underline ls-m">{{ $component->button }}<i class="d-icon-arrow-right"></i></a>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <figure>
                                        <img src="{{ Voyager::image($component->image) }}" alt="{{ $component->title_1 }}" class="banner-radius" style="background-color: #DEE6E8;" width="580" height="507">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </section>

                @endif



            @endforeach
        @endif
    @endisset

</div>

@endsection
