<div>
    @if ($this->display == true)
    <div class="mfp-bg mfp-product mfp-fade mfp-ready quickview" wire:click="displayfalse"></div>
    <div class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-product mfp-fade mfp-ready" tabindex="-1" style="overflow: hidden auto;">
        <div class="mfp-container mfp-ajax-holder">
            <div class="mfp-content">
                <div class="product product-single row product-popup">
                    <div class="col-md-6">
                        <div class="product-gallery">
                            <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner owl-loaded owl-drag">
                                
                                <div class="owl-stage-outer">
                                    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0.5s ease 0s;">
                                        
                                        <div class="owl-item active" >
                                            <figure class="product-image">
                                                <img src="{{ Voyager::image($this->qproductimage) }}" data-zoom-image="{{ Voyager::image($this->qproductimage) }}" alt="{{ $this->qproduct->name }}">
                                            </figure>
                                        </div>

                                        {{-- @if(!empty($this->qproduct->images))
                                            @foreach (json_decode($this->qproduct->images) as $image)
                                                <div class="owl-item" style="width: 464px;">
                                                    <figure class="product-image">
                                                        <img src="{{ Voyager::image($image) }}" data-zoom-image="{{ Voyager::image($image) }}" alt="{{ $this->qproduct->name }}" width="580" height="580">
                                                    </figure>
                                                </div>
                                            @endforeach
                                        @endif --}}

                                    </div>
                                </div>
                                <div class="owl-nav disabled">
                                    <button type="button" title="presentation" class="owl-prev disabled"><i class="d-icon-angle-left"></i></button>
                                    <button type="button" title="presentation" class="owl-next disabled"><i class="d-icon-angle-right"></i></button>
                                </div>
                                <div class="owl-dots disabled"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-details scrollable pr-0 pr-md-3">
                            <a href="{{ route('product.slug', ['slug' => $this->qproduct->slug]) }}">
                                <h1 class="product-name mt-0">{{ $this->qproduct->getTranslatedAttribute('name', App::getLocale(), 'en') }}</h1>
                            </a>
                            <div class="product-meta">
                                SKU: <span class="product-sku">{{ $this->qproduct->sku }}</span>
                                BRAND: <span class="product-brand">{{ $this->qproduct->brand_id }}</span>
                            </div>

                            @livewire('addskutobag', [
                                'product' => $this->qproduct
                            ])

                            <hr class="product-divider mb-3">
                            <div class="product-footer">
                                {{-- <div class="social-links mr-4">
                                    <a href="#" class="social-link social-facebook fab fa-facebook-f"></a>
                                    <a href="#" class="social-link social-twitter fab fa-twitter"></a>
                                    <a href="#" class="social-link social-pinterest fab fa-pinterest-p"></a>
                                </div> --}}
                                @isset($shareComponent)
                                    {!! $shareComponent !!}    
                                @endisset
                                

                                {{-- <a href="#" class="btn-product btn-wishlist mr-4"><i class="d-icon-heart"></i>Add to wishlist</a> --}}
                                @livewire('wishlist', [
                                    'wishlistproductid' => $this->qproduct->id,
                                    'view' => 'product-page',
                                ])
                                
                                {{-- <a href="#" class="btn-product btn-compare"><i class="d-icon-compare"></i>Add
                                    to compare</a> --}}

                            </div>
                        </div>
                    </div>
                    <button title="Close (Esc)" wire:click="displayfalse" type="button" class="mfp-close"><span>×</span></button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>