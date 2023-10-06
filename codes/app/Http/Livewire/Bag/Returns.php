<?php

namespace App\Http\Livewire\Bag;

use App\Order;
use Livewire\Component;

class Returns extends Component
{
    public $item;
    public $openmodel = false;

    public $return_type;
    public $return_reason;
    public $return_comment;

    protected $rules = [
        'return_type' => 'required',
        'return_reason' => 'required',
        'return_comment' => 'required'
    ];

    public function mount($order)
    {
        $this->item = $order;
    }

    public function render()
    {
        return view('livewire.bag.returns');
    }

    public function showreturnmodel()
    {
        $this->openmodel = true;
    }

    public function closereturnmodel()
    {
        $this->openmodel = false;
    }

    public function updatedReturnType()
    {
        
    }
    
    public function requestreturn()
    {
        $this->validate();

        Order::where('id', $this->item->id)
        ->update([
            'order_status' => 'Requested For Return',
            'order_substatus' => 'Pending for approval',
            'return_type' => $this->return_type,
            'return_reason' => $this->return_reason,
            'return_comment' => $this->return_comment,
            'is_return_window_closed' => true,
        ]);

        return redirect()->route('ordercomplete', ['id' => $this->item->order_id])->with([
            'success' => 'Your return request is under review',
        ]);
    }
}
