<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Showcasecount extends Component
{
    public $showcaseproductid = '';

    protected $listeners = ['showcasecount' => 'render'];

    public function render()
    {
        $ssproducts = app('showcase')->getContent();

        return view('livewire.showcasecount')->with([
            'showcasecount' => app('showcase')->getTotalQuantity(),
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


        $showcase = app('showcase');

        // remove
        $showcase->remove($id);

        Session::flash('success', 'Product successfully removed from the showcase at home!');

        $this->emit('showcasebag');
        // return redirect(request()->header('Referer'));
        return redirect()->back();        
    }


}
