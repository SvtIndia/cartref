@if (isset($flashsales))
    
    @if (count($flashsales) > 0)
    <section class="mt-10 pt-7 appear-animate fadeIn appear-animation-visible home-product" data-animation-options="{
        'delay': '.2s'
    }" style="animation-duration: 1.2s;">
        <div class="container">
            <h2 class="title title-center">Flash Sale</h2>
            <div class="row">
                @foreach ($flashsales as $product)
                <div class="col-lg-3 col-6 mb-3">
                    <div class="product text-center">
                        <figure class="product-media">
                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                <img src="{{ Voyager::image($product->image) }}" alt="{{ $product->product_title }}" width="500" height="345">
                            </a>
                            @include('product.badges')
                            <div class="product-label-group">
                                @if (Config::get('icrm.frontend.new_product.feature') == 1)
                                    @php
                                        $createddate = $product->created_at;
                                        $currentdate = Carbon\Carbon::now()->toDateTimeString();
                                        $daysdiff = $createddate->diff($currentdate)->days;
                                    @endphp

                                    @if ($daysdiff <= Config::get('icrm.frontend.new_product.days'))
                                        <label class="product-label label-new">new</label>
                                    @endif
                                @endif
                            </div>
                            <div class="product-action-vertical">
                                
                                {{-- @livewire('addtobag', [
                                    'product' => $product
                                ]) --}}

                                @livewire('wishlist', [
                                    'wishlistproductid' => $product->id
                                ])

                            </div>
                            <div class="product-action">

                                @livewire('quickview', [
                                    'product' => $product
                                ], key($product->id))
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="product-cat">
                                <a href="{{ route('products.subcategory', ['subcategory' => $product->productsubcategory->slug]) }}">{{ $product->productsubcategory->name }}</a>
                            </div>
                            <h3 class="product-name">
                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">{{ Str::limit($product->getTranslatedAttribute('name', App::getLocale(), 'en'), 50) }}</a>
                            </h3>
                            <div class="product-price">
                                <ins class="new-price">{{ Config::get('icrm.currency.icon') }}{{ $product->offer_price }}</ins><del class="old-price">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }}</del>
                            </div>
                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width: 
                                    @if($product->productreviews)
                                    {{ $product->productreviews()->sum('rate') / ($product->productreviews()->count() * 5) * 100 }}%
                                    @else   
                                    0%
                                    @endif"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}" class="link-to-tab rating-reviews">( @if($product->productreviews) {{ $product->productreviews()->count()  }} @else 0 @endif reviews )</a>
                            </div>
                            @if (isset($product->productcolors))
                                @if (count($product->productcolors) > 0)
                                    <div class="product-variations">
                                        @foreach ($product->productcolors as $key => $productcolor)
                                            @if (empty($productcolor->main_image))
                                                    {{-- Fetch product image --}}
                                                <a class="color @if($key == 0) active @endif" data-src="{{ Voyager::image($product->image) }}" href="{{ route('product.slug', ['slug' => $product->slug, 'color' => $productcolor->color]) }}" style="background-color: {{ $productcolor->color }}"></a>
                                            @else
                                                {{-- Fetch product color image --}}
                                                <a class="color @if($key == 0) active @endif" data-src="{{ Voyager::image($productcolor->main_image) }}" href="{{ route('product.slug', ['slug' => $product->slug, 'color' => $productcolor->color]) }}" style="background-color: {{ $productcolor->color }}"></a>
                                            @endif
                                        @endforeach
                                    </div>                                      
                                @endif
                            @endif
                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endif

