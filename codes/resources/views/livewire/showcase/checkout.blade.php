<div>
    <main class="main checkout">
        <div class="page-content pt-7 pb-10 mb-10">
            @include('livewire.showcase.bag_header')
            <div class="container mt-7">
                {{-- <div class="card accordion">
                    <div class="alert alert-light alert-primary alert-icon mb-4 card-header">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="text-body">Have a cou  pon?</span>
                        <a href="#alert-body2" class="text-primary">Click here to enter your code</a>
                    </div>
                    <div class="alert-body collapsed" id="alert-body2">
                        <p>If you have a coupon code, please apply it below.</p>
                        <div class="check-coupon-box d-flex">
                            <form wire:submit.prevent="applycoupon">
                                <input type="text"
                                    class="input-text form-control text-grey ls-m mr-4 mb-4"
                                    wire:model.debounce.1s="couponcode" placeholder="Coupon code">
                                <button type="submit" class="btn btn-dark btn-rounded btn-outline mb-4">Apply
                                    Coupon</button>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <form wire:submit.prevent="placeorder">
                    {{-- wire:submit.prevent="placeorder" --}}
                    <div class="row">
                        <div class="checkout-form col-lg-7 mb-6 mb-lg-0 pr-lg-4">
                            <h3 class="title title-simple text-left text-uppercase">Billing Details</h3>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Full Name <span class="required">*</span></label>
                                    @error('fullname') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('fullname') error @enderror" wire:model.debounce.1s="name" required="" />
                                </div>
                                <div class="col-xs-6">
                                    <label>Phone <span class="required">*</span></label>
                                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('phone') error @enderror" wire:model.defer="phone" required="" />
                                </div>
                            </div>
{{--                            <div class="row">--}}
{{--                                <div class="col-xs-6">--}}
{{--                                    <label>Company Name (Optional)</label>--}}
{{--                                    @error('companyname') <span class="error">{{ $message }}</span> @enderror--}}
{{--                                    <input type="text" class="form-control @error('companyname') error @enderror" wire:model.debounce.1s="companyname" />--}}
{{--                                </div>--}}
{{--                                <div class="col-xs-6">--}}
{{--                                    <label>GST (Optional)</label>--}}
{{--                                    @error('gst') <span class="error">{{ $message }}</span> @enderror--}}
{{--                                    <input type="text" class="form-control @error('gst') error @enderror" wire:model.defer="gst"  />--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <label>Country / Region <span class="required">*</span></label>
                            <div class="select-box">
                                @error('country') <span class="error">{{ $message }}</span> @enderror
                                <select wire:model.debounce.1s="country" class="form-control @error('country') error @enderror">
                                    <option value="">Select country</option>
                                    <option value="India">India</option>
                                </select>
                            </div>


                            <label>Street Address 1 <span class="required">*</span></label>
                            @error('address1') <span class="error">{{ $message }}</span> @enderror
                            <input type="text" class="form-control @error('address1') error @enderror" wire:model.debounce.1s="address1"
                                placeholder="House number and street name" />

                            <label>Street Address 2 <span class="required">*</span></label>
                            @error('address2') <span class="error">{{ $message }}</span> @enderror
                            <input type="text" class="form-control @error('address2') error @enderror" wire:model.debounce.1s="address2"
                                placeholder="Apartment, suite, unit, landmark, etc." />

                            <div class="row">
                                <div class="col-xs-6">
                                    <label>ZIP <span class="required">*</span></label>
                                    @error('deliverypincode') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('deliverypincode') error @enderror" wire:model.debounce.1s="deliverypincode" required="" readonly disabled/>
                                </div>
                                <div class="col-xs-6">
                                    <label>Town / City <span class="required">*</span></label>
                                    @error('city') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('city') error @enderror" wire:model.debounce.1s="city" required="" readonly disabled/>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xs-6">
                                    <label>State <span class="required">*</span></label>
                                    @error('state') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('state') error @enderror" wire:model.debounce.1s="state" required="" readonly disabled/>
                                </div>
                                <div class="col-xs-6">
                                    <label>Alternate Phone (Optional)</label>
                                    @error('altphone') <span class="error">{{ $message }}</span> @enderror
                                    <input type="text" class="form-control @error('altphone') error @enderror" wire:model.debounce.1s="altphone" />
                                </div>
                            </div>
                            <label>Email Address <span class="required">*</span></label>
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                            <input type="text" class="form-control @error('email') error @enderror" wire:model.debounce.1s="email" required="" />

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
                                        @if (Session::has('sdeliveryavailable'))
                                            <br><span>{{ Session::get('sdeliveryavailable') }}</span>
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
                                                    <td class="product-name">{{ $cart->name }} <span
                                                            class="product-quantity">×&nbsp;{{ $cart->quantity }}</span></td>
                                                    <td class="product-total text-body">{{ Config::get('icrm.currency.icon') }} {{ number_format($cart->getPriceSumWithConditions(), 2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="summary-subtotal">
                                                <td>
                                                    <h4 class="summary-subtitle">No. of Items</h4>
                                                </td>
                                                <td>
                                                    <p class="summary-subtotal-price">{{ count($carts) }}/{{ Config::get('icrm.showcase_at_home.order_limit') }}</p>
                                                </td>
                                            </tr>
                                            <tr class="summary-subtotal">
                                                <tr>
                                                    <td class="summary-subtitle">
                                                        <span>Cartref's Convenience Charges</span><br>
                                                        <small>(Refundable if you purchase any product)</small>
                                                    </td>
                                                    <td class="summary-subtitle text-body">{{ Config::get('icrm.currency.icon') }}{{ number_format($fsubtotal, 2) }}</td>
                                                </tr>
                                                {{-- <tr>
                                                    <td class="product-name">Subtotal</td>
                                                    <td class="product-total text-body">{{ Config::get('icrm.currency.icon') }}{{ number_format($fsubtotal, 2) }}</td>
                                                </tr> --}}
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

                                    <div class="form-checkbox mt-4 mb-5" wire:click="acceptterms">
                                        <input type="checkbox" class="custom-checkbox" required="" @if(Session::get('acceptterms') == true) checked @endif/>
                                        <label class="form-control-label" for="terms-condition">
                                            I have read and agree to the website <a href="/page/terms-and-conditions">terms and conditions
                                            </a><span class="required">*</span>
                                        </label>
                                    </div>

                                    <div>
                                        <button type="submit" wire:loading.remove wire:loading.attr="disabled" wire:model="disablebtn" class="btn btn-dark btn-rounded btn-order" id="rzp-button1" @if($this->disablebtn == true) disabled="disabled" @endif>
                                            {{ $ftotal > 0 ? 'Make Payment' : 'Place Order'  }}
                                        </button>

                                        <button wire:loading.delay.long wire:target="disablebtn" wire:loading.attr="disabled" class="btn btn-dark btn-rounded btn-order">
                                            Processing Payment...
                                        </button>
                                    </div>

                                    @if($this->disablebtn == true)
                                        @if(Session::get('acceptterms') == true)
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
    Livewire.on('razorPay', function() {


        var full_name = "{{ $this->name }}";
        var email = "{{ $this->email }}";
        var contact_number = "{{ $this->phone }}";
        var amount = {{ str_replace(',', '', number_format($ftotal, 2)) }};
        var total_amount = amount * 100;
        // var consent = $("#two-step:checkbox:checked").length;

        if(total_amount <= 0){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#custom-overlay').show();
            $.ajax({
                type:'POST',
                url:"{{ route('showcase.paynow') }}",
                data:{
                    amount:total_amount,
                    full_name:full_name,
                    email:email,
                    contact_number:contact_number
                },
                success:function(data){
                    $('.success-message').text(data.success);
                    $('.success-alert').fadeIn('slow', function(){
                        $('.success-alert').delay(5000).fadeOut();
                    });
                    $('#custom-overlay').hide();
                    window.location.href = "/showcase-at-home/my-orders/all";
                }
            });
        }

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
                $('#custom-overlay').show();
                $.ajax({
                    type:'POST',
                    url:"{{ route('showcase.paynow') }}",
                    data:{razorpay_payment_id:response.razorpay_payment_id,amount:total_amount,full_name:full_name,email:email,contact_number:contact_number},
                    success:function(data){
                        $('.success-message').text(data.success);
                        $('.success-alert').fadeIn('slow', function(){
                            $('.success-alert').delay(5000).fadeOut();
                        });
                        $('#custom-overlay').hide();
                        window.location.href = "/showcase-at-home/my-orders/all";
                    }
                });
            },
            "modal": {
                "ondismiss": function () {
                    $('#custom-overlay').hide();
                    alert('Payment Cancelled');
                }
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

        if(total_amount > 0) {
            var rzp1 = new Razorpay(options);
            rzp1.open();
        }
    });
</script>
@endpush
