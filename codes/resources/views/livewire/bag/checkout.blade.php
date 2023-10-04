<div>
    <main class="main checkout">
        <div class="page-content pt-7 pb-10 mb-10">
            @include('livewire.bag.bag_header')
            <div class="container mt-7">

                <form wire:submit.prevent="placeorder">
                    {{-- wire:submit.prevent="placeorder" --}}
                    <div class="row">
                        <div class="col-lg-7 mb-6 mb-lg-0 pr-lg-4">
                            <h3 class="title title-simple text-left text-uppercase">Billing Details</h3>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Full Name <span class="required">*</span></label>
                                    @error('fullname') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('fullname') error @enderror"
                                           wire:model.debounce.1s="name" required=""/>
                                </div>
                                <div class="col-xs-6">
                                    <label>Phone <span class="required">*</span></label>
                                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('phone') error @enderror"
                                           wire:model.defer="phone" required=""/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Company Name
                                        @if (Config::get('icrm.auth.fields.companyinfo') != true)
                                            (Optional)
                                        @endif
                                    </label>
                                    @error('companyname') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('companyname') error @enderror"
                                           wire:model.debounce.1s="companyname"/>
                                </div>
                                <div class="col-xs-6">
                                    <label>GST
                                        @if (Config::get('icrm.auth.fields.companyinfo') != true)
                                            (Optional)
                                        @endif
                                    </label>
                                    @error('gst') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('gst') error @enderror"
                                           wire:model.defer="gst"/>
                                </div>
                            </div>

                            <label>Country / Region <span class="required">*</span></label>
                            <div class="select-box">
                                @error('country') <span class="error">{{ $message }}</span> @enderror
                                <select wire:model.debounce.1s="country"
                                        class="form-control @error('country') error @enderror">
                                    <option value="">Select country</option>
                                    <option value="India">India</option>
                                </select>
                            </div>


                            <label>Street Address 1 <span class="required">*</span></label>
                            @error('address1') <span class="error">{{ $message }}</span> @enderror
                            <input type="text" class="form-control @error('address1') error @enderror"
                                   wire:model.debounce.1s="address1"
                                   placeholder="House number and street name"/>

                            <label>Street Address 2 <span class="required">*</span></label>
                            @error('address2') <span class="error">{{ $message }}</span> @enderror
                            <input type="text" class="form-control @error('address2') error @enderror"
                                   wire:model.debounce.1s="address2"
                                   placeholder="Apartment, suite, unit, landmark, etc."/>

                            <div class="row">
                                <div class="col-xs-6">
                                    <label>ZIP <span class="required">*</span></label>
                                    @error('deliverypincode') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text"
                                           class="form-control @error('deliverypincode') error @enderror btn-disabled"
                                           wire:model.debounce.1s="deliverypincode" required="" readonly disabled/>
                                </div>
                                <div class="col-xs-6">
                                    <label>Town / City <span class="required">*</span></label>
                                    @error('city') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('city') error @enderror btn-disabled"
                                           wire:model.defer="city" required="" readonly disabled/>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xs-6">
                                    <label>State <span class="required">*</span></label>
                                    @error('state') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('state') error @enderror btn-disabled"
                                           wire:model.defer="state" required="" readonly disabled/>
                                </div>
                                <div class="col-xs-6">
                                    <label>Alternate Phone (Optional)</label>
                                    @error('altphone') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('altphone') error @enderror"
                                           wire:model.debounce.1s="altphone"/>
                                </div>
                            </div>
                            <label>Email Address <span class="required">*</span></label>
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                            <input type="text" class="form-control @error('email') error @enderror"
                                   wire:model.debounce.1s="email" required=""/>

                            {{-- <div class="form-checkbox mb-6">
                                <input type="checkbox" class="custom-checkbox" id="create-account"
                                    name="create-account">
                                <label class="form-control-label ls-s" for="create-account">Create my account</label>
                            </div> --}}
                            {{-- <div class="form-checkbox mb-6">
                                <input type="checkbox" class="custom-checkbox" id="different-address"
                                    name="different-address">
                                <label class="form-control-label ls-s" for="different-address">Ship to a different
                                    address?</label>
                            </div> --}}
                            {{-- <h2 class="title title-simple text-uppercase text-left">Additional Information</h2>
                            <label>Order Notes (Optional)</label>
                            <textarea class="form-control pb-2 pt-2 mb-0" cols="30" rows="5"
                                placeholder="Notes about your order, e.g. special notes for delivery"></textarea> --}}
                        </div>
                        <aside class="col-lg-5 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar mt-1" data-sticky-options="{'bottom': 50}">
                                <div class="summary pt-5">
                                    <h3 class="title title-simple text-left text-uppercase">Your Order
                                        @if (Session::has('deliveryavailable'))
                                            <br><span
                                                    style="color: green;">{{ Session::get('deliveryavailable') }}</span>
                                        @endif
                                    </h3>

                                    <table class="order-table">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($carts as $cart)
                                            <tr>
                                                <td class="product-name">{{ Str::limit($cart->name, 35, '...') }}
                                                    <span class="product-quantity">×&nbsp;{{ $cart->quantity }}</span>
                                                </td>
                                                <td class="product-total text-body">{{ Config::get('icrm.currency.icon') }} {{ number_format($cart->getPriceSumWithConditions(), 2) }}</td>
                                            </tr>
                                        @endforeach

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
                                                        <p class="available-coupons">
                                                            <span>
                                                                @if($coupon->is_applicable)
                                                                    <span style="color: green;text-align: end;">{{ Config::get('icrm.currency.icon') }}{{ $coupon->applicable_discount }} </span>
                                                                    Applicable on
                                                                @endif
                                                                {{ $coupon->code  }}
                                                            </span><br>
                                                            <span>
                                                                {{ $coupon->description  }} minimum order of {{ Config::get('icrm.currency.icon') }}{{ $coupon->min_order_value  }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <tr class="summary-subtotal">
                                        <tr>
                                            <td class="summary-subtitle">Order Value</td>
                                            <td class="summary-subtitle text-body">{{ Config::get('icrm.currency.icon') }}{{ number_format($ordervalue, 2) }}</td>
                                        </tr>
                                        @if ($this->discount > 0)
                                            <tr class="discount">
                                                <td class="product-name">Discount
                                                    ({{ Session::get('appliedcouponcode') }} coupon applied) <span
                                                            class="d-icon-cancel" title="Remove coupon"
                                                            style="color: blue;" wire:click="removecoupon"></span></td>
                                                <td class="product-total text-body">
                                                    -{{ Config::get('icrm.currency.icon') }} {{ $this->discount }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="product-name">Shipping</td>

                                            @if(empty($this->city))
                                                <td class="product-total text-body" style="color: red !important;">Not
                                                    available
                                                </td>
                                            @elseif ($this->appliedShipping > 0)
                                                <td class="product-total text-body" style="color: green !important;">
                                                    +{{ config::get('icrm.currency.icon') }} {{ number_format($this->appliedShipping, 2) }}</td>
                                            @elseif ($this->appliedShipping == 0 && $this->shipping > 0)
                                                <td class="product-total text-body" style="color: green !important;">
                                                    +{{ config::get('icrm.currency.icon') }}
                                                    <del>{{ number_format($this->shipping, 2) }}</del>
                                                </td>
                                            @else
                                                <td class="product-total text-body" style="color: green !important;">
                                                    Free Shipping
                                                </td>
                                            @endif

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
                                        <tr>
                                            <td class="product-name">Subtotal</td>
                                            <td class="product-total text-body">{{ Config::get('icrm.currency.icon') }}{{ number_format($fsubtotal, 2) }}</td>
                                        </tr>

                                        @if (Config::get('icrm.tax.type') == 'fixed')
                                            @if ($this->tax > 0)
                                                <tr>
                                                    <td class="product-name">{{ Config::get('icrm.tax.name') }} <span
                                                                class="product-quantity">({{ Config::get('icrm.tax.fixedtax.perc') }}%)</span>
                                                    </td>
                                                    <td class="product-total text-body"
                                                        style="color: green !important;">
                                                        +{{ config::get('icrm.currency.icon') }} {{ number_format($this->tax, 2) }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="product-name" style="color: green">Inclusive of taxes
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @endif
                                                @endif
                                                </tr>
                                                <tr class="summary-subtotal">
                                                    <td class="pb-0">
                                                        <h4 class="summary-subtitle">Order Total</h4>
                                                    </td>
                                                    <td class=" pt-0 pb-0">
                                                        <p class="summary-total-price ls-s text-primary">{{ Config::get('icrm.currency.icon') }}{{ number_format($ftotal, 2) }}</p>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                    @if ($this->redeemedRewardPoints > 0 || (auth()->user()->reward_points > 0 && $ordervalue >= 1500))
                                        <div class="form-checkbox mt-4 mb-5" wire:click="redeemRewardPoints">
                                            <input type="checkbox" class="custom-checkbox" disabled
                                                   @if($this->redeemedRewardPoints > 0) checked @endif />
                                            <label class="form-control-label" for="cod">
                                                Use your reward points up to 20%.
                                                <font style="color:green;">({{ Config::get('icrm.currency.icon') }} {{ number_format(auth()->user()->reward_points * 0.20, 2) }})</font>
                                            </label>
                                        </div>
                                    @endif
                                    @if ($this->redeemedCredits > 0 || (auth()->user()->credits > 0))
                                        <div class="form-checkbox mt-4 mb-5" wire:click="redeemCredits">
                                            <input type="checkbox" class="custom-checkbox" disabled
                                                   @if($this->redeemedCredits > 0) checked @endif />
                                            <label class="form-control-label" for="cod">
                                                Use your wallet credits
                                                ({{ Config::get('icrm.currency.icon') }} {{ number_format(auth()->user()->credits) }}
                                                )
                                            </label>
                                        </div>
                                    @endif
                                    @if (Config::get('icrm.order_methods.cod') == 1)
                                        @if($ftotal > 0 && $ftotal < 1900)
                                            @if ($this->cod == true)
                                                <div class="form-checkbox mt-4 mb-5" wire:click="codneeded">
                                                    <input type="checkbox" class="custom-checkbox" disabled
                                                           @if(Session::get('ordermethod') == 'cod') checked @endif />
                                                    <label class="form-control-label" for="cod">
                                                        I would like to pay cash on delivery. <span
                                                                class="fa fa-money-bill-alt"></span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                    <div class="form-checkbox mt-4 mb-5" wire:click="acceptterms">
                                        <input type="checkbox" class="custom-checkbox" required=""
                                               @if(Session::get('acceptterms') == true) checked @endif/>
                                        <label class="form-control-label" for="terms-condition">
                                            I have read and agree to the website <a href="/page/terms-and-conditions"
                                                                                    style="color: blue">terms and
                                                conditions
                                            </a><span class="required">*</span>
                                        </label>
                                    </div>

                                    @if ($ftotal <= 0 && $this->redeemedCredits > 0)
                                        <div>
                                            <button type="submit" wire:loading.remove wire:model="disablebtn"
                                                    wire:loading.attr="disabled"
                                                    class="btn btn-dark btn-rounded btn-order"
                                                    @if($this->disablebtn == true) disabled="disabled" @endif
                                                    {{-- @if(Session::get('ordermethod') != 'cod') disabled="disabled" @endif --}}
                                            >
                                                Place Order
                                            </button>

                                            <button wire:loading wire:target="disablebtn"
                                                    class="btn btn-dark btn-rounded btn-order">
                                                Processing Order...
                                            </button>

                                        </div>

                                    @elseif (Session::get('ordermethod') == 'cod')
                                        <div>
                                            <button type="submit" wire:loading.remove wire:model="disablebtn"
                                                    wire:loading.attr="disabled"
                                                    class="btn btn-dark btn-rounded btn-order"
                                                    @if($this->disablebtn == true) disabled="disabled" @endif
                                                    {{-- @if(Session::get('ordermethod') != 'cod') disabled="disabled" @endif --}}
                                            >
                                                Place Cash On Delivery Order
                                            </button>

                                            <button wire:loading wire:target="disablebtn"
                                                    class="btn btn-dark btn-rounded btn-order">
                                                Processing Cash On Delivery Order...
                                            </button>

                                        </div>
                                    @else

                                        <div>
                                            <button type="submit" wire:loading.remove wire:loading.attr="disabled"
                                                    wire:model="disablebtn" class="btn btn-dark btn-rounded btn-order"
                                                    id="rzp-button1"
                                                    @if($this->disablebtn == true) disabled="disabled" @endif>
                                                Make Payment
                                            </button>

                                            <button wire:loading.delay.long wire:target="disablebtn"
                                                    wire:loading.attr="disabled"
                                                    class="btn btn-dark btn-rounded btn-order">
                                                Processing Payment...
                                            </button>
                                        </div>

                                    @endif

                                    @if($this->disablebtn == true)
                                        @if(empty($this->city))
                                            <small class="outofstock">Delivery not available in your area.</small>
                                        @elseif(Session::get('acceptterms') == true)
                                            <small class="outofstock">Please fill out all the required fields.</small>
                                        @elseif(Session::get('acceptterms') == false)
                                            <small class="outofstock">Agree terms and conditions.</small>
                                        @endif
                                    @endif

                                    @if (Session::has('validationfailed'))
                                        <span class="error">
                                            {{ Session::get('validationfailed') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </aside>
                    </div>
                </form>
            </div>
        </div>

    </main>
</div>


@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        Livewire.on('razorPay', function () {


            var full_name = "{{ $this->name }}";
            var email = "{{ $this->email }}";
            var contact_number = "{{ $this->phone }}";
            // var amount = {{ str_replace(',', '', number_format($this->ftotal, 0)) }};
            // alert({{ number_format($this->ftotal, 0) }});
            var amount = {{ str_replace(',', '', $this->ftotal) }};
            // alert(amount);
            var total_amount = Number(amount).toFixed(2) * 100;
            var redeemedRewardPoints = {{ $this->redeemedRewardPoints ?? 0 }};
            var redeemedCredits = {{ $this->redeemedCredits ?? 0 }};
            // alert(total_amount);
            // return false;
            // var consent = $("#two-step:checkbox:checked").length;


            // /<span class="required">*</span><span class="required">*</span> validate form fields <span class="required">*</span>/

            if (full_name == "") {
                alert('Please Enter Full Name');
                return false;
            }


            if (email == "") {
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
            console.log(total_amount);
            var options = {
                "key": "{{ env('RAZORPAY_KEY') }}", // Enter the Key ID generated from the Dashboard
                "amount": total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
                "currency": "INR",
                "name": "{{ env('APP_NAME') }}",
                "description": "Payment",
                "image": "{{ Voyager::image(setting('razorpay.logo')) }}",
                "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('bag.paynow') }}",
                        data: {
                            razorpay_payment_id: response.razorpay_payment_id,
                            amount: total_amount,
                            full_name: full_name,
                            email: email,
                            contact_number: contact_number,
                            redeemed_reward_points: redeemedRewardPoints,
                            redeemed_credits: redeemedCredits,
                        },
                        success: function (data) {
                            $('.success-message').text(data.success);
                            $('.success-alert').fadeIn('slow', function () {
                                $('.success-alert').delay(5000).fadeOut();
                            });
                            window.location.href = "/my-orders/all";
                            // url:"{{ route('bag.paynow') }}",
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
                    "color": "{{ setting('razorpay.color') }}"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        });
    </script>
@endpush


@if (!empty(setting('online-chat.cart_support')))
    <br>
    {!! setting('online-chat.cart_support') !!}
@endif
