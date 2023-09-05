<?php

namespace App\Actions;

use App\Order;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class CancelShipment extends AbstractAction
{
    public function getId()
    {
        return 'cancelshipment';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to cancel shipment for ';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any orders to cancel shipment";
    }

    public function getColor()
    {
        return 'danger';
    }

    public function getTitle()
    {
        return 'Cancel Shipment';
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
        if(Config::get('icrm.shipping_provider.shiprocket') == 1)
        {
            if(auth()->user()->hasRole(['admin', 'Client', 'Vendor']))
            {
                if(request('label') == 'Scheduled For Pickup' OR request('label') == 'Ready to Dispatch')
                {
                    return $this->dataType->slug == 'orders';
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
                'message' => "You haven't selected any order to cancel shipment",
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
                        ->whereIn('order_status', ['Scheduled For Pickup', 'Ready to Dispatch'])
                        ->get();
                        
        // dd($orders);


        if(count($orders) == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You can only cancel shipments of orders whose shipping is initiated and scheduled for pickup or ready to dispatch",
                'alert-type' => 'error',
            ]); 
        }
        

        $token =  Shiprocket::getToken();
        $cancelshipmentsids = $orders->pluck('shipping_order_id'); 
        $response =  Shiprocket::order($token)->cancel(['ids' => $cancelshipmentsids]);
        

        if(isset(json_decode($response)->status))
        {
            if(json_decode($response)->status == 200)
            {
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
                
                return redirect($comingFrom)->with([
                    'message' => json_decode($response)->message,
                    'alert-type' => 'success',
                ]);
            }else{
                return redirect($comingFrom)->with([
                    'message' => json_decode($response)->message,
                    'alert-type' => 'error',
                ]);
            }
            

        }else{
            return redirect($comingFrom)->with([
                'message' => json_decode($response)->message,
                'alert-type' => 'error',
            ]);
        }
        
        

        

    }



}