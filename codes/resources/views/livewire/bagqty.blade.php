<div>
    <div class="quantity-adj">
        <div class="label">
            Qty: 
        </div>
        <div class="less">
            <span class="fa fa-minus" wire:click="minusqty"></span>
        </div>
        <div class="quantity">
            <input type="text" wire:model="quantity" value="{{ $this->quantity }}" disabled>
        </div>
        <div class="plus">
            <span class="fa fa-plus" wire:click="plusqty"></span>
        </div>
    </div>
</div>