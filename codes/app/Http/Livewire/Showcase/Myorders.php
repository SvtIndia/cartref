<?php

namespace App\Http\Livewire\Showcase;

use App\Showcase;
use Livewire\Component;

class Myorders extends Component
{
    public function render()
    {
        $myorders = Showcase::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->with('product')->get();

        return view('livewire.showcase.myorders')->with([
            'myorders' => $myorders
        ]);
    }
}
