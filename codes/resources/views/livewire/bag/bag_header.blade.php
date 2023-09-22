@if (\Request::route()->getName() != 'ordercomplete')
<div class="step-by pr-4 pl-4">
    <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'bag') active @endif"><a href="{{ route('bag') }}">1. Shopping {{ Config::get('icrm.cart.name') }}</a></h3>
    <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'checkout') active @endif"><a>2. Checkout</a></h3>
    <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'ordercomplete') active @endif"><a>3. Order Complete</a></h3>
</div>
@endif
