<div>

    {{-- @if (\Request::route()->getName() != 'product.slug' AND empty(Session::get('quickviewid')))
    @endif --}}

    @if ($this->view == 'new-product-card')
        <a href="javascript:void(0)" wire:click="wishlist" title="Add to wishlist" class="wishlist ">
            @if ($this->wishlistchecked == true)
                <i class="d-icon-heart-full" style="color: red; font-size:18px"></i>
            @else
                <img src="{{ asset('/images/icons/cart.svg') }}" alt="cart">
            @endif
        </a>
    @endif
    @if ($this->view == 'product-card')
        <div class="btn-product-icon @if ($this->wishlistchecked == true) btn-wishlist added @endif" title="Add to wishlist" wire:click="wishlist">
            @if ($this->wishlistchecked == true)
                <i class="d-icon-heart-full"></i>
            @elseif($this->wishlistchecked == false)
                <i class="d-icon-heart"></i>
            @endif
        </div>
    @endif

    {{-- @if (\Request::route()->getName() == 'product.slug' OR !empty(Session::get('quickviewid')))
    @endif --}}

    @if ($this->view == 'product-page')
    <a style="cursor: pointer;" class="btn-product btn-wishlist @if($this->wishlistchecked == true) added @endif mr-6" title="Add to wishlist" wire:click="wishlist">
        @if ($this->wishlistchecked == true) 
            <i class="d-icon-heart-full"></i>
            Remove from wishlist
        @elseif($this->wishlistchecked == false) 
            <i class="d-icon-heart"></i>
            Add to wishlist
        @endif
        
    </a>
    @endif


</div>