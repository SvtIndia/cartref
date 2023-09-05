<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Wishlistcount extends Component
{
    public $wproducts;
    public $wishlistproductid = '';

    protected $listeners = ['wishlistcount' => 'render'];

    public function render()
    {
        $wishlists = app('wishlist')->getContent();

        $wwproducts = Product::whereIn('id', $wishlists->pluck('id'))->get();
          
        return view('livewire.wishlistcount')->with([
            'wishlistcount' => app('wishlist')->getTotalQuantity(),
            'wwproducts' => $wwproducts
        ]);
    }

    public function removew($id)
    {
        $this->wishlistproductid = $id;

        if(empty($this->wishlistproductid))
        {
            Session::flash('danger', 'There is something wrong. Please refresh the page and try again!');
            return redirect(request()->header('Referer'));
        }

        $product = Product::where('id', $this->wishlistproductid)->first();
        // dd($product);
        if(empty($product))
        {
            Session::flash('danger', 'There is something wrong. Please refresh the page and try again!');
            return redirect(request()->header('Referer'));
        }

        $wishlist = app('wishlist');

        // remove
        $wishlist->remove($product->id);

        // Session::flash('success', 'Product successfully removed from the wishlist!');

        // return redirect(request()->header('Referer'));
        $this->emit('wishlistcount');

        return redirect()->back();        
    }


}
