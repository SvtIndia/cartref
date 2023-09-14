@extends('layouts.website')

@section('meta-seo')
    <title>
        {{-- @if (request('category'))
            {{ ucwords(str_replace('-', ' ', request('category'))).' - ' }}
        @elseif(request('subcategory'))
        {{ ucwords(str_replace('-', ' ', request('subcategory'))).' - ' }}
        @endif

        {{ Config::get('seo.catalog.title') }} --}}
        {{$user->brand_name ?? $user->name }} | Brand
    </title>

    <meta name="keywords" content="{{ Config::get('seo.catalog.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.catalog.description') }}">
@endsection


@section('content')
    <div class="page-content">
        <div class="page-content mb-10 pb-3">
            <div class="container mt-10 mb-10">
                <div class="row main-content-wrap gutter-lg">
                    <div class="col-lg-12 main-content">
                        <div class="row cols-2 cols-sm-4 product-wrapper box-mode">
                            {{-- @foreach ($users as $user) --}}
                                <div class="product-wrap">
                                    <div class="post">
                                        {{-- <figure class="post-media">
                                            <a href="https://cartref.vteducation.in/product/castoes-slippers-blue-8">
                                                <img src="{{ Voyager::image($user->avatar) }}"
                                                    alt="{{ $user->name }}"onerror="this.onerror=null;this.src='{{ config('app.url') }}/images/placeholer.png';" />
                                            </a>
                                        </figure> --}}
                                        <div class="product-details">
                                            <h3 class="product-name">
                                                <a
                                                    href="{{ route('products') }}?brand_name={{ $user->brand_name }}">{{ $user->brand_name }}</a>
                                            </h3>
                                            <div class="product-price">
                                                <span class="product-name">{{ $user->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- @endforeach --}}
                            {{-- <div class="product-wrap">
                            <div class="product">
                                <figure class="product-media">
                                    <a href="https://cartref.vteducation.in/product/maeve-and-shelby-mens-formal-slipons-moccasins-designer-comfortable-shoes-for-men">
                                        <img src="https://cartref.vteducation.in/storage/productcolors/July2022/99HA39drbt9x0wcgtVB5.jpg" alt="MAEVE &amp; SHELBY Mens Formal Slipons Moccasins Designer Comfortable Shoes for Men" />
                                    </a>
                                    <div class="product-label-group">
                                        <label class="product-label label-sale">55% OFF</label>
                                    </div>
                                    <div class="product-action-vertical">
                                        <div wire:id="G3JtSo2bOoGG7e3wAJZP">
                                            <div class="btn-product-icon" title="Add to wishlist" wire:click="wishlist">
                                                <i class="d-icon-heart"></i>
                                            </div>
                                        </div>
                                        <!-- Livewire Component wire-end:G3JtSo2bOoGG7e3wAJZP -->
                                    </div>
                                    <div class="product-action">
                                        <div wire:id="jGeqKdjvyXFK5yjXTgOF" class="btn-product btn-quickviews" wire:click="displaytrue" title="Quick View" style="cursor: pointer;">
                                            Quick View
                                        </div>
                                        <!-- Livewire Component wire-end:jGeqKdjvyXFK5yjXTgOF -->
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="product-cat">
                                        <a href="https://cartref.vteducation.in/products/subcategory/formal-shoes">Formal Shoes</a>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="https://cartref.vteducation.in/product/maeve-and-shelby-mens-formal-slipons-moccasins-designer-comfortable-shoes-for-men">MAEVE &amp; SHELBY Mens Formal Slipons Moccasins...</a>
                                    </h3>
                                    <div class="product-price">
                                        <ins class="new-price">₹1340/-</ins><del class="old-price">₹2999 </del>
                                        <span class="product-name"> by S&amp;T SHOES</span>
                                    </div>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 0%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="https://cartref.vteducation.in/product/maeve-and-shelby-mens-formal-slipons-moccasins-designer-comfortable-shoes-for-men" class="link-to-tab rating-reviews">( 0 reviews )</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-wrap">
                            <div class="product">
                                <figure class="product-media">
                                    <a href="https://cartref.vteducation.in/product/castoes-men-black-sandal">
                                        <img src="https://cartref.vteducation.in/storage/productcolors/December2022/Pm9BuLIiynaxIfWvpZwd.webp" alt="Castoes  Men Black Sandal" />
                                    </a>
                                    <div class="product-label-group">
                                        <label class="product-label label-sale">53% OFF</label>
                                    </div>
                                    <div class="product-action-vertical">
                                        <div wire:id="6oRbDNKtAEuthZSJzwdR">
                                            <div class="btn-product-icon" title="Add to wishlist" wire:click="wishlist">
                                                <i class="d-icon-heart"></i>
                                            </div>
                                        </div>
                                        <!-- Livewire Component wire-end:6oRbDNKtAEuthZSJzwdR -->
                                    </div>
                                    <div class="product-action">
                                        <div wire:id="SY6LdZtaC6qWpjp0caV3" class="btn-product btn-quickviews" wire:click="displaytrue" title="Quick View" style="cursor: pointer;">
                                            Quick View
                                        </div>
                                        <!-- Livewire Component wire-end:SY6LdZtaC6qWpjp0caV3 -->
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="product-cat">
                                        <a href="https://cartref.vteducation.in/products/subcategory/slippers">Slippers</a>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="https://cartref.vteducation.in/product/castoes-men-black-sandal">Castoes Men Black Sandal</a>
                                    </h3>
                                    <div class="product-price">
                                        <ins class="new-price">₹474/-</ins><del class="old-price">₹999 </del>
                                        <span class="product-name"> by A J Enterprises</span>
                                    </div>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 0%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="https://cartref.vteducation.in/product/castoes-men-black-sandal" class="link-to-tab rating-reviews">( 0 reviews )</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-wrap">
                            <div class="product">
                                <figure class="product-media">
                                    <a href="https://cartref.vteducation.in/product/maeve-and-shelby-men-leather-loafer-shoes-office-casual-formal-leather-shoe-footwear-for-men-and-boys">
                                        <img
                                            src="https://cartref.vteducation.in/storage/productcolors/July2022/yeDbZTxbfWYjVq86u15j.jpg"
                                            alt="MAEVE &amp; SHELBY Men Leather Loafer Shoes Office Casual Formal Leather Shoe Footwear for Men &amp; Boys"
                                        />
                                    </a>
                                    <div class="product-label-group">
                                        <label class="product-label label-sale">63% OFF</label>
                                    </div>
                                    <div class="product-action-vertical">
                                        <div wire:id="dcQ6joQFAO8Lrk2TGEb6">
                                            <div class="btn-product-icon" title="Add to wishlist" wire:click="wishlist">
                                                <i class="d-icon-heart"></i>
                                            </div>
                                        </div>
                                        <!-- Livewire Component wire-end:dcQ6joQFAO8Lrk2TGEb6 -->
                                    </div>
                                    <div class="product-action">
                                        <div wire:id="cfVdrMXwZEL9T4A2UK1u" class="btn-product btn-quickviews" wire:click="displaytrue" title="Quick View" style="cursor: pointer;">
                                            Quick View
                                        </div>
                                        <!-- Livewire Component wire-end:cfVdrMXwZEL9T4A2UK1u -->
                                    </div>
                                </figure>
                                <div class="product-details">
                                    <div class="product-cat">
                                        <a href="https://cartref.vteducation.in/products/subcategory/formal-shoes">Formal Shoes</a>
                                    </div>
                                    <h3 class="product-name">
                                        <a href="https://cartref.vteducation.in/product/maeve-and-shelby-men-leather-loafer-shoes-office-casual-formal-leather-shoe-footwear-for-men-and-boys">
                                            MAEVE &amp; SHELBY Men Leather Loafer Shoes Offic...
                                        </a>
                                    </h3>
                                    <div class="product-price">
                                        <ins class="new-price">₹1095/-</ins><del class="old-price">₹2999 </del>
                                        <span class="product-name"> by S&amp;T SHOES</span>
                                    </div>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width: 0%;"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="https://cartref.vteducation.in/product/maeve-and-shelby-men-leather-loafer-shoes-office-casual-formal-leather-shoe-footwear-for-men-and-boys" class="link-to-tab rating-reviews">
                                            ( 0 reviews )
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Livewire Component wire-end:7siXOD3evKnwmcef4hyX -->
    </div>
@endsection
