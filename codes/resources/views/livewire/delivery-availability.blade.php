<div>
    @if (Config::get('icrm.delivery_options.feature') == 1)
        <div class="delivery-options">
            <div class="title">
                DELIVERY AVAILABILITY <span class="fa fa-truck"></span>
            </div>
            <div class="input">
                <form wire:submit.prevent="checkavailability" method="post">
                    <input type="text" wire:model="topincode" placeholder="Enter a PIN code"
                        @if($this->deliveryavailability == 1) style="border: 1px solid green;" @elseif($this->deliveryavailability == 2) style="border: 1px solid red;" @endif
                    >
                    <button type="submit">CHECK</button>                    
                </form>
            </div>
            <div class="description">
                @if (!empty($this->deliveryavailability))
                    @if ($this->deliveryavailability == 2)
                        <span style="color: red;">Delivery not available in this area</span>    
                    @elseif($this->deliveryavailability == 1)
                        <span style="color: green;">
                            @if (empty($this->etd))
                                Delivery available in this area
                            @else
                                Expected delivery by {{ $this->etd }}
                            @endif
                        </span>
                        @if ($this->cod == 1)
                            <span style="color: green">- COD is available</span>
                        @endif
                    @elseif($this->deliveryavailability == 3)
                    @endif
                @else
                    @if (Config::get('icrm.shipping_provider.shiprocket') == 1)
                        Please enter PIN code to check delivery time & availability
                    @elseif(Config::get('icrm.shipping_provider.dtdc') == 1)
                        Please enter PIN code to check delivery availability
                    @else
                        Please enter PIN code to check delivery availability
                    @endif
                @endif
            </div>
        </div>
    @endif
</div>
