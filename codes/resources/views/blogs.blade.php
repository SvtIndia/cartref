@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.blogs.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.blogs.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.blogs.description') }}">
@endsection

@section('content')
<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                <li><a href="{{ route('blogs') }}" class="active">Blogs</a></li>
                {{-- <li>Masonry 2 Columns</li> --}}
            </ul>
        </div>
    </nav>
    <div class="page-content pb-10 mb-10">
        <div class="container">
            <ul class="nav-filters filter-underline blog-filters justify-content-center" data-target=".posts">
                
                <li><a href="#" class="nav-filter active" data-filter="*">All</a><span>{{ count($blogs) }}</span></li>
                @foreach ($categories as $key => $category)
                    <li><a href="#" class="nav-filter" data-filter=".{{ $category->slug }}">{{ $category->name }}</a><span>{{ $category->posts->count() }}</span></li>
                @endforeach
            </ul>
            <div class="posts grid row" data-grid-options="{
                'layoutMode': 'fitRows'
            }" style="position: relative; height: 1903.8px;">
                
                @foreach ($blogs as $blog)
                    <div class="grid-item col-sm-4 {{ $blog->category->slug }}" style="position: absolute; left: 0%; top: 0px;">
                        <article class="post post-grid">
                            <figure class="post-media">
                                <a href="{{ route('blog', ['slug' => $blog->slug]) }}">
                                    <img src="{{ Voyager::image($blog->image) }}" alt="{{ $blog->title }}" width="580" height="400">
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    on <a href="#" class="post-date">{{ $blog->created_at->diffForHumans() }}</a>
                                    {{-- | <a href="#" class="post-comment"><span>2</span> Comments</a> --}}
                                </div>
                                <h4 class="post-title"><a href="{{ route('blog', ['slug' => $blog->slug]) }}">{{$blog->title}}</a>
                                </h4>
                                <p class="post-content">
                                   {{$blog->excerpt}}
                                </p>
                                <a href="{{ route('blog', ['slug' => $blog->slug]) }}" class="btn btn-link btn-underline btn-primary">Read
                                    more<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                @endforeach

            </div>
            <ul class="pagination mt-5 justify-content-center">
                {{ $blogs->links() }}
                {{-- <li class="page-item disabled">
                    <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                        <i class="d-icon-arrow-left"></i>Prev
                    </a>
                </li>
                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item">
                    <a class="page-link page-link-next" href="#" aria-label="Next">
                        Next<i class="d-icon-arrow-right"></i>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>

</main>
@endsection


@section('bottomscripts')
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope/isotope.pkgd.min.js') }}"></script>
@endsection