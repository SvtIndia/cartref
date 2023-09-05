<?php

namespace App\Actions;

use App\Order;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class CancelOrder extends AbstractAction
{
    public function getId()
    {
        return 'cancelorder';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to cancel order for ';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any orders to cancel";
    }

    public function getColor()
    {
        return 'danger';
    }

    public function getTitle()
    {
        return 'Cancel';
    }

    public function getIcon()
    {
        return 'voyager-x';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-danger',
        ];
    }

    public function getDefaultRoute()
    {
        return route('welcome');
    }

    public function shouldActionDisplayOnDataType()
    {
        if(auth()->user()->hasRole(['admin', 'Client', 'Vendor']))
        {
            if(request('label') == 'New Order' OR request('label') == 'Under Manufacturing')
            {
                return $this->dataType->slug == 'orders';
            }
        }
    }


    public function massAction($ids, $comingFrom)
    {
        // Do something with the IDs
        
        /**
         * Check if the order is selected
         */

        if($ids[0] == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You haven't selected any order to cancel",
                'alert-type' => 'warning',
            ]); 
        }


        /**
         * cancel order awb
        */

        $this->cancelawb($ids, $comingFrom);

        
        return redirect($comingFrom);
    }
    

    private function cancelawb($ids, $comingFrom)
    {
        $orders = Order::whereIn('id', $ids)
                        ->whereIn('order_status', ['New Order'])
                        ->get();


        /**
         * Check if order exists
         */
        if(count($orders) == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You can only cancel orders whose shipping is not initiated",
                'alert-type' => 'error',
            ]); 
        }
        

        if(auth()->user()->hasRole(['Vendor']))
        {
            Order::whereIn('id', $ids)->update([
                'order_status' => 'Cancelled',
                'order_substatus' => 'Cancelled by seller'
            ]);
        }

        if(auth()->user()->hasRole(['admin', 'Client']))
        {
            Order::whereIn('id', $ids)->update([
                'order_status' => 'Cancelled',
                'order_substatus' => 'Cancelled by admin'
            ]);
        }


    }



}