<div>
    <main class="main cart">
        <div class="page-content pt-7 pb-10">
            @include('livewire.showcase.bag_header')
            <div class="container mt-7 mb-2">
                <div class="row">
                    <div class="col-lg-8 col-md-12 pr-lg-4">
                        
                        @if (count($showcasecarts) > 0)
                            <table class="shop-table cart-table">
                                <thead>
                                    <tr>
                                        <th><span>Product</span></th>
                                        <th><span>Details</span></th>
{{--                                        <th><span>Weight</span></th>--}}
                                        <th><span>Price</span></th>
                                        {{-- <th>Action</th> --}}
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showcasecarts as $showcase)
                                        @php
                                            $product = App\Models\Product::where('id', $showcase->attributes->product_id)->first();

                                            if(empty($product))
                                            {
                                                $userID = 0;
                                                if(\Illuminate\Support\Facades\Auth::check()){
                                                    $userID = auth()->user()->id;
                                                }
                                                else{
                                                    if(session('session_id')){
                                                        $userID = session('session_id');
                                                    }
                                                    else{
                                                        $userID = rand(1111111111,9999999999);
                                                        session(['session_id' => $userID]);
                                                    }
                                                }
                                                app('showcase')->session($userID)->clear();
                                            }

                                        @endphp
                                        @if (!empty($product))
                                        <tr class="cart-tr">
                                            <td class="product-thumbnail">
                                                <figure>
                                                    <a href="{{ route('product.slug', ['slug' => $showcase->attributes->slug, 'color' => $showcase->attributes->color]) }}">

                                                        @php
                                                            $colorimage = App\Productcolor::where('product_id', $showcase->attributes->product_id)->where('color', $showcase->attributes->color)->first();

                                                            if(!empty($colorimage->main_image))
                                                            {
                                                                $colorimage = $colorimage->main_image;
                                                            }else{
                                                                $colorimage = $product->image;
                                                            }
                                                        @endphp
                                                    
                                                        <img src="{{ Voyager::image($colorimage) }}" width="100" height="100"
                                                            alt="{{ $showcase->name }} in {{ $showcase->attributes->color }} color">
                                                    </a>
                                                </figure>
                                            </td>
                                            <td class="product-name" style="width: 50% !important;">
                                                <div class="product-name-section">
                                                    <a href="{{ route('product.slug', ['slug' => $showcase->attributes->slug, 'color' => $showcase->attributes->color]) }}">{{ $showcase->name }}</a>
                                                    <p>
                                                        <br><span>Vendor: <a href="{{ route('products.vendor', ['slug' => $product->vendor->id]) }}" style="color: blue;">{{ $product->vendor->brand_name }}</a></span>
                                                        <br><span>Brand: {{ $product->brand_id }}</span>
                                                        <br><span>Color: {{ $showcase->attributes->color }}</span>
                                                        <br><span>Size: {{ $showcase->attributes->size }}</span>
                                                        <br><span>Order type: {{ $showcase->attributes->type }}</span>
                                                    </p>
                                                </div>
                                            </td>
{{--                                            <td class="product-subtotal">--}}
{{--                                                <span class="amount">{{ $showcase->attributes->weight }}kg</span>--}}
{{--                                            </td>--}}
                                            <td class="product-subtotal">
                                                <span class="amount">{{ Config::get('icrm.currency.icon') }} {{ $showcase->price }}</span>
                                            </td>
                                            <td class="product-close">
                                                <a wire:click="removeShowcase('{{ $showcase->id }}')" class="product-remove" title="Remove this product">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                            <td class="product-close">
                                                <a wire:click="wishlist('{{ $product->id }}','{{ $showcase->id }}')"
                                                   class="product-remove"
                                                   title="Move to wishlist" style="color:red; border-color:red;">
                                                    <i class="d-icon-heart"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="cart-actionss mb-6 pt-4">
                                <a href="{{ route('products.showcase.vendor', ['vendor_id' => $showcasecarts->first()->attributes->vendor_id]) }}" class="btn btn-dark btn-md btn-rounded btn-icon-left mr-4 mb-4">
                                    <i class="d-icon-arrow-left"></i>
                                    Continue Shopping From {{ App\Models\User::where('id', $showcasecarts->first()->attributes->vendor_id)->first()->brand_name }}
                                </a><br>
                                <small>At a time you can only request showcase at home from one vendor</small>
                                
                                {{-- <button type="submit"
                                    class="btn btn-outline btn-dark btn-md btn-rounded btn-disabled">Update
                                    Cart</button> --}}
                            </div>
                            {{-- <div class="cart-coupon-box mb-8">
                                <h4 class="title coupon-title text-uppercase ls-m">Coupon Discount</h4>
                                <input type="text" name="coupon_code"
                                    class="input-text form-control text-grey ls-m mb-4" id="coupon_code" value=""
                                    placeholder="Enter coupon code here...">
                                <button type="submit" class="btn btn-md btn-dark btn-rounded btn-outline">Apply
                                    Coupon</button>
                            </div> --}}
                        @else
                            <div class="p-20 mb-4 bg-light rounded-3 text-center">
                                <div class="container-fluid py-5">
                                    <img src="{{ asset('images/icrm/wishlist/empty_wishlist.svg') }}" class="img-responsive" alt="wishlist empty">
                                    <h1 class="display-5 fw-bold text-dark">Your showcase at home is empty</h1>
                                    <p class="fs-4 text-center">Browse products and add your favourite ones in showcase at home bag</p>
                                    <a href="{{ route('products.showcase') }}" class="btn btn-primary btn-lg" type="button">Browse Products</a>
                                </div>
                            </div>
                        @endif
                            
                        
                    </div>
                    <aside class="col-lg-4 sticky-sidebar-wrapper">
                        <div class="sticky-sidebar" data-sticky-options="{'bottom': 20}">
                            <div class="summary mb-4">
                                <h3 class="summary-title text-left">Totals</h3>
                                <table class="shipping">
                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Items Allowed Per Order</h4>
                                        </td>
                                        <td>
                                            <p class="summary-subtotal-price">{{ count($showcasecarts) }}/{{ Config::get('icrm.showcase_at_home.order_limit') }}</p>
                                        </td>
                                    </tr>

                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Showcase At Home Charges</h4>
                                        </td>
                                        <td>
                                            <p class="summary-subtotal-price">{{ Config::get('icrm.currency.icon') }}{{ number_format($subtotal, 2) }}</p>
                                        </td>
                                    </tr>
                                    
                                    <tr class="sumnary-shipping shipping-row-last">
                                        <td colspan="2">
                                            <h4 class="summary-subtitle">Check Service Availability</h4>
                                        </td>
                                    </tr>
                                </table>
                                <div class="shipping-address">
                                    <form wire:submit.prevent="checkserviceavailability">
                                        <input type="text" 
                                            class="form-control @if(Session::has('sdeliveryavailable')) available @endif @if(Session::has('sdeliverynotavailable')) notavailable @endif" 
                                            wire:model.defer="deliverypincode" 
                                            placeholder="Delivery Pincode" />
                                        @if (Session::has('sdeliveryavailable') == true)
                                            <small class="available" style="line-height: 1 !important;">{{ Session::get('sdeliveryavailable') }}</small> <br>
                                        @endif
                                        @if (Session::has('sdeliverynotavailable') == true)
                                            <small class="notavailable">{{ Session::get('sdeliverynotavailable') }}</small> <br>   
                                        @endif
                                        
                                        
                                        <button type="submit" class="btn btn-md btn-dark btn-rounded btn-outline">Check</button>
                                    </form>
                                </div>
                                <table class="total">
                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Total</h4>
                                        </td>
                                        <td>
                                            <p class="summary-total-price ls-s">{{ Config::get('icrm.currency.icon') }} {{ number_format($total, 2) }}</p>
                                        </td>
                                    </tr>
                                </table>

                                <a class="btn btn-dark btn-rounded btn-checkout" wire:click="proceedcheckout">
                                    Proceed to checkout
                                </a>
                                @if($this->deliveryavailability == false)
                                    <small class="outofstock">Before processing please check service availability in your area</small>
                                @endif

                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    
    </main>
</div>