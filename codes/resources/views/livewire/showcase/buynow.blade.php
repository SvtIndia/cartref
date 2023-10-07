<div>
    <main class="main cart">
        <div class="page-content pt-7 pb-10">

            <div class="step-by pr-4 pl-4">
                <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'showcase.ordercomplete') active @endif"><a href="{{ route('showcase.ordercomplete', ['id' => $this->orderid]) }}">Showcase Order</a></h3>
                <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'showcase.buynow') active @endif"><a href="{{ route('showcase.buynow', ['id' => $this->orderid]) }}">Buy now</a></h3>
            </div>


            <div class="container mt-7 mb-2">
                <div class="row">
                    <div class="col-lg-8 col-md-12 pr-lg-4">

                        @if (count($buyshowcases) > 0)
                            <table class="shop-table cart-table">
                                <thead>
                                    <tr>
                                        <th><span>Product</span></th>
                                        <th><span>Details</span></th>
                                        <th><span>Weight</span></th>
                                        <th><span>Price</span></th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buyshowcases as $showcase)
                                        <tr>
                                            <td class="product-thumbnail">
                                                <figure>
                                                    @php
                                                        $productimage = App\Productcolor::where('product_id', $showcase->product_id)->where('color', $showcase->color)->first();

                                                        if(empty($productimage->main_image))
                                                        {
                                                            $productimage = $showcase->product->image;
                                                        }else{
                                                            $productimage = $productimage->main_image;
                                                        }
                                                    @endphp
                                                    <a href="{{ route('product.slug', ['slug' => $showcase->product->slug, 'color' => $showcase->color]) }}">
                                                        <img src="{{ Voyager::image($productimage) }}" width="100" height="100"
                                                            alt="{{ $showcase->product->name }} in {{ $showcase->color }} color">
                                                    </a>
                                                </figure>
                                            </td>
                                            <td class="product-name">
                                                <div class="product-name-section">
                                                    <a href="{{ route('product.slug', ['slug' => $showcase->product->slug, 'color' => $showcase->color]) }}">{{ $showcase->product->name }}</a>
                                                    <br><span>Vendor: {{ $showcase->product->vendor->name }}</span>
                                                    <br><span>Brand: {{ $showcase->product->brand_id }}</span>
                                                    <br><span>Color: {{ $showcase->color }}</span>
                                                    <br><span>Size: {{ $showcase->size }}</span>

                                                    <br><span>Order type: {{ $showcase->type }}</span>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount">{{ $showcase->weight }}kg</span>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount">{{ Config::get('icrm.currency.icon') }} {{ $showcase->product->offer_price }}</span>
                                            </td>
                                            <td class="product-close">
                                                <a wire:click="removeShowcaseBag('{{ $showcase->id }}')" class="product-remove" title="Remove this product">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="cart-actionss mb-6 pt-4">
                                <a href="{{ route('showcase.ordercomplete', ['id' => $this->orderid]) }}" class="btn btn-dark btn-md btn-rounded btn-icon-left mr-4 mb-4">
                                    <i class="d-icon-arrow-left"></i>
                                    Go to showcase order
                                </a>
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
                                    <h1 class="display-5 fw-bold text-dark">Your showcase bag is empty</h1>
                                    <p class="fs-4 text-center">Go bag to your showcase order and move your favourite products to bag</p>
                                    <a href="{{ route('showcase.ordercomplete', ['id' => $this->orderid]) }}" class="btn btn-primary btn-lg" type="button">View Complete Order</a>
                                </div>
                            </div>
                        @endif


                    </div>
                    <aside class="col-lg-4 sticky-sidebar-wrapper">
                        <div class="sticky-sidebar" data-sticky-options="{'bottom': 20}">
                            <div class="summary mb-4">
                                <h3 class="summary-title text-left">Totals</h3>
                                <table class="shipping">
                                    <div class="card accordion">
                                        <p>If you have a coupon code, please apply it below.</p>
                                        <div class="check-coupon-box d-flex">
                                            <input type="text"
                                                   class="input-text form-control text-grey ls-m mr-4 mb-4"
                                                   wire:model.debounce.5s="couponcode" placeholder="Coupon code">
                                            <button type="button" wire:click="applycoupon"
                                                    class="btn btn-dark btn-rounded btn-outline mb-4">Apply
                                                Coupon
                                            </button>
                                        </div>

                                        <div class="alert alert-light alert-primary alert-icon mb-4 card-header">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span class="text-body">Available offers</span>
                                            <a href="#alert-body2" class="text-primary">Click here to view all
                                                coupons</a>
                                        </div>

                                        <div class="alert-body collapsed" id="alert-body2">
                                            @foreach($this->coupons as $coupon)
                                                <div>
                                                    <div class="available-coupons">
                                                        <div class="coupon-body">
                                                            <div style="width: 50%;">
                                                                <span class="code">{{ $coupon->code }}</span>
                                                            </div>
                                                            @if($coupon->is_applicable)
                                                                <div class="info"
                                                                     style="justify-content: space-between;">
                                                                    <span class="applicable">{{ Config::get('icrm.currency.icon') }}{{ $coupon->applicable_discount }} Applicable</span>
                                                                    @if(Session::get('showcase_appliedcouponcode') == $coupon->code)
                                                                        <span class="applicable">Applied</span>
                                                                    @else
                                                                        <button type="button"
                                                                                class="btn btn-dark btn-rounded btn-outline apply-btn"
                                                                                wire:click="applyDirectCoupon('{{$coupon->code}}')">
                                                                            Apply
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="info">
                                                                    <span class="not-applicable">Not Applicable</span>
                                                                    <span class="not-applicable">{{ $coupon->not_applicable_error }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span>
                                                                {{ $coupon->description  }} minimum order of {{ Config::get('icrm.currency.icon') }}{{ $coupon->min_order_value  }}
                                                            </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Order Value</h4>
                                        </td>
                                        <td>
                                            <p class="summary-subtotal-price">{{ Config::get('icrm.currency.icon') }}{{ number_format($ordervalue, 2) }}</p>
                                        </td>
                                    </tr>


                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Showcase At Home Charges Refund</h4>
                                        </td>
                                        <td>
                                            <p class="summary-subtotal-price" style="color: red !important;">-{{ Config::get('icrm.currency.icon') }}{{ number_format($showcaserefund, 2) }}</p>
                                        </td>
                                    </tr>

                                    @if ($this->discount > 0)
                                        <tr class="discount">
                                            <td class="product-name">Discount
                                                ({{ Session::get('showcase_appliedcouponcode') }} coupon applied) <span
                                                        class="d-icon-cancel" title="Remove coupon"
                                                        style="color: blue;" wire:click="removecoupon"></span></td>
                                            <td class="product-total text-body">
                                                -{{ Config::get('icrm.currency.icon') }} {{ $this->discount }}</td>
                                        </tr>
                                    @endif
                                    @if($this->redeemedRewardPoints > 0)
                                        <tr>
                                            <td class="product-name">Reward Points</td>
                                            <td class="product-total text-body">
                                                -{{ Config::get('icrm.currency.icon') }}{{ number_format($this->redeemedRewardPoints, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($this->redeemedCredits > 0)
                                        <tr>
                                            <td class="product-name">Wallet Credits</td>
                                            <td class="product-total text-body">
                                                -{{ Config::get('icrm.currency.icon') }}{{ number_format($this->redeemedCredits, 2) }}</td>
                                        </tr>
                                    @endif

                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Subtotal</h4>
                                        </td>
                                        <td>
                                            <p class="summary-subtotal-price">{{ Config::get('icrm.currency.icon') }}{{ number_format($subtotal, 2) }}</p>
                                        </td>
                                    </tr>


                                    @if ($tax > 0)
                                        <tr class="summary-subtotal">
                                            <td>
                                                <h4 class="summary-subtitle">GST</h4>
                                            </td>
                                            <td>
                                                <p class="summary-subtotal-price" style="color: green !important;">+{{ Config::get('icrm.currency.icon') }}{{ number_format($tax, 2) }}</p>
                                            </td>
                                        </tr>
                                    @endif


                                </table>
                                <table class="total">
                                    <tr class="summary-subtotal">
                                        <td>
                                            <h4 class="summary-subtitle">Total</h4>
                                        </td>
                                        <td>
                                            <p class="summary-total-price ls-s">{{ Config::get('icrm.currency.icon') }} {{ number_format($total, 2) }}</p>
                                        </td>
                                    </tr>
                                    @if($this->redeemedRewardPoints > 0)
                                        <tr>
                                            <td class="product-name">Reward Points</td>
                                            <td class="product-total text-body">
                                                -{{ Config::get('icrm.currency.icon') }}{{ number_format($this->redeemedRewardPoints, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($this->redeemedCredits > 0)
                                        <tr>
                                            <td class="product-name">Wallet Credits</td>
                                            <td class="product-total text-body">
                                                -{{ Config::get('icrm.currency.icon') }}{{ number_format($this->redeemedCredits, 2) }}</td>
                                        </tr>
                                    @endif
                                </table>
                                @if ($this->redeemedRewardPoints > 0 || (auth()->user()->reward_points > 0 && $this->ordervalue >= 1500))
                                    <div class="form-checkbox mt-4 mb-5" wire:click="redeemRewardPoints">
                                        <input type="checkbox" class="custom-checkbox" disabled
                                               @if($this->redeemedRewardPoints > 0) checked @endif />
                                        <label class="form-control-label" for="cod">
                                            Use your reward points up to 20%.
                                            <font style="color:green;">({{ Config::get('icrm.currency.icon') }} {{ number_format(auth()->user()->reward_points * 0.20, 2) }}
                                                )</font>
                                        </label>
                                    </div>
                                @endif
                                @if ($this->redeemedCredits > 0 || (auth()->user()->credits > 0))
                                    <div class="form-checkbox mt-4 mb-5" wire:click="redeemCredits">
                                        <input type="checkbox" class="custom-checkbox" disabled
                                               @if($this->redeemedCredits > 0) checked @endif />
                                        <label class="form-control-label" for="cod">
                                            Use your wallet credits
                                            <font style="color:green;">({{ Config::get('icrm.currency.icon') }} {{ number_format(auth()->user()->credits) }}
                                                )</font>
                                        </label>
                                    </div>
                                @endif
                                @if (auth()->user()->hasRole(['Delivery Boy', 'Delivery Head', 'admin', 'Client']))
                                    <div class="form-checkbox mt-4 mb-5" wire:click="scodneeded">
                                        <input type="checkbox" class="custom-checkbox" disabled @if(Session::get('showcasebagordermethod') == 'cod') checked @endif />
                                        <label class="form-control-label" for="cod">
                                            I have received cash on delivery <span class="fa fa-money-bill-alt"></span>
                                        </label>
                                    </div>
                                @endif

                                <div class="form-checkbox mt-4 mb-5" wire:click="sacceptterms">
                                    <input type="checkbox" class="custom-checkbox" required="" @if(Session::get('showcasebagacceptterms') == true) checked @endif/>
                                    <label class="form-control-label" for="terms-condition">
                                        I have read and agree to the <a href="/page/terms-and-conditions" style="color: blue;">terms and conditions
                                        </a><span class="required">*</span>
                                    </label>
                                </div>

                                @if (Session::get('showcasebagordermethod') == 'cod')

                                        <div>
                                            <button type="submit" wire:click="placeorder" wire:loading.attr="disabled" class="btn btn-dark btn-rounded btn-checkout btn-block"
                                                @if($this->disablebtn == true) disabled="disabled" @endif
                                                {{-- @if(Session::get('ordermethod') != 'cod') disabled="disabled" @endif --}}
                                                >
                                                Place Cash On Delivery Order
                                            </button>
                                        </div>

                                    @else

                                        <div>
                                            <button type="submit" wire:loading.attr="disabled" wire:click="placeorder" class="btn btn-dark btn-rounded btn-checkout btn-block" id="rzp-button1" @if($this->disablebtn == true) disabled="disabled" @endif>
                                                Make Payment
                                            </button>

                                        </div>

                                    @endif

                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

    </main>
</div>


@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    Livewire.on('srazorPay', function() {

        var full_name = "{{ $this->rname }}";
        var email = "{{ $this->remail }}";
        var contact_number = "{{ $this->rphone }}";
        var amount = {{ number_format($total, 2) }};
        var total_amount = amount * 100;
        var showcaseorderid = {{ request('id') }};

        // var consent = $("#two-step:checkbox:checked").length;



        // /<span class="required">*</span><span class="required">*</span> validate form fields <span class="required">*</span>/

        if(full_name == ""){
            alert('Please Enter Full Name');
            return false;
        }


        if(email == ""){
            alert('Please Enter Email Address');
            return false;
        }

        // if(contact_number == ""){
        //     alert('Please Enter Contact Number');
        //     return false;
        // }

        // if(consent == 0)
        // {
        //     alert('Please Agree To The Terms and Conditions');
        //     return false;
        // }

        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}", // Enter the Key ID generated from the Dashboard
            "amount": total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
            "currency": "INR",
            "name": "{{ env('APP_NAME') }}",
            "description": "Payment",
            "image": "{{ Voyager::image(setting('razorpay.logo')) }}",
            "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "handler": function (response){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:"{{ route('showcase.purchase.paynow') }}",
                    data:{
                        razorpay_payment_id:response.razorpay_payment_id,
                        amount:total_amount,
                        full_name:full_name,
                        email:email,
                        contact_number:contact_number,
                        showcaseorderid:showcaseorderid
                    },
                    success:function(data){
                        $('.success-message').text(data.success);
                        $('.success-alert').fadeIn('slow', function(){
                            $('.success-alert').delay(5000).fadeOut();
                        });
                        window.location.href = "/my-orders/all";
                    }
                });
            },
            "prefill": {
                "name": full_name,
                "email": email,
                "contact": contact_number,
            },
            "notes": {
                "address": "test test"
            },
            "theme": {
                "color": "#0A0757"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    });
</script>
@endpush
