<style>
    @media screen and (max-width: 480px) {
        .step-label {
            width: 100%;
            text-align: left;
            padding-left: 3rem !important;
        }

        .step-by .title.title-step {
            margin: 0 3.4rem 0 0 !important;
        }
    }
    .d-icon-check{
        color: green;
        margin-left: 1rem;
    }
</style>
<div class="step-by pr-4">
    <h3 class="title title-simple title-step step-label @if(\Request::route()->getName() == 'showcase.bag') active @endif">
        <a href="{{ route('showcase.bag') }}">1. Showroom At Home
            @if (\Request::route()->getName() == 'showcase.checkout')
                <i class="d-icon-check"></i>
            @endif
        </a>
    </h3>
    <h3 class="title title-simple title-step step-label @if(\Request::route()->getName() == 'showcase.checkout') active @endif"><a>2. Checkout</a></h3>
    <h3 class="title title-simple title-step step-label @if(\Request::route()->getName() == 'showcase.ordercomplete') active @endif"><a>3. Order Complete</a></h3>
</div>
