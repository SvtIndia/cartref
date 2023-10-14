<div>
    <main class="main order">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                    <li><a href="{{ route('showcase.myorders') }}">My Showroom Orders</a></li>
                    <li>Showroom Order</li>
                </ul>
            </div>
        </nav>
        <div class="page-content pt-7 pb-10 mb-10">

            <div class="step-by pr-4 pl-4">
                <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'showcase.ordercomplete') active @endif"><a href="{{ route('showcase.ordercomplete', ['id' => $items->first()->order_id]) }}">Showroom Order</a></h3>
                <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'showcase.buynow') active @endif"><a href="#">Buy now</a></h3>
            </div>

            <div class="container mt-8">
                @if ($items[0]->order_status != 'Cancelled')
                    <div class="order-message mr-auto ml-auto">
                        <div class="icon-box d-inline-flex align-items-center">
                            <div class="icon-box-icon mb-0">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50" enable-background="new 0 0 50 50" xml:space="preserve">
                                    <g>
                                        <path fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="bevel" stroke-miterlimit="10" d="
                                            M33.3,3.9c-2.7-1.1-5.6-1.8-8.7-1.8c-12.3,0-22.4,10-22.4,22.4c0,12.3,10,22.4,22.4,22.4c12.3,0,22.4-10,22.4-22.4
                                            c0-0.7,0-1.4-0.1-2.1"></path>
                                        <polyline fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel" stroke-miterlimit="10" points="
                                            48,6.9 24.4,29.8 17.2,22.3 	"></polyline>
                                    </g>
                                </svg>
                            </div>

                            <div class="icon-box-content text-left">
                                <h5 class="icon-box-title font-weight-bold lh-1 mb-1">Thank You!</h5>
                                <p class="lh-1 ls-m">Your order has been received</p>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="order-results">
                    <div class="overview-item">
                        <span>Order Date:</span>
                        <strong>{{ date('d-M-Y', strtotime($items[0]->created_at)) }}</strong>
                    </div>

                    <div class="overview-item">
                        <span>Order number:</span>
                        <strong>{{ $items[0]->order_id }}</strong>
                    </div>

                    {{-- <div class="overview-item">
                        <span>Order type:</span>
                        <strong>{{ $items[0]->type }}</strong>
                    </div> --}}

                    <div class="overview-item">
                        <span>Items:</span>
                        <strong>{{ count($items) }}</strong>
                    </div>

                    <div class="overview-item">
                        <span>Weight:</span>
                        <strong>{{ $items[0]->order_weight }}kg</strong>
                    </div>

                    <div class="overview-item">
                        <span>Total:</span>
                        <strong>{{ Config::get('icrm.currency.icon') }}{{ number_format($items[0]->order_total, 2) }}</strong>
                    </div>

                    <div class="overview-item">
                        <span>Payment method:</span>
                        @if ($items[0]->order_method == 'COD')
                            <strong>Cash on delivery</strong>
                        @else
                            <strong>Prepaid</strong>
                        @endif
                    </div>

                    @if (!empty($items->first()->exp_delivery_date) AND !$items->where('order_status', '==','Purchased')->first() AND $items->first()->order_status != 'Cancelled')
                        <div class="overview-item">
                            <span>Expected Delivery:</span>
                            <strong>{{ date('d-M-Y', strtotime($items[0]->exp_delivery_date)) }}</strong>
                        </div>
                    @endif

                    @if (!empty($items[0]->order_awb ))
                        <div class="overview-item">
                            <span>Order Tracking ID:</span>
                            <strong>{{ $items[0]->order_awb }}</strong>
                        </div>
                    @endif

                    @if ($items[0]->deliveryboy_id)
                        <div class="overview-item">
                            <span>Delivery Boy:</span>
                            @if ($items[0]->deliveryboy_id)
                                <strong>{{ $items[0]->deliveryboy->name }}</strong>
                                <a href="tel:{{ $items[0]->deliveryboy->mobile }}"> {{ $items[0]->deliveryboy->mobile }} </a>
                            @else
                                <strong>Not Assigned</strong>
                            @endif
                        </div>
                    @endif
                </div>


                <div class="order-actions">
                    <div class="float-left">
                        <a href="{{ route('showcase.myorders') }}" class="btn btn-icon-left btn-dark btn-rounded btn-md mb-4"><i class="d-icon-arrow-left"></i> My Showrooms</a>
                    </div>
                    <div class="float-right">

                        {{-- If any of the product is already purchased then hide --}}
                        {{-- If the order has already cancelled then hide --}}
                        @if(!$items->where('order_status', '==','Purchased')->first())
                            <a wire:click="cancelorder" wire:loading.remove class="btn btn-icon-right btn-light btn-rounded btn-md mb-4 ml-3">Cancel Order<i class="fa fa-times-circle"></i>
                            </a>
                            <a wire:loading wire:target="cancelorder" class="btn btn-icon-right btn-alert btn-rounded btn-md mb-4 ml-3">
                                Cancelling...<i class="fa fa-times-circle"></i>
                            </a>
                        @endif


                    </div>
                </div>
                <br>

                <h2 class="title title-simple text-left pt-4 font-weight-bold text-uppercase">Order Details</h2>
                <div class="order-details">
                    <table class="order-details-table">
                        <thead>
                            <tr class="summary-subtotal">
                                <td>
                                    <h3 class="summary-subtitle">Product</h3>
                                </td>
                                <td>
                                    <h3 class="summary-subtitle">Name</h3>
                                </td>
                                <td>
                                    <h3 class="summary-subtitle">Status</h3>
                                </td>
                                <td>
                                    <h3 class="summary-subtitle">Type</h3>
                                </td>
                                <td>
                                    <h3 class="summary-subtitle">Quantity</h3>
                                </td>
                                <td>
                                    <h3 class="summary-subtitle">Actions</h3>
                                </td>
                                <td>
                                    <h3 class="summary-subtitle">Price</h3>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($items)

                            @if (count($items) > 0)

                                @foreach ($items as $item)
                                    <tr>
                                        <td class="product-name">
                                            @php
                                                $productimage = App\Productcolor::where('product_id', $item->product_id)->where('color', $item->color)->first();

                                                if(empty($productimage->main_image))
                                                {
                                                    $productimage = $item->product->image;
                                                }else{
                                                    $productimage = $productimage->main_image;
                                                }
                                            @endphp
                                            <img src="{{ Voyager::image($productimage) }}" alt="{{ $item->product->name }}" style="max-height: 5em;">
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route('product.slug', ['slug' => $item->product->slug, 'color' => $item->color]) }}" target="_blank" style="color: blue;">
                                                {{ Str::limit($item->product->name, 50) }}
                                            </a>

                                            <br><span>Vendor: <a href="{{ route('products.vendor', ['slug' => $item->vendor_id]) }}" style="color: blue;">{{ $item->vendor->name }}</a></span>
                                            <br><span>Brand: {{ $item->product->brand_id }}</span>
                                            <br><span>Color: {{ $item->color }}</span>
                                            <br><span>Size: {{ $item->size }}</span>

                                            <br><span>Order type: {{ $item->type }}</span>

                                            <br><span>Hsn: {{ $item->product->productsubcategory->hsn }}</span>
                                        </td>
                                        <td class="product-amount">
                                            @if($item->order_status == 'Out For Showcase')
                                                <strong>Pickup </strong>
                                            @elseif($item->order_status == 'Showcased')
                                                <strong>Handover</strong>
                                            @else
                                                <strong>{{ $item->order_status }}</strong>
                                            @endif
                                        </td>
                                        <td class="product-amount">
                                            {{ $item->type }}
                                        </td>
                                        <td class="product-amount">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="product-amount">

                                            @if ($items->whereIn('order_status', ['Purchased', 'Returns'])->count() == 0)
                                                @if ($item->order_status == 'Showcased')
                                                    <a wire:click="movetobag({{ $item->id }})" class="btn btn-sm btn-dark btn-light">Move to Bag</a>
                                                @elseif($item->order_status == 'Moved to Bag')
                                                    <a href="{{ route('showcase.buynow', ['id' => $item->order_id]) }}" class="btn btn-sm btn-success btn-light">Go to Bag</a>
                                                @elseif($item->order_status == 'Purchased' OR $item->order_status == 'Returned')
                                                    -
                                                @else
                                                    <a title="Enables once the order reaches you." class="btn btn-sm btn-dark btn-light btn-disabled">Move to Bag</a>
                                                @endif
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td class="product-amount">
                                            {{ Config::get('icrm.currency.icon') }}{{ $item->price_sum }}
                                        </td>
                                    </tr>
                                @endforeach

                            @endif

                            @endisset

                            <tr class="summary-subtotal mt-10">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Showroom At Home Charges:</h4>
                                </td>
                                <td class="summary-subtotal-price" style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ $item->order_value }}</td>
                            </tr>



                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Subtotal:</h4>
                                </td>
                                <td class="summary-subtotal-price" style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ $item->order_subtotal }}</td>
                            </tr>

                            @if ($item->order_tax > 0)
                                <tr class="summary-subtotal">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <h4 class="summary-subtitle">GST:</h4>
                                    </td>
                                    <td class="summary-subtotal-price" style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ $item->order_tax }}</td>
                                </tr>
                            @endif

                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Total:</h4>
                                </td>
                                <td>
                                    <p class="summary-total-price" style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ $item->order_total }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h2 class="title title-simple text-left pt-10 mb-2">Billing Address</h2>
                <div class="address-info pb-8 mb-6">

{{--                    @if (!empty($items[0]->company_name))--}}
{{--                        <div class="email">--}}
{{--                            {{ $items[0]->company_name }}<br>--}}
{{--                            {{ $items[0]->gst_number }}--}}
{{--                        </div>                        --}}
{{--                    @endif--}}

                    <p class="address-detail pb-2">
                        {{ $items[0]->dropoff_streetaddress1 }}<br>
                        {{ $items[0]->dropoff_streetaddress2 }}<br>
                        {{ $items[0]->dropoff_pincode }}, {{ $items[0]->dropoff_city }}, {{ $items[0]->dropoff_state }}<br>
                        {{ $items[0]->dropoff_country }} <br>
                        {{ $items[0]->customer_email }} <br>
                        {{ $items[0]->customer_contact_number }} <br>
                    </p>
                </div>


            </div>
        </div>

    </main>
</div>
