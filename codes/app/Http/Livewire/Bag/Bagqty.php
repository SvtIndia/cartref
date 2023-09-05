<?php

namespace App\Http\Livewire\Bag;

use Livewire\Component;
use Darryldecode\Cart\Cart;

class Bagqty extends Component
{
    public $cart;
    public $qty;

    public function mount($cart, $product)
    {
        $this->cart = $cart;
        $this->qty = $cart->quantity;
    }

    public function render()
    {
        return view('livewire.bag.bagqty');
    }

    
}
