<?php

namespace App\Actions;

use App\Order;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class MarkAsShipped extends AbstractAction
{
    public function getId()
    {
        return 'markasshipped';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to mark as shipped';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any order to mark as shipped";
    }

    public function getColor()
    {
        return 'success';
    }

    public function getTitle()
    {
        return 'Mark as Shipped';
    }

    public function getIcon()
    {
        return 'voyager-truck';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-success',
        ];
    }

    public function getDefaultRoute()
    {
        return route('welcome');
    }

    public function shouldActionDisplayOnDataType()
    {
        if(request('order_awb'))
        {
            return $this->dataType->slug == 'orders';
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
                'message' => "You haven't selected any order to mark as a shipped",
                'alert-type' => 'warning',
            ]); 
        }


        /**
         * move to under manufacturing
        */

        $this->markasshipped($ids, $comingFrom);

        
        return redirect($comingFrom);
    }
    

    private function markasshipped($ids, $comingFrom)
    {
        $orders = Order::whereIn('id', $ids)
                        ->whereIn('order_status', ['Ready to dispatch'])
                        ->get();


        /**
         * Check if order exists
         */
        if(count($orders) == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You can only mark ready to dispatch orders as shipped",
                'alert-type' => 'error',
            ]); 
        }

        /**
         * Move under manufacturing
         */

        Order::whereIn('id', $ids)
        ->whereIn('order_status', ['Ready to dispatch'])->update([
            'order_status' => 'Shipped'
        ]);

        return redirect($comingFrom)->with([
            'message' => "Selected orders successfully marked as shipped",
            'alert-type' => 'success',
        ]); 

    }



}