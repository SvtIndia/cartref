<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Darryldecode\Cart\Cart;

class Cartcount extends Component
{
    protected $listeners = ['cartcount' => 'render'];

    public function render()
    {
        $hcartscount = \Cart::getTotalQuantity();

        $hcarts = \Cart::getContent()->take(3);
        $hsubtotal = \Cart::getSubtotal();        

        return view('livewire.cartcount')->with([
            'hcartscount' => $hcartscount,
            'hcarts' => $hcarts,
            'hsubtotal' => $hsubtotal
        ]);
    }

    public function removecart($cartid)
    {
        \Cart::remove($cartid);
    }
}
