<div class="col-md-6 sticky-sidebar-wrapper">
    <div class="pin-wrapper" style="height: 60px;">
        <div class="product-gallery pg-vertical sticky-sidebar" data-sticky-options="{'minWidth': 767}" style="border-bottom: 0px none rgb(102, 102, 102); width: 580px;">
        @include('product.badges')
        <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner owl-loaded owl-drag">
            <div class="owl-stage-outer">
                <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1844px;">
                    <div class="owl-item active" style="width: 461px;">
                        <figure class="product-image">
                            @if (!empty($this->colorproductmainimage))

                            <a href="{{ Voyager::image($this->colorproductmainimage) }}" data-fancybox="gallery" data-caption="{{ $product->name }}">
                                <img src="{{ Voyager::image($this->colorproductmainimage) }}" data-zoom-image="{{ Voyager::image($this->colorproductmainimage) }}" alt="{{ $product->name }}" width="800" height="900">
                            </a>
                                {{-- <div class="zoomContainer" style="height:518.633px; width:461px; -webkit-transform: translateZ(0);position:absolute;left:0px;top:0px;">
                                    <div class="zoomWindowContainer" style="width: 400px;">
                                        <div style="width: 461px; height: 518.633px; z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: 0px 0px; float: left; display: none; cursor: crosshair; border: 0px solid rgb(136, 136, 136); background-repeat: no-repeat; position: absolute; background-image: url({{ Voyager::image($this->colorproductmainimage) }});" class="zoomWindow">&nbsp;
                                        </div>
                                    </div>
                                </div> --}}
                            @else
                            <a href="{{ Voyager::image($this->colorproductmainimage) }}" data-fancybox="gallery" data-caption="{{ $product->name }}">
                                <img src="{{ Voyager::image($product->image) }}" data-zoom-image="{{ Voyager::image($product->image) }}" alt="{{ $product->name }}" width="800" height="900" >
                            </a>
                                {{-- <div class="zoomContainer" style="height:518.633px;width:461px; -webkit-transform: translateZ(0);position:absolute;left:0px;top:0px;">
                                    <div class="zoomWindowContainer" style="width: 400px;">
                                        <div style="width: 461px; height: 518.633px; z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: 0px 0px; float: left; display: none; cursor: crosshair; border: 0px solid rgb(136, 136, 136); background-repeat: no-repeat; position: absolute; background-image: url({{ Voyager::image($product->image) }});" class="zoomWindow">&nbsp;
                                        </div>
                                    </div>
                                </div> --}}
                            @endif

                        </figure>
                    </div>

                    @if (!empty($this->colorproductmoreimages))
                        @if (!empty($this->colorproductmoreimages))
                            @foreach (json_decode($this->colorproductmoreimages) as $key => $image)
                                <div class="owl-item" style="width: 461px;">
                                    <figure class="product-image">
                                        <a href="{{ Voyager::image($image) }}" data-fancybox="gallery" data-caption="{{ $product->name.$key }}">
                                        <img src="{{ Voyager::image($image) }}" data-zoom-image="{{ Voyager::image($image) }}" alt="{{ $product->name.$key }}" width="800" height="900">
                                        </a>
                                        {{-- <div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:0px;top:0px;height:518.633px;width:461px;">
                                            <div class="zoomWindowContainer" style="width: 400px;">
                                                <div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: 0px 0px; width: 461px; height: 518.633px; float: left; display: none; cursor: crosshair; border: 0px solid rgb(136, 136, 136); background-repeat: no-repeat; position: absolute; background-image: url({{ Voyager::image($image) }});" class="zoomWindow">&nbsp;
                                                </div>
                                            </div>
                                        </div> --}}
                                    </figure>
                                </div>
                            @endforeach
                        @endif
                    @else
                        @if(!empty($product->images))
                            @foreach (json_decode($product->images) as $image)
                                <div class="owl-item" style="width: 461px;">
                                    <figure class="product-image">
                                        <a href="{{ Voyager::image($image) }}" data-fancybox="gallery" data-caption="{{ $product->name }}">
                                        <img src="{{ Voyager::image($image) }}" data-zoom-image="{{ Voyager::image($image) }}" alt="{{ $product->name }}" width="800" height="900">
                                        </a>
                                        {{-- <div class="zoomContainer" style="height:518.633px;width:461px; -webkit-transform: translateZ(0);position:absolute;left:0px;top:0px;">
                                            <div class="zoomWindowContainer" style="width: 400px;"">
                                                <div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: 0px 0px; width: 461px; height: 518.633px; float: left; display: none; cursor: crosshair; border: 0px solid rgb(136, 136, 136); background-repeat: no-repeat; position: absolute; background-image: url({{ Voyager::image($image) }});" class="zoomWindow">&nbsp;
                                                </div>
                                            </div>
                                        </div> --}}
                                    </figure>
                                </div>
                            @endforeach
                        @endif
                    @endif


                    {{-- This was the last image --}}
                    <div class="owl-item" style="width: 461px;">
                        <figure class="product-image">
                            <img src="{{ asset('images/product/product-16-4-600x675.jpg') }}" data-zoom-image="{{ asset('images/product/product-16-4-600x675.jpg') }}" alt="Converse Training Shoes" width="800" height="900">
                            <div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:0px;top:0px;height:518.633px;width:461px;">
                                <div class="zoomWindowContainer" style="width: 400px;">
                                    <div style="z-index: 999; overflow: hidden; margin-left: 0px; margin-top: 0px; background-position: 0px 0px; width: 461px; height: 518.633px; float: left; display: none; cursor: crosshair; border: 0px solid rgb(136, 136, 136); background-repeat: no-repeat; position: absolute; background-image: url(&quot;images/product/product-16-4.jpg&quot;);" class="zoomWindow">&nbsp;
                                    </div>
                                </div>
                            </div>
                        </figure>
                    </div>

                </div>
            </div>

            <a href="#" class="product-image-full">
                <i class="d-icon-zoom"></i>
            </a>

            <div class="owl-nav">
                <button type="button" title="presentation" class="owl-prev disabled">
                    <i class="d-icon-angle-left"></i>
                </button>
                <button type="button" title="presentation" class="owl-next">
                    <i class="d-icon-angle-right"></i>
                </button>
            </div>
            <div class="owl-dots disabled"></div>
        </div>

        <div class="product-thumbs-wrap">
            <div class="product-thumbs">
                <div class="product-thumb active">

                    @if (!empty($this->colorproductmainimage))
                        <img src="{{ Voyager::image($this->colorproductmainimage) }}" alt="{{ $product->name }}" width="150" height="169">
                    @else
                        <img src="{{ Voyager::image($product->image) }}" alt="{{ $product->name }}" width="150" height="169">
                    @endif

                </div>

                @if (!empty($this->colorproductmoreimages))
                    @if(!empty($this->colorproductmoreimages))
                        @foreach (json_decode($this->colorproductmoreimages) as $image)
                            <div class="product-thumb">
                                <img src="{{ Voyager::image($image) }}" alt="{{ $product->name }}" width="150" height="169">
                            </div>
                        @endforeach
                    @endif
                @else
                    @if(!empty($product->images))
                        @foreach (json_decode($product->images) as $image)
                            <div class="product-thumb">
                                <img src="{{ Voyager::image($image) }}" alt="{{ $product->name }}" width="150" height="169">
                            </div>
                        @endforeach
                    @endif
                @endif


            </div>
            <button class="thumb-up disabled"><i class="fas fa-chevron-left"></i></button>
            <button class="thumb-down"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</div>
</div>


@push('scripts')
    <script src="{{ asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
