@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.wishlist.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.wishlist.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.wishlist.description') }}">
@endsection

@section('content')
<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                <li>Wishlist</li>
            </ul>
        </div>
    </nav>
    <div class="page-content pt-10 pb-10 mb-2">
        <div class="container">
            @if (count($products) == 0)
                {{-- wishlist empty --}}
                <div class="p-20 mb-4 bg-light rounded-3 text-center">
                    <div class="container-fluid py-5">
                        <img src="{{ asset('images/icrm/wishlist/empty_wishlist.svg') }}" class="img-responsive" alt="wishlist empty">
                        <h1 class="display-5 fw-bold text-dark">Your wishlist is empty</h1>
                        <p class="fs-4 text-center">Browse products and add your favourite ones in wishlist</p>
                        <a href="{{ route('products') }}" class="btn btn-primary btn-lg" type="button">Browse Products</a>
                    </div>
                </div>
            @else
                {{-- wishlist table --}}
                <table class="shop-table wishlist-table mt-2 mb-4">
                    <thead>
                        <tr>
                            <th class="product-name"><span>Product</span></th>
                            <th></th>
                            <th class="product-price"><span>Price</span></th>
                            {{-- <th class="product-stock-status"><span>Stock status</span></th> --}}
                            <th class="product-add-to-cart"></th>
                            <th class="product-remove"></th>
                        </tr>
                    </thead>
                    <tbody class="wishlist-items-wrapper">
                        @foreach ($products as $product)
                        <tr>
                            <td class="product-thumbnail">
                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                    <figure>
                                        <img src="{{ Voyager::image($product->image) }}" alt="{{ $product->name }}" 
                                        {{-- width="200" height="200" --}}
                                        >
                                    </figure>
                                </a>
                            </td>
                            <td class="product-name">
                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">{{ ucwords($product->name) }}</a>
                            </td>
                            <td class="product-price">
                                <span class="amount">{{ Config::get('icrm.currency.icon') }}{{$product->offer_price}}</span>
                            </td>
                            {{-- <td class="product-stock-status">
                                <span class="wishlist-in-stock">In Stock</span>
                            </td> --}}
                            <td class="product-add-to-cart">
                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}" class="btn-product btn-primary"><span>Select
                                        variants</span></a>
                            </td>
                            <td class="product-remove">
                                <div>
                                    <form action="{{ route('bag.wishlist') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="remove" title="Remove this product"><i class="fas fa-times"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="social-links share-on">
                    <h5 class="text-uppercase font-weight-bold mb-0 mr-4 ls-s">Share on:</h5>
                    <a href="#" class="social-link social-icon social-facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link social-icon social-twitter" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link social-icon social-pinterest" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" class="social-link social-icon social-email" title="Email"><i class="far fa-envelope"></i></a>
                    <a href="#" class="social-link social-icon social-whatsapp" title="Whatsapp"><i class="fab fa-whatsapp"></i></a>
                </div> --}}
            @endif
            
            
        </div>
    </div>

</main>
@endsection


