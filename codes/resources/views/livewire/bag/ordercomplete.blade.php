<div>
    <main class="main order">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                    <li><a href="{{ route('myorders') }}">My Orders</a></li>
                    <li>Order</li>
                </ul>
            </div>
        </nav>
        <div class="page-content pt-7 pb-10 mb-10">
            @include('livewire.bag.bag_header')
            <div class="container mt-8">

                @if ($this->canbecancelled == true)
                    <div class="order-message mr-auto ml-auto">
                        <div class="icon-box d-inline-flex align-items-center">
                            <div class="icon-box-icon mb-0">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50"
                                     enable-background="new 0 0 50 50" xml:space="preserve">
                                <g>
                                    <path fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="bevel"
                                          stroke-miterlimit="10" d="
                                        M33.3,3.9c-2.7-1.1-5.6-1.8-8.7-1.8c-12.3,0-22.4,10-22.4,22.4c0,12.3,10,22.4,22.4,22.4c12.3,0,22.4-10,22.4-22.4
                                        c0-0.7,0-1.4-0.1-2.1"></path>
                                    <polyline fill="none" stroke-width="4" stroke-linecap="round"
                                              stroke-linejoin="bevel" stroke-miterlimit="10" points="
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
                        <strong>{{ date('d-M-Y', strtotime($items->first()->created_at)) }}</strong>
                    </div>

                    <div class="overview-item">
                        <span>Order number:</span>
                        <strong>{{ $items->first()->order_id }}</strong>
                    </div>

                    {{-- <div class="overview-item">
                        <span>Order type:</span>
                        <strong>{{ $items->first()->type }}</strong>
                    </div> --}}

                    <div class="overview-item">
                        <span>Items:</span>
                        <strong>{{ count($items) }}</strong>
                    </div>

                    <div class="overview-item">
                        <span>Weight:</span>
                        <strong>{{ $items->first()->order_weight }}kg</strong>
                    </div>

                    <div class="overview-item">
                        <span>Total:</span>
                        <strong>{{ Config::get('icrm.currency.icon') }}{{ number_format($items->first()->order_total, 2) }}</strong>
                    </div>

                    <div class="overview-item">
                        <span>Payment method:</span>
                        @if ($items->first()->order_method == 'COD')
                            <strong>Cash on delivery</strong>
                        @else
                            <strong>Prepaid</strong>
                        @endif
                    </div>

                    @if ($items->first()->type == 'Showcase At Home')

                    @else
                        @if (!empty($items->first()->exp_delivery_date) AND $this->items->whereIn('order_status', ['Cancelled', 'Delivered', 'Requested For Return', 'Return Request Accepted', 'Return Request Rejected', 'Returned'])->count() == 0)
                            <div class="overview-item">
                                <span>Expected Delivery:</span>
                                <strong>{{ date('d-M-Y', strtotime($items->first()->exp_delivery_date)) }}</strong>
                            </div>
                        @endif
                    @endif

                    {{-- @if (!empty($items->first()->order_awb ))
                        <div class="overview-item">
                            <span>Order Tracking ID:</span>
                            <strong>{{ $items->first()->order_awb }}</strong>
                        </div>
                    @endif --}}

                </div>


                <div class="order-actions">
                    <div class="float-left">
                        <a href="{{ route('myorders') }}" class="btn btn-icon-left btn-dark btn-rounded btn-md mb-4"><i
                                    class="d-icon-arrow-left"></i> My Orders</a>
                    </div>
                    <div class="float-right">
                        {{-- If the order is already canelled then dont show cancel button --}}
                        @if ($this->canbecancelled == true)
                            <a wire:click="cancelorder" wire:loading.remove
                               class="btn btn-icon-right btn-light btn-rounded btn-md mb-4 ml-3">Cancel Order<i
                                        class="fa fa-times-circle"></i>
                            </a>
                            <a wire:loading wire:target="cancelorder"
                               class="btn btn-icon-right btn-alert btn-rounded btn-md mb-4 ml-3">
                                Cancelling...<i class="fa fa-times-circle"></i>
                            </a>
                        @else
                            {{--claim reward point--}}
                            @if($this->is_first_order)
                                <a wire:click="reedemRewardPoint" wire:loading.remove
                                   class="btn btn-icon-right btn-light btn-rounded btn-md mb-4 ml-3">Claim Reward Point
                                    <i class="fa fa-star"></i>
                                </a>
                                {{--<span>Return or Exchange window will be closed</span>--}}
                            @endif
                            <a class="btn btn-icon-right btn-light btn-rounded btn-md mb-4 ml-3 btn-disabled"
                               title="Order cannot be cancelled!">Cancel Order<i class="fa fa-times-circle"></i></a>
                        @endif


                        {{-- <a wire:click="downloadinvoice" wire:loading.remove class="btn btn-icon-right btn-light btn-rounded btn-md mb-4">Download Invoice <i class="fa fa-cloud-download-alt"></i></a>
                        <a wire:loading wire:target="downloadinvoice" class="btn btn-icon-right btn-success btn-rounded btn-md mb-4">
                            Downloading Invoice...<i class="fa fa-cloud-download-alt"></i>
                        </a> --}}

                        <form  target="_blank" action="{{ route('downloadinvoice', ['id' => $this->orderid]) }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $this->orderid }}">
                            <button type="submit" class="btn btn-icon-right btn-light btn-rounded btn-md mb-4">Download
                                Invoice <i class="fa fa-cloud-download-alt"></i></button>
                        </form>

                    </div>
                </div>
                <br>

                <h2 class="title title-simple text-left pt-4 font-weight-bold text-uppercase">Order Details</h2>
                <div class="order-details" style="overflow-x:auto;">
                    <table class="order-details-table table-responsive">
                        <thead>
                        <tr class="summary-subtotal">
                            <td>
                                <h3 class="summary-subtitle">Image</h3>
                            </td>
                            <td>
                                <h3 class="summary-subtitle">Product</h3>
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

                                @php
                                    $orders = $items->groupBy('order_awb');
                                    $reward_points_sum = 0;
                                    $user_credits_sum = 0;
                                @endphp

                                @foreach ($orders as $order)

                                    @foreach ($order as $key => $item)
                                        @php
                                            $reward_points_sum += $item->used_reward_points;
                                            $user_credits_sum += $item->used_user_credits;
                                        @endphp

                                        @if ($key == 0)
                                            @if (!empty($item->order_awb))
                                                <tr>
                                                    <td>Logistic Provider: {{ $item->shipping_provider }}</td>
                                                    <td>Tracking Code: {{ $item->order_awb }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endif

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
                                                <a href="{{ route('product.slug', ['slug' => $item->product->slug, 'color' => $item->color]) }}"
                                                   target="_blank" style="color: blue;">
                                                    <img src="{{ Voyager::image($productimage) }}"
                                                         alt="{{ $item->product->name }}" style="max-height: 5em;">
                                                </a>
                                            </td>
                                            <td class="product-name name">
                                                <a href="{{ route('product.slug', ['slug' => $item->product->slug, 'color' => $item->color]) }}"
                                                   target="_blank" style="color: blue;">
                                                    {{ Str::limit($item->product->name, 50) }}
                                                </a>
                                                <br><span>Quantity: {{ $item->qty }}</span>

                                                @if (!empty($item->color) AND $item->color != 'NA')
                                                    <br><span>Color: {{ $item->color }}</span>
                                                @endif

                                                @if (!empty($item->size) AND $item->size != 'NA')
                                                    <br><span>Size: {{ $item->size }}</span>
                                                @endif


                                                @if (!empty($item->g_plus))
                                                    <br><span>G+: {{ $item->g_plus }}</span>
                                                @endif

                                                @if (!empty($item->cost_per_g))
                                                    <br>
                                                    <span>Cost per G+: {{ Config::get('icrm.currency.icon') }}{{ $item->cost_per_g }}/-</span>
                                                @endif

                                                @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                                    <br><span>Vendor: <a
                                                                href="{{ route('products.vendor', ['slug' => $item->vendor->id]) }}">{{ ucwords($item->vendor->brand_name) }}</a></span>
                                                @endif

                                                <br><span>Order type: {{ $item->type }}</span>

                                                @if (!empty($item->requirement_document))
                                                    <br><span>Custom Requirement: <a
                                                                href="{{ asset($item->requirement_document) }}"
                                                                style="color: blue">Download</a></span>
                                                @endif

                                                @if (!empty($item->customized_image))
                                                    <br><span>Customized image: <a
                                                                href="{{ asset($item->customized_image) }}"
                                                                target="_blank" style="color: blue">Download</a></span>
                                                @endif

                                                @if (!empty($item->original_file))
                                                    <br><span>Original file:
                                                    @foreach (collect(json_decode($item->original_file)) as $key => $file)
                                                            <a href="{{ $file }}" target="_blank" style="color: blue">Attachment {{ $key+1 }} @if($loop->last) @else
                                                                    ,
                                                                @endif</a>
                                                        @endforeach
                                                </span>
                                                @endif

                                                <br><span>Hsn: {{ $item->product->productsubcategory->hsn }}</span>
                                            </td>
                                            <td class="product-amount">
                                                @if ($item->order_status == 'New Order')
                                                    <strong>Order Placed</strong>
                                                @else
                                                    <strong>{{ $item->order_status }}</strong>
                                                @endif


                                                @if (!empty($item->order_substatus))
                                                    <br><span>{{ $item->order_substatus }}</span>
                                                @endif


                                                {{-- ['New Order', 'Scheduled For Pickup', 'Ready To Dispatch', 'Shipped'] --}}
                                                @if ($item->order_status == 'New Order' OR $item->order_status == 'Scheduled For Pickup' OR $item->order_status == 'Ready To Dispatch' OR $item->order_status == 'Shipped')
                                                    <br>
                                                    <span>Expected delivery by {{ date('d-M-Y', strtotime($items->first()->exp_delivery_date)) }}</span>
                                                @endif

                                            </td>
                                            <td class="product-amount">
                                                {{ $item->type }}
                                            </td>
                                            <td class="product-amount" style="text-align: center;">
                                                {{ $item->qty }}
                                            </td>
                                            <td class="product-amount">

                                                @if (Config::get('icrm.shipping_provider.shiprocket') == 1)
                                                    @if ($item->type == 'Regular')
                                                        @if (!empty($item->tracking_url))
                                                            <a href="{{ $item->tracking_url }}" target="_blank"
                                                               class="btn btn-sm btn-light">Track</a>
                                                        @else
                                                            <a title="Shipping not initiated yet" target="_blank"
                                                               class="btn btn-sm btn-light btn-disabled">Track</a>
                                                        @endif
                                                    @endif
                                                @endif

                                                @if (Config::get('icrm.order_lifecycle.return.feature') == 1)
                                                    @if ($item->order_status == 'Delivered' AND $item->type == 'Regular' AND !$item->is_return_window_closed)
                                                        @livewire('bag.returns', ['order' => $item], key($item->id))
                                                    @else
                                                        @if ($item->type == 'Regular')
                                                            <a title="{{ $item->is_return_window_closed ? 'Window has been closed' : 'Will be enabled once the order is delivered' }}"
                                                               class="btn btn-sm btn-light btn-disabled">Returns</a>
                                                        @endif
                                                        {{-- <br><small>Disabled until order gets delivered!</small> --}}
                                                    @endif
                                                @endif

                                            </td>
                                            <td class="product-amount">
                                                {{ Config::get('icrm.currency.icon') }}{{ number_format($item->price_sum, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach

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
                                <h4 class="summary-subtitle">Order value:</h4>
                            </td>
                            <td class="summary-subtotal-price"
                                style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ number_format($item->order_value, 2) }}</td>
                        </tr>

                        @if ($item->order_discount > 0)
                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Discount:</h4>
                                </td>
                                <td class="summary-subtotal-price"
                                    style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ number_format($item->order_discount, 2) }}</td>
                            </tr>
                        @endif


                        @if ($item->type == 'Showcase At Home')
                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Showroom At Home Refund:</h4>
                                </td>
                                <td class="summary-subtotal-price" style="text-align: left; color: red;">
                                    -{{ Config::get('icrm.currency.icon') }}{{ number_format($item->order_deliverycharges, 2) }}</td>
                            </tr>
                        @else
                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Shipping:</h4>
                                </td>
                                @if ($item->order_deliverycharges > 0)
                                    <td class="summary-subtotal-price" style="text-align: left; color: green;">
                                        +{{ Config::get('icrm.currency.icon') }}{{ number_format($item->order_deliverycharges, 2) }}</td>
                                @else
                                    <td class="summary-subtotal-price" style="text-align: left; color: green;">Free
                                        Shipping
                                    </td>
                                @endif

                            </tr>
                        @endif

                        @if($reward_points_sum > 0)
                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Reward points:</h4>
                                </td>
                                <td class="summary-subtotal-price"
                                    style="text-align: left;">-{{ Config::get('icrm.currency.icon') }}{{ number_format($reward_points_sum , 2) }}</td>
                            </tr>
                        @endif
                        @if($user_credits_sum > 0)
                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">Wallet Credits:</h4>
                                </td>
                                <td class="summary-subtotal-price"
                                    style="text-align: left;">-{{ Config::get('icrm.currency.icon') }}{{ number_format($user_credits_sum, 2) }}</td>
                            </tr>
                        @endif
                        <tr class="summary-subtotal">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <h4 class="summary-subtitle">Subtotal:</h4>
                            </td>
                            <td class="summary-subtotal-price"
                                style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ number_format($item->order_subtotal, 2) }}</td>
                        </tr>

                        @if ($item->order_tax > 0)
                            <tr class="summary-subtotal">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4 class="summary-subtitle">{{ Config::get('icrm.tax.name') }}:</h4>
                                </td>
                                <td class="summary-subtotal-price" style="text-align: left; color: green;">
                                    +{{ Config::get('icrm.currency.icon') }}{{ number_format($item->order_tax, 2) }}</td>
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
                                <p class="summary-total-price"
                                   style="text-align: left;">{{ Config::get('icrm.currency.icon') }}{{ number_format($item->order_total, 2) }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="title title-simple text-left pt-10 mb-2">Billing Address</h2>
                <div class="address-info pb-8 mb-6">

                    @if (!empty($items->first()->company_name))
                        <div class="email">
                            {{ $items->first()->company_name }}<br>
                            {{ $items->first()->gst_number }}
                        </div>
                    @endif

                    <p class="address-detail pb-2">
                        {{ $items->first()->dropoff_streetaddress1 }}<br>
                        {{ $items->first()->dropoff_streetaddress2 }}<br>
                        {{ $items->first()->dropoff_pincode }}, {{ $items->first()->dropoff_city }}
                        , {{ $items->first()->dropoff_state }}<br>
                        {{ $items->first()->dropoff_country }} <br>
                        {{ $items->first()->customer_email }} <br>
                        {{ $items->first()->customer_contact_number }} <br>
                    </p>
                </div>


            </div>
        </div>

    </main>
</div>

@section('meta-seo')
    <title>{{ Config::get('seo.ordercomplete.title') }} {{ request('id') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.ordercomplete.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.ordercomplete.description') }}">
@endsection


@if (!empty(setting('online-chat.cart_support')))
    <br>
    {!! setting('online-chat.cart_support') !!}
@endif
