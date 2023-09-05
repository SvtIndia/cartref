<?php

namespace App\Actions;

use App\Order;
use App\Orderlifecycle;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class UnderManufacturing extends AbstractAction
{
    public function getId()
    {
        return 'undermanufacturing';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to move to manufacturing';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any order to move under manufacturing";
    }

    public function getColor()
    {
        return 'gray';
    }

    public function getTitle()
    {
        return 'Move To Manufacturing';
    }

    public function getIcon()
    {
        return 'voyager-sun';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-gray',
        ];
    }

    public function getDefaultRoute()
    {
        return route('welcome');
    }

    public function shouldActionDisplayOnDataType()
    {
        if(Config::get('icrm.order_lifecycle.undermanufacturing.feature') == 1)
        {
            if(request('label') == 'New Order' OR request('all') == true)
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
                'message' => "You haven't selected any order to move under manufacturing",
                'alert-type' => 'warning',
            ]); 
        }


        /**
         * move to under manufacturing
        */

        $this->movetoundermanufacturing($ids, $comingFrom);

        
        return redirect('/'.Config::get('icrm.admin_panel.prefix').'/orders?label=Under Manufacturing');
    }
    

    private function movetoundermanufacturing($ids, $comingFrom)
    {
        $orders = Order::whereIn('id', $ids)
                        ->whereIn('order_status', ['New order'])
                        ->get();


        /**
         * Check if order exists
         */
        if(count($orders) == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You can only move new orders under manufacturing",
                'alert-type' => 'error',
            ]); 
        }

        /**
         * Move under manufacturing
         */
        try{
            Order::whereIn('id', $ids)
            ->whereIn('order_status', ['New order'])
            ->update([
                'order_status' => 'Under Manufacturing'
            ]);

            Orderlifecycle::whereIn('order_id', $ids)
            ->update([
                'under_manufacturing' => '1'
            ]);
        }catch (\Exception $e) {

            return redirect($comingFrom)->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error',
            ]);

        }


        

        return redirect($comingFrom)->with([
            'message' => "Selected orders successfully moved under manufacturing",
            'alert-type' => 'success',
        ]); 

    }



}