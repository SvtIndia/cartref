@if (isset($collections2c))
    
    @if (count($collections2c) > 0)
        <section class="pt-2 mt-10">
            
            <h2 class="title title-center mb-4">
                {{ setting('2-column-collection.title') }}
            </h2>

            
            <div class="banner-desc-container">
                <p>{{ setting('2-column-collection.description') }}</p>
            </div>

            
            <div class="banner-group row cols-md-2 gutter-sm">
                @foreach ($collections2c as $key => $product)
                    <a href="{{ $product->url }}">
                        <div class="banner banner-fixed @if($key == 0) overlay-light @else overlay-dark @endif overlay-zoom appear-animate fadeIn appear-animation-visible" style="animation-duration: 1.2s;">
                            <figure>
                                <img src="{{ Voyager::image($product->image) }}" alt="{{ $product->name }}" style="background-color: rgb(37, 38, 39);" width="945" height="390">
                            </figure>
                            <div class="banner-content y-50">
                                <div class="appear-animate fadeInUpShorter appear-animation-visible" data-animation-options="{
                                    'name': 'fadeInUpShorter',
                                    'delay': '.{{ $key+2 }}s'
                                }" style="animation-duration: 1.2s;">
                                    <h4 class="banner-subtitle text-uppercase text-primary font-weight-bold">
                                        {{ $product->line_1 }}</h4>
                                    
                                    @if (!empty($product->line_2))
                                        <h3 class="banner-title text-white font-weight-bold mb-3">{{$product->line_2}}</h3>
                                    @endif
                                    @if (!empty($product->line_3))
                                        <p class="font-weight-semi-bold mb-6">{{ $product->line_3 }}</p>    
                                    @endif
                                    
                                    @if (!empty($product->button))
                                        <a href="{{ $product->url }}" class="btn btn-primary btn-rounded">{{ $product->button }}<i class="d-icon-arrow-right"></i></a>    
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

@endif