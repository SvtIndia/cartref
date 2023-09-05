@if (isset($collections3c))

    @if (count($collections3c) > 0)
        <section>
            <div class="container pt-10 pb-6">
                
                <h2 class="title title-center mb-4">
                    {{ setting('3-column-collection.title') }}
                </h2>
    
                
                <div class="banner-desc-container">
                    <p>{{ setting('3-column-collection.description') }}</p>
                </div>

                
                <div class="banner-group row justify-content-center">
                    @foreach ($collections3c as $collection3c)
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <a href="{{ $collection3c->url }}">
                            <div class="banner banner-3 banner-fixed banner-radius content-middle">
                                <figure>
                                    <img src="{{ Voyager::image($collection3c->image) }}" alt="{{ $collection3c->line_1 }}" style="background-color: #ccc;" width="380" height="207">
                                </figure>
                                <div class="banner-content">
                                    <h3 class="banner-title text-white mb-1">{{ $collection3c->line_1 }}</h3>
                                    
                                    @if (!empty($collection3c->line_2))
                                        <h4 class="banner-subtitle text-uppercase font-weight-normal text-white">
                                            {{ $collection3c->line_2 }}
                                        </h4>                                    
                                    @endif
    
                                    @if (!empty($collection3c->line_3))
                                        <p class="text-light">{{ $collection3c->line_3 }}</p>    
                                    @endif
                                    
                                    @if (!empty($collection3c->button))
                                        <div class="banner-divider bg-white"></div>
                                        <a href="{{ $collection3c->url }}" class="btn btn-white btn-link btn-underline">{{ $collection3c->button }}<i class="d-icon-arrow-right"></i></a>    
                                    @endif
                                    
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                
            </div>
        </section>
    @endif
        
@endif