<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Quickview extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }


    public function render()
    {
        return view('livewire.quickview');
    }

    public function displaytrue()
    {
        Session::put('quickviewid', $this->product->id);
        $this->emit('displaytrue');
    }

}
