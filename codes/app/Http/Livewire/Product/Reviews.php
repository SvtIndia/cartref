<?php

namespace App\Http\Livewire\Product;

use App\Order;
use App\Models\User;
use App\ProductReview;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Reviews extends Component
{
    public $product;
    public $openreviewmodal = false;
    public $rate = 0;
    public $comment;


    protected $rules = [
        'rate' => 'required',
        'comment' => 'required',
    ];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    { 
        $allreviews = Productreview::where('product_id', $this->product->id)->where('status', 1)->get();
        if(Auth::check())
        {
            $userreview = Productreview::where('product_id', $this->product->id)->where('user_id', auth()->user()->id)->first();
            $authid = auth()->user()->id;
        }else{
            $userreview = '';
            $authid = '';
        }
        $otherreviews = Productreview::where('product_id', $this->product->id)->where('status', '1')->where('user_id', '!=', $authid)->orderBy('id', 'DESC')->paginate(2);
        
        return view('livewire.product.reviews')->with([
            'allreviews' => $allreviews,
            'userreview' => $userreview,
            'otherreviews' => $otherreviews
        ]);
    }

    public function openreviewmodal()
    {

        /**
         * Check if the user have already submited his review
         * Check if the user have ordered this product earlier             
         * If ordered and not submited review then open review modal
         */

        $reviews = ProductReview::where('product_id', $this->product->id)->where('user_id', auth()->user()->id)->first();

        if(!empty($reviews))
        {
            Session::flash('danger', 'You have already submited your review so you cannot proceed further.');
            return redirect()->route('product.slug', ['slug' => $this->product->slug]);
        }

        $orders = Order::where('product_id', $this->product->id)->where('user_id', auth()->user()->id)->first();


        if(!empty($orders))
        {
            $this->openreviewmodal = true;
        }else{
            Session::flash('danger', 'To post a review you have to purchase this product first.');
            return redirect()->route('product.slug', ['slug' => $this->product->slug]);
        }
    }



    public function closereviewmodal()
    {
        /**
         * Close review modal
         */
        $this->openreviewmodal = false;
    }



    public function rating($rate)
    {
        $this->rate = $rate;
    }



    public function reviewcomment()
    {
        $this->validate();

        ProductReview::create([
            'rate' => $this->rate,
            'comment' => $this->comment,
            'user_id' => auth()->user()->id,
            'product_id' => $this->product->id,
            'status' => 0
        ]);

        Session::flash('success', 'Thank you for your rating and review!');
        return redirect()->route('product.slug', ['slug' => $this->product->slug]);
    }


}
