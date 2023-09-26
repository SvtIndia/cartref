<style>
    @media screen and (max-width: 480px) {
        .step-label {
            width: 100%;
            text-align: left;
            padding-left: 7rem !important;
        }

        .step-by .title.title-step {
            margin: 0 3.4rem 0 0rem !important;
        }
    }
    .d-icon-check{
        color: green;
        margin-left: 1rem;
    }
</style>
@if (\Request::route()->getName() != 'ordercomplete')
    <div class="step-by pr-4 pl-4">
        <h3 class="title title-simple title-step step-label @if (\Request::route()->getName() == 'bag') active @endif">
            <a href="{{ route('bag') }}">1. Shopping {{ Config::get('icrm.cart.name') }}
                @if (\Request::route()->getName() == 'checkout')
                    <i class="d-icon-check"></i>
                @endif
            </a>
        </h3>
        <h3 class="title title-simple title-step step-label @if (\Request::route()->getName() == 'checkout') active @endif">
            <a>2. Checkout</a>
        </h3>
        <h3 class="title title-simple title-step step-label @if (\Request::route()->getName() == 'ordercomplete') active @endif">
            <a>3. Order Complete</a>
        </h3>
    </div>
@endif
