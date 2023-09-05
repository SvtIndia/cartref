<?php

namespace App\Actions;

use App\Order;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class MoveToNewOrder extends AbstractAction
{
    public function getId()
    {
        return 'movetoneworder';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to move to new order';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any order to move to new order";
    }

    public function getColor()
    {
        return 'success';
    }

    public function getTitle()
    {
        return 'Move to new order';
    }

    public function getIcon()
    {
        return 'voyager-move';
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
        if(request('label') == 'Under Manufacturing')
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
                'message' => "You haven't selected any order to move to new order",
                'alert-type' => 'warning',
            ]); 
        }


        /**
         * move to under manufacturing
        */

        $this->movetoneworder($ids, $comingFrom);

        
        return redirect($comingFrom);
    }
    

    private function movetoneworder($ids, $comingFrom)
    {
        $orders = Order::whereIn('id', $ids)
                        ->get();


        /**
         * Move under manufacturing
         */

        Order::whereIn('id', $ids)
            ->update([
                'order_status' => 'New Order'
            ]);

        return redirect($comingFrom)->with([
            'message' => "Selected orders successfully moved to new order",
            'alert-type' => 'success',
        ]); 

    }



}