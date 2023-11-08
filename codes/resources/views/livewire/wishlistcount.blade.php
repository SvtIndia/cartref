{{-- <div class="dropdown wishlist wishlist-dropdown off-canvas mr-4 d-lg-show"> --}}
<div class="dropdown cart-dropdown type2 mr-0 mr-lg-4  wishlist wishlist-dropdown off-canvas mr-4" style="display: block!important;">
    <a href="{{ route('wishlist') }}" class="wishlist-toggle link" title="wishlist">
        <i class="d-icon-heart">
            <span class="cart-count" style="background: red;">{{ count($wwproducts) }}</span>
        </i>
    </a>
    <div class="canvas-overlay"></div>
    <!-- End Wishlist Toggle -->
    <div class="dropdown-box scrollable">
        <div class="canvas-header">
            <h4 class="canvas-title">wishlist</h4>
            <a href="#" class="btn btn-dark btn-link btn-icon-right btn-close">close<i class="d-icon-arrow-right"></i><span class="sr-only">wishlist</span></a>
        </div>
        <div class="products scrollable">
            @if (count($wwproducts) > 0)
                @foreach ($wwproducts as $wishlist)
                    <div class="product product-wishlist">
                        <figure class="product-media">
                            <a href="{{ route('product.slug', ['slug' => $wishlist->slug]) }}">
                                <img src="{{ Voyager::image($wishlist->image) }}" alt="{{ $wishlist->name }}" width="100" height="100">
                            </a>
                            <form wire:submit.prevent="removew({{ $wishlist->id }})" method="post">
                                @csrf
                                <button type="" class="btn btn-link btn-close">
                                    <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                </button>
                            </form>
                        </figure>
                        <div class="product-detail">
                            <a href="{{ route('product.slug', ['slug' => $wishlist->slug]) }}" class="product-name">
                                {{ Str::limit($wishlist->name, 15, '...') }}
                            </a>
                            <div class="price-box">
                                <span class="product-price">{{ Config::get('icrm.currency.icon') }}{{ $wishlist->offer_price }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="product product-wishlist">
                    Your wishlist is empty
                </div>
            @endif




            <!-- End of wishlist Product -->
        </div>

        @if (count($wwproducts) > 0)
            <a href="{{ route('wishlist') }}" class="btn btn-dark wishlist-btn mt-4"><span>Go To
                Wishlist</span></a>
        @else
            <a href="{{ route('products') }}" class="btn btn-dark wishlist-btn mt-4"><span>Browse Products</span></a>
        @endif
        <!-- End of Products  -->
    </div>
    <!-- End Dropdown Box -->
</div>
