<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Showcasecount extends Component
{
    public $showcaseproductid = '';

    protected $listeners = ['showcasecount' => 'render'];

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
        $ssproducts = app('showcase')->session($userID)->getContent();

        return view('livewire.showcasecount')->with([
            'showcasecount' => app('showcase')->session($userID)->getTotalQuantity(),
            'ssproducts' => $ssproducts
        ]);
    }

    public function removeshowcase($id)
    {
        $this->showcaseproductid = $id;

        if(empty($this->showcaseproductid))
        {
            Session::flash('danger', 'There is something wrong. Please refresh the page and try again!');
            return redirect(request()->header('Referer'));
        }

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


        $showcase = app('showcase')->session($userID);

        // remove
        $showcase->remove($id);

        Session::flash('success', 'Product successfully removed from the showcase at home!');

        $this->emit('showcasebag');
        // return redirect(request()->header('Referer'));
        return redirect()->back();
    }


}
