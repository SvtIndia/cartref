<?php

namespace App;

use App\Productcolor;
use App\Models\Product;
use App\Orderlifecycle;
use App\ProductSubcategory;
use TCG\Voyager\Models\User;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{

    protected $fillable = ['requirement_document', 'customized_image', 'original_file', 'order_status', 'order_substatus', 'tracking_url', 'tax_invoice', 'is_return_window_closed'];

    public function orderlifecycle()
    {
        return $this->belongsTo(Orderlifecycle::class, 'id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'product_subcategory_id', 'id');
    }


    public function productcolor()
    {
        return $this->belongsTo(Productcolor::class, 'product_id', 'id');
    }

    public function scopeRoleWise($query)
    {

        if(!empty(request('label')))
        {
            if(request('label') == 'Request For Return')
            {
                $query->whereIn('order_status', ['Requested For Return', 'Return Request Accepted', 'Return Request Rejected', 'Returned']);
            }else{
                $query->where('order_status', request('label'));
            }

        }

        if(request('order_id'))
        {
            $query->where('order_id', request('order_id'));
        }

        if(request('order_awb'))
        {
            $query->where('order_awb', request('order_awb'));
        }



        /**
         * Update order status according to dtdc tracking API
        */


        // if admin show all data else show only individual data
        if(auth()->user()->hasRole(['admin']))
        {
            $query;
        }elseif(auth()->user()->hasRole(['Client'])){
            $query;
        }elseif(auth()->user()->hasRole(['Vendor'])){
            $query->where('vendor_id', auth()->user()->id);
        }else{
            $query->where('vendor_id', auth()->user()->id);
        }

        if(auth()->user()->hasRole(['admin', 'Client', 'Vendor']))
        {
            if(Config::get('icrm.shipping_provider.shiprocket') == 1)
            {
                // $this->shiprockettrackorder();
            }

            if(Config::get('icrm.shipping_provider.dtdc') == 1)
            {
                $this->dtdctrackorder();
            }
        }

        // $query->leftJoin('showcases', 'orders.order_id', '=', 'showcases.order_id')
        //     ->whereNull('showcases.id');

        return $query->orderBy('updated_at', 'desc');
    }


    private function shiprockettrackorder()
    {
        $orders = Order::whereNotIn('order_status', ['New Order', 'Under Manufacturing', 'Scheduled For Pickup', 'Delivered', 'Cancelled'])
                        ->where('shipping_provider', 'Shiprocket')
                        ->where('order_awb', '!=', null)
                        ->where('shipping_id', '!=', null)
                        ->get();

        foreach($orders as $order)
        {
            // dd($order);
            $token =  Shiprocket::getToken();
            $response = Shiprocket::track($token)->throwShipmentId($order->shipping_id);



            if(isset(json_decode($response)->tracking_data->track_url))
            {
                $order->update([
                    'tracking_url' => json_decode($response)->tracking_data->track_url,
                ]);
            }


            if(isset(json_decode($response)->tracking_data->shipment_track))
            {

                $currentstatus = strtoupper(json_decode($response)->tracking_data->shipment_track[0]->current_status);

                if(
                    $currentstatus == 'OUT FOR PICKUP'
                    OR $currentstatus == 'AWB ASSIGNED'
                    OR $currentstatus == 'LABEL GENERATED'
                    OR $currentstatus == 'PICKUP SCHEDULED'
                    OR $currentstatus == 'PICKUP GENERATED'
                    OR $currentstatus == 'PICKUP QUEUED'
                    OR $currentstatus == 'MANIFEST GENERATED'
                    )
                {
                    $order->update([
                        'order_status' => 'Ready To Dispatch',
                        'order_substatus' => '',
                    ]);
                }

                if(
                    $currentstatus == 'SHIPPED'
                    OR $currentstatus == 'IN TRANSIT'
                    OR $currentstatus == 'OUT FOR DELIVERY'
                    OR $currentstatus == 'PICKED UP'
                    )
                {
                    $order->update([
                        'order_status' => 'Shipped',
                        'order_substatus' => '',
                    ]);
                }

                if($currentstatus == 'CANCELLED')
                {
                    $order->update([
                        'order_status' => 'Cancelled',
                        // 'order_substatus' => '',
                    ]);
                }

                if($currentstatus == 'DELIVERED')
                {
                    $order->update([
                        'order_status' => 'Delivered',
                        'order_substatus' => '',
                    ]);
                }


                if($currentstatus == 'RTO INITIATED')
                {
                    $order->update([
                        'order_status' => 'Request For Return',
                        'order_substatus' => '',
                    ]);
                }


                if($currentstatus == 'RTO DELIVERED')
                {
                    $order->update([
                        'order_status' => 'Returned',
                        'order_substatus' => '',
                    ]);
                }



                if(
                    $currentstatus != 'OUT FOR PICKUP'
                    AND $currentstatus != 'AWB ASSIGNED'
                    AND $currentstatus != 'LABEL GENERATED'
                    AND $currentstatus != 'PICKUP SCHEDULED'
                    AND $currentstatus != 'PICKUP GENERATED'
                    AND $currentstatus != 'PICKUP QUEUED'
                    AND $currentstatus != 'MANIFEST GENERATED'
                    AND $currentstatus != 'SHIPPED'
                    AND $currentstatus != 'IN TRANSIT'
                    AND $currentstatus != 'OUT FOR DELIVERY'
                    AND $currentstatus != 'PICKED UP'
                    AND $currentstatus != 'CANCELLED'
                    AND $currentstatus != 'DELIVERED'
                    AND $currentstatus != 'RTO INITIATED'
                    AND $currentstatus != 'RTO DELIVERED'
                ){
                    $order->update([
                        'order_status' => 'Other',
                        'order_substatus' => $currentstatus,
                    ]);
                }

            }


        }

    }


    private function dtdctrackorder()
    {
        $orders = Order::whereNotIn('order_status', ['New Order', 'Under Manufacturing', 'Scheduled For Pickup', 'Delivered', 'Cancelled'])
                        ->where('shipping_provider', 'DTDC')
                        ->get();

        foreach($orders as $order)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://blktracksvc.dtdc.com/dtdc-api/rest/JSONCnTrk/getTrackDetails",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>
            "
                {
                    \n\t\"TrkType\":\t\"cnno\",
                    \n\t\"strcnno\":\t\"$order->order_awb\",
                    \n\t\"addtnlDtl\":\t\"Y\"\n\t
                }
            "
                ,
            CURLOPT_HTTPHEADER => array(
            // "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
            // "Postman-Token: c096d7ba-830d-440a-9de4-10425e62e52f",
            // "api-key: eb6e38f684ef558a1d64fcf8a75967",
            // "cache-control: no-cache",
            // "customerId: 259",
            // "organisation-id: 1",
            // "x-access-token: PL2435_trk:a1f86859bcb68b321464e07f159e9747",
            "x-access-token: RO798_trk:bcddd52dd9f433c94376480fca276d9b",
            'Content-Type: application/json',
            ),
            ));


            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                // error
                return;
            } else {
                $collection = json_encode(collect($response));
                $collection = json_decode($collection);
                $collection = collect(json_decode($collection[0]));

                // dd($collection);

                if(json_decode($collection)->status == 'SUCCESS')
                {
                    // update shipment status accordingly
                    if(json_decode($collection)->trackHeader->strStatus == 'Not Picked' OR json_decode($collection)->trackHeader->strStatus == 'Pickup Scheduled')
                    {
                        $order->update([
                            'order_status' => 'Ready To Dispatch',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'Booked' OR json_decode($collection)->trackHeader->strStatus == 'In Transit' OR json_decode($collection)->trackHeader->strStatus == 'Softdata Upload')
                    {
                        $order->update([
                            'order_status' => 'Shipped',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'Cancelled' OR json_decode($collection)->trackHeader->strStatus == 'CANCELLED')
                    {
                        $order->update([
                            'order_status' => 'Cancelled',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'Shipped' OR json_decode($collection)->trackHeader->strStatus == 'SHIPPED')
                    {
                        $order->update([
                            'order_status' => 'Shipped',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'Delivered' OR json_decode($collection)->trackHeader->strStatus == 'DELIVERED' OR json_decode($collection)->trackHeader->strStatus == 'OTP Based Delivered')
                    {
                        $order->update([
                            'order_status' => 'Delivered',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'RTO')
                    {
                        $order->update([
                            'order_status' => 'RTO',
                            'order_substatus' => ''
                        ]);
                    }

                    if(
                        json_decode($collection)->trackHeader->strStatus != 'RTO' AND
                        json_decode($collection)->trackHeader->strStatus != 'Delivered' AND
                        json_decode($collection)->trackHeader->strStatus != 'DELIVERED' AND
                        json_decode($collection)->trackHeader->strStatus != 'Shipped' AND
                        json_decode($collection)->trackHeader->strStatus != 'SHIPPED' AND
                        json_decode($collection)->trackHeader->strStatus != 'Cancelled' AND
                        json_decode($collection)->trackHeader->strStatus != 'CANCELLED'
                        AND json_decode($collection)->trackHeader->strStatus != 'In Transit'
                        AND json_decode($collection)->trackHeader->strStatus != 'Softdata Upload'
                        AND json_decode($collection)->trackHeader->strStatus != 'Not Picked'
                        AND json_decode($collection)->trackHeader->strStatus != 'Booked'
                        AND json_decode($collection)->trackHeader->strStatus != 'Pickup Scheduled'
                        AND json_decode($collection)->trackHeader->strStatus != 'OTP Based Delivered'
                    ){
                        $order->update([
                            'order_status' => 'Other',
                            'order_substatus' => json_decode($collection)->trackHeader->strStatus,
                        ]);
                    }


                }

            }
        }
    }

}
