<div class="step-by pr-4 pl-4">
    <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'showcase.bag') active @endif"><a>1. Showcase At Home</a></h3>
    <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'showcase.checkout') active @endif"><a>2. Checkout</a></h3>
    <h3 class="title title-simple title-step @if(\Request::route()->getName() == 'showcase.ordercomplete') active @endif"><a>3. Order Complete</a></h3>
</div>