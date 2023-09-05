<div class="product-label-group">
    {{-- If sold out then show only that else show other --}}

    @if ($product->admin_status != 'Accepted')
        <label class="product-label label-new">Inactive</label>
    @endif
    
    @if ($product->productskus)
        {{-- Sold out --}}
        @if ($product->productskus()->where('available_stock', '>', 0)->count() == 0)
            <label class="product-label label-stock">{{ Config::get('icrm.frontend.outofstock.name') }}</label>
        @endif
        {{-- Sold out end --}}

        @if ($product->productskus()->where('available_stock', '>', 0)->count() > 0)
            {{-- New badge --}}
            @if (Config::get('icrm.frontend.badge.new_product.feature') == 1)
            @php
                $createddate = $product->created_at;
                $currentdate = Carbon\Carbon::now()->toDateTimeString();
                $daysdiff = $createddate->diff($currentdate)->days;
            @endphp

            @if ($daysdiff <= Config::get('icrm.frontend.badge.new_product.days'))
                <label class="product-label label-new">new</label>
            @endif
            @endif
            {{-- New badge end --}}

            {{-- Discount off --}}
            @if ($product->offer_price/$product->mrp*100 > 0)
                <label class="product-label label-sale">{{ number_format((100 - $product->offer_price/$product->mrp*100), 0) }}% OFF</label>    
            @endif
            {{-- Discount off end --}}

        @endif

    @endif    
</div>