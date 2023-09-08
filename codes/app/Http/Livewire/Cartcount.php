<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Auth;

class Cartcount extends Component
{
    protected $listeners = ['cartcount' => 'render'];

    public function render()
    {
        $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }
        $hcartscount = \Cart::session($userID)->getTotalQuantity() ?? 0;

        $hcarts = \Cart::session($userID)->getContent()->take(3);
        $hsubtotal = \Cart::session($userID)->getSubtotal() ?? 0;

        return view('livewire.cartcount')->with([
            'hcartscount' => $hcartscount,
            'hcarts' => $hcarts,
            'hsubtotal' => $hsubtotal
        ]);
    }

    public function removecart($cartid)
    {
        $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }
        \Cart::session($userID)->remove($cartid);
    }
}
