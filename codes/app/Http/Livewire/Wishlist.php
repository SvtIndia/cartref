<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Wishlist extends Component
{
    public $wishlistproductid;
    public $view;
    public $wishlistchecked = false;
    public $currenturl;

    public function mount($wishlistproductid, $view)
    {

        $this->currenturl = url()->current();
        
        $this->wishlistproductid = $wishlistproductid;
        $this->view = $view;

        if(app('wishlist')->get($this->wishlistproductid))
        {
            $this->wishlistchecked = true;
        }
    }

    public function render()
    {
        return view('livewire.wishlist');
    }

    public function wishlist()
    {

        if(Config::get('icrm.frontend.wishlist.auth') == true)
        {
            if(!Auth::check())
            {
                return redirect()->route('login');
            }
        }

        // dd($this->wishlistproductid);
        $this->wishlistproductid;

        $product = Product::where('id', $this->wishlistproductid)->first();
        // dd($product);
        if(empty($product))
        {
            Session::flash('danger', 'There is something wrong. Please refresh the page and try again!');
            return redirect()->back();
        }

        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        $wishlist = app('wishlist');

        if($this->wishlistchecked == true)
        {
            // remove
            $wishlist->remove($product->id);

            $this->wishlistchecked = false;

            // Session::flash('success', 'Product successfully removed from the wishlist!');
        }else{
            $wishlist->add(
                $product->id,
                $product->name,
                $product->offer_price,
                '1'
            );

            $this->wishlistchecked = true;

            $p = Product::find($this->wishlistproductid);
            if(auth()->user() && isset($p)){
                $p->attachUser(auth()->user()->id);
            }
            // Session::flash('success', 'Product successfully added in the wishlist!');
        }

        // dd($this->wishlistchecked);
        $this->emit('wishlistcount');

        Session::remove('quickviewid');

        return;
        // return redirect(request()->header('Referer'));
    }

}
