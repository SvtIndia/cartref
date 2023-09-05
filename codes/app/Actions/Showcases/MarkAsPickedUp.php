<?php

namespace App\Actions\Showcases;

use App\Order;
use App\Showcase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class MarkAsPickedUp extends AbstractAction
{
    public function getId()
    {
        return 'markaspickedup';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to mark as picked-up';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any order to mark as picked-up";
    }

    public function getColor()
    {
        return 'success';
    }

    public function getTitle()
    {
        return 'Mark as Picked-up';
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
        if(auth()->user()->hasRole(['Delivery Boy']))
        {
            if(request('order_id'))
            {
                $showcase = Showcase::where('order_id', request('order_id'))->whereIn('order_status', ['New Order'])->count();

                if($showcase > 0)
                {
                    return $this->dataType->slug == 'showcases';
                }
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
                'message' => "You haven't selected any order to mark as picked-up",
                'alert-type' => 'warning',
            ]); 
        }


        /**
         * move to under manufacturing
        */

        $this->markaspickedup($ids, $comingFrom);

        
        // return redirect($comingFrom);
        return redirect('/'.Config::get('icrm.admin_panel.prefix').'/showcases?label=Out For Showcase');

    }
    

    private function markaspickedup($ids, $comingFrom)
    {
        $orders = Showcase::whereIn('id', $ids)
                        ->whereIn('order_status', ['New Order'])
                        ->get();

        /**
         * Check if order exists
         */
        if(count($orders) == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You can only mark new orders as picked-up",
                'alert-type' => 'error',
            ]); 
        }

        /**
         * Move under manufacturing
         */

        Showcase::whereIn('id', $ids)
                ->whereIn('order_status', ['New Order'])
                ->update([
                    'order_status' => 'Out For Showcase'
                ]);

        return redirect($comingFrom)->with([
            'message' => "Selected orders successfully marked as picked-up",
            'alert-type' => 'success',
        ]); 

    }



}