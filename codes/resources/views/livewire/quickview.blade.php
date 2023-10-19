@if ($this->view == 'product-card')
    <a class="cart" href="javascript:void(0)" wire:click="displaytrue" title="Add to Cart" style="cursor: pointer;">
        <img src="{{ asset('/images/icons/wishlist.svg') }}" alt="wishlist">
    </a>
@else
    <div class="btn-product btn-quickviews" wire:click="displaytrue" title="Quick View" style="cursor: pointer;">
        Quick View
    </div>
@endif