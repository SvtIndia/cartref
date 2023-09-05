<?php

namespace App\Http\Livewire\Showcase;

use App\Order;
use App\Showcase;
use Livewire\Component;
use Darryldecode\Cart\Cart;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class Ordercomplete extends Component
{
    public $orderid;
    public $items;

    public function mount()
    {
        $this->orderid = request('id');
        Session::remove('danger');

        if(auth()->user()->hasRole(['admin', 'Client', 'Delivery Head', 'Delivery Boy']))
        {
            $this->items = Showcase::where('order_id', $this->orderid)->get();
        }else{
            $this->items = Showcase::where('order_id', $this->orderid)->where('user_id', auth()->user()->id)->get();
        }

    }

    public function render()
    {
        

        return view('livewire.showcase.ordercomplete')->with([
            
        ]);
    }


    public function cancelorder()
    {
        /**
         * If order is not out for delivery then only the user have access to cancel order
         * Else cancel the order
        */

        Showcase::where('order_id', $this->orderid)->update([
            'order_status' => 'Cancelled',
            'status' => '0',
        ]);

        Session::flash('success', 'Order with the ID number "'.$this->orderid.'" has been successfully cancelled');
        return redirect()->route('showcase.myorders');
    }

    public function movetobag($showcaseid)
    {
        /**
         * Move and mark as moved to bag
         */

        $showcase = Showcase::where('id', $showcaseid)->first();

        $showcase->update([
            'order_status' => 'Moved to Bag'
        ]);

        Session::flash('success', $showcase->product->name.' successfully moved to bag');
        return redirect()->route('showcase.ordercomplete', ['id' => $showcase->order_id]);
    }

    
}
