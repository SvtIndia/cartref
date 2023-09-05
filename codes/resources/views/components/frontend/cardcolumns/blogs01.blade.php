@isset($blogs)

    @if (count($blogs) > 0)
        
    <section class="mt-10 pt-6">
        <div class="container">
            <h2 class="title title-center">From Our Blog</h2>
            <br>
            <div class="owl-carousel owl-theme owl-loaded owl-drag" data-owl-options="{
                'items': {{ count($blogs) }},
                'dots': true,
                'nav': false,
                'loop': false,
                'margin': 20,
                'autoPlay': true,
                'responsive': {
                    '0': {
                        'items': 1
                    },
                    '576': {
                        'items': 2
                    },
                    '992': {
                        'items': 3
                    },
                    '1200': {
                        'items': {{ count($blogs) }},
                        'dots': true
                    }
                }
            }">
                
                
                
                
        <div class="owl-stage-outer">
            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1460px;">
                
                @foreach ($blogs as $key => $blog)
                    <div class="owl-item active" style="width: 345px; margin-right: 20px;"><div class="post overlay-dark overlay-zoom appear-animate" data-animation-options="{
                            'name': 'fadeInRightShorter',
                            'delay': '.{{ $key }}+2s'
                        }">
                            <figure class="post-media">
                                <a href="{{ route('blog', ['slug' => $blog->slug]) }}">
                                    <img src="{{ Voyager::image($blog->image) }}" alt="{{ $blog->title }}" width="370" height="255">
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    on <a href="#" class="post-date">{{ $blog->created_at->diffForHumans() }}</a>
                                    {{-- | <a href="#" class="post-comment"><span>2</span> Comments</a> --}}
                                </div>
                                <h4 class="post-title"><a href="{{ route('blog', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a></h4>
                                <p class="post-content">{{ $blog->excerpt }}</p>
                                <a href="{{ route('blog', ['slug' => $blog->slug]) }}" class="btn btn-link btn-underline btn-primary btn-md">Read
                                    More<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        
        <div class="owl-nav disabled">
            <button type="button" title="presentation" class="owl-prev">
                <i class="d-icon-angle-left"></i>
            </button>
            <button type="button" title="presentation" class="owl-next">
                <i class="d-icon-angle-right"></i>
            </button>
        </div>
        <div class="owl-dots"></div></div>
        </div>
        </section>

    @endif

@endisset