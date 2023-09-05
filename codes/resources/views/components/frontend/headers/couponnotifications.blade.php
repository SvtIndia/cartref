@if (Config::get('icrm.frontend.couponnotifications.feature') == 1)
    @isset($coupons)
        @if (count($coupons) > 0)
            
            <div class="notifications owl-carousel owl-theme owl-shadow-carousel owl-loaded owl-drag" style="z-index: 0;">

                @foreach ($coupons as $key => $coupon)
                    <div class="alert alert-news alert-light alert-round alert-inline" style="
                                background: @if($coupon->background_color) {{ $coupon->background_color }} @else #3913d6db @endif; 
                                color: #fcfcfc; border: none;">
                        {{ $coupon->description }} <br>
                        Coupon Code : <h4 class="alert-title"> {{ $coupon->code }}</h4>
                        
                        {{-- <button type="button" class="btn btn-link btn-close">
                            <i class="d-icon-times"></i>
                        </button> --}}
                    </div>
                @endforeach
            </div>
            
        @endif
    @endisset
@endif


<style>
    .notifications .owl-dots{
       display: none !important;
    }
</style>