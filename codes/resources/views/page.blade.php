@extends('layouts.website')

@section('meta-seo')
    <title>{{ $page->meta_title }}</title>
    <meta name="keywords" content="{{ $page->meta_keywords }}">
    <meta name="description" content="{{ $page->meta_description }}">
@endsection

@section('content')
<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                <li>{{ Str::limit($page->page_name, 50) }}</li>
            </ul>
        </div>
    </nav>
    <div class="page-content with-sidebar">
        <div class="container">
            <div class="row gutter-lg">
                <div class="col-lg-12">
                    <article class="post-single">
                        {{-- <figure class="post-media">
                            <a href="#">
                                <img src="{{ Voyager::image($slider->background_image) }}" alt="{{ $slider->title_1 }}">
                            </a>
                        </figure> --}}
                        <div class="post-details">
                            <h4 class="post-title"><a>{{ $page->title}}</a></h4>
                            <div class="post-body mb-7">
                                {!! $page->body !!}
                            </div>

                            <!-- End Author Detail -->
                            {{-- <div class="post-footer mt-7 mb-3">
                                <div class="post-tags">
                                    <a href="#" class="tag">{{ classic }}</a>
                                </div>
                                <div class="social-icons">
                                    <a href="#" class="social-icon social-facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="social-icon social-twitter" title="Twitter"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="social-icon social-pinterest" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                                </div>
                            </div> --}}
                        </div>
                    </article>
                    <nav class="page-nav">
                        @isset($previous)
                            <a class="pager-link pager-link-prev" href="{{ route('page.slug', ['slug' => $previous->slug]) }}">
                                Previous Page
                                <span class="pager-link-title">{{ $previous->page_name }}</span>
                            </a>
                        @else
                            <a class="pager-link pager-link-prev" @disabled(true)>
                                No Previous Page
                                {{-- <span class="pager-link-title">{{ $previous->title }}</span> --}}
                            </a>
                        @endisset
                        

                        @isset($next)
                            <a class="pager-link pager-link-next" href="{{ route('page.slug', ['slug' => $next->slug]) }}">
                                Go To Page
                                <span class="pager-link-title">{{ $next->page_name }}</span>
                            </a>
                        @else
                            <a class="pager-link pager-link-next" @disabled(true)>
                                No Next Page
                                {{-- <span class="pager-link-title">{{ $previous->title }}</span> --}}
                            </a>
                        @endisset

                        
                    </nav>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection


@section('bottomscripts')
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope/isotope.pkgd.min.js') }}"></script>
@endsection

