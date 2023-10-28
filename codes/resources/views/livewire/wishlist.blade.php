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
        <div class="btn-product-icon @if ($this->wishlistchecked == true) btn-wishlist added @endif"
             title="Add to wishlist" wire:click="wishlist">
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
        <a style="cursor: pointer;"
           class="btn-product btn-wishlist @if($this->wishlistchecked == true) added @endif mr-6"
           title="Add to wishlist" wire:click="wishlist">
            @if ($this->wishlistchecked == true)
                <i class="d-icon-heart-full"></i>
                Remove from wishlist
            @elseif($this->wishlistchecked == false)
                <i class="d-icon-heart"></i>
                Add to wishlist
            @endif

        </a>
    @endif
    @if ($this->view == 'new-product-page')
        <button class="new-wishlist-btn" type="button"
            @if ($this->wishlistchecked == true)
                title="Remove from wishlist"
            @elseif($this->wishlistchecked == false)
                title="Add to wishlist"
            @endif
            wire:click="wishlist"
        >
                <span class="new-wishlist-span">
                    @if ($this->wishlistchecked == true)
                        <i class="d-icon-heart-full" style="font-size: 2rem;color:red"></i>
                    @elseif($this->wishlistchecked == false)
                        <i class="d-icon-heart" style="font-size: 2rem;"></i>
                    @endif

{{--                    <svg viewBox="0 0 24 24" style="font-size: 24px;" width="1em"--}}
{{--                         height="1em" fill="currentColor"--}}
{{--                         aria-labelledby="wishlist-:R4k:"--}}
{{--                         focusable="false" aria-hidden="false" role="img">--}}
{{--                        <path d="M17.488 1.11h-.146a6.552 6.552 0 0 0-5.35 2.81A6.57 6.57 0 0 0 6.62 1.116 6.406 6.406 0 0 0 .09 7.428c0 7.672 11.028 15.028 11.497 15.338a.745.745 0 0 0 .826 0c.47-.31 11.496-7.666 11.496-15.351a6.432 6.432 0 0 0-6.42-6.306zM12 21.228C10.018 19.83 1.59 13.525 1.59 7.442c.05-2.68 2.246-4.826 4.934-4.826h.088c2.058-.005 3.93 1.251 4.684 3.155.226.572 1.168.572 1.394 0 .755-1.907 2.677-3.17 4.69-3.16h.02c2.7-.069 4.96 2.118 5.01 4.817 0 6.089-8.429 12.401-10.41 13.8z"></path>--}}
{{--                    </svg>--}}
                </span>
        </button>
    @endif


</div>