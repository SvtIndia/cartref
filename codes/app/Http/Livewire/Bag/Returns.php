<?php

namespace App\Http\Livewire\Bag;

use App\Notifications\ProductReturn;
use App\Order;
use Illuminate\Support\Facades\Notification;
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

        $order = Order::where('id', $this->item->id)->firstOrFail();
        $customer = $order->customer_name;
        $product = $this->item->product->name;


        Order::where('id', $this->item->id)
        ->update([
            'order_status' => 'Requested For Return',
            'order_substatus' => 'Pending for approval',
            'return_type' => $this->return_type,
            'return_reason' => $this->return_reason,
            'return_comment' => $this->return_comment,
            'is_return_window_closed' => true,
        ]);

        // SEND ORDER RETURN EMAIL TO CUSTOMER
        $this->returnemail($order,$customer,$product);

        // return redirect()->route('ordercomplete', ['id' => $this->item->order_id])->with([
        //     'success' => 'Your return request is under review',
        // ]);
    }

    private function returnemail($order, $customer,$product)
    {
        // send order placed email
        Notification::route('mail', auth()->user()->email)->notify(new ProductReturn($order, $customer,$product));
    }
}
