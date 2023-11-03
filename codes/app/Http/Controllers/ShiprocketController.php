<?php

namespace App\Http\Controllers;

use App\Notifications\ProductDelivery;
use App\Order;
use Illuminate\Http\Request;
use App\Notifications\ProductDispatch;
use Exception;
use Illuminate\Support\Facades\Notification;
use Seshac\Shiprocket\Shiprocket;

class ShiprocketController extends Controller
{
    //
    public function updateOrderStatus(Request $request)
    {
        try {
            //Test
            $order = \App\Order::first();
            $order->tracking_url = json_encode(request()->all()) . ' Header ==> '. json_encode(request()->header());
            $order->save();

            //Test end


            $awb = request()->awb;
            $orders = Order::where('order_awb', $awb)->get();

            if(isset($orders) && count($orders) > 0){
                foreach ($orders as $order) {
                    $token = Shiprocket::getToken();
                    $response = Shiprocket::track($token)->throwShipmentId($order->shipping_id);

                   
                    if (isset(json_decode($response)->tracking_data->track_url)) {
                        $order->update([
                            'tracking_url' => json_decode($response)->tracking_data->track_url,
                        ]);
                    }
                    if (isset(json_decode($response)->tracking_data->shipment_track)) {
                        $currentstatus = request()->current_status ?? strtoupper(json_decode($response)->tracking_data->shipment_track[0]->current_status);

                        if (
                            $currentstatus == 'OUT FOR PICKUP'
                            or $currentstatus == 'AWB ASSIGNED'
                            or $currentstatus == 'LABEL GENERATED'
                            or $currentstatus == 'PICKUP SCHEDULED'
                            or $currentstatus == 'PICKUP GENERATED'
                            or $currentstatus == 'PICKUP QUEUED'
                            or $currentstatus == 'MANIFEST GENERATED'
                        ) {
                            $order->update([
                                'order_status' => 'Ready To Dispatch',
                                'order_substatus' => '',
                            ]);
                        }

                        if (
                            $currentstatus == 'SHIPPED'
                            or $currentstatus == 'IN TRANSIT'
                            or $currentstatus == 'OUT FOR DELIVERY'
                            or $currentstatus == 'PICKED UP'
                        ) {
                            $order->update([
                                'order_status' => 'Shipped',
                                'order_substatus' => '',
                            ]);

                            //mail to customer
                            try {
                                if (isset($order->customer_email)) {
                                    Notification::route('mail', $order->customer_email)->notify(
                                        new ProductDispatch($order->order_id, $request->courier_name ?? 'Shiprokcet', $order->tracking_url)
                                    );
                                }
                            } catch (Exception $e) {
                            }
                        }

                        if ($currentstatus == 'CANCELLED') {
                            $order->update([
                                'order_status' => 'Cancelled',
                                // 'order_substatus' => '',
                            ]);
                        }

                        if ($currentstatus == 'DELIVERED') {
                            $order->update([
                                'order_status' => 'Delivered',
                                'order_substatus' => '',
                            ]);

                            //mail to customer
                            try {
                                if (isset($order->customer_email)) {
                                    $address = $order->dropoff_streetaddress1 . ',' . $order->dropoff_streetaddress2 . ',' . $order->dropoff_city . ',' . $order->dropoff_state . ' - ' . $order->dropoff_pincode;
                                    $carrier = strtoupper(request()->courier_name);
                                    $delivery_date = json_decode($response)->tracking_data->shipment_track[0]->delivered_date;

                                    Notification::route('mail', $order->customer_email)->notify(
                                        new ProductDelivery($order->order_id, $order->customer_name, $address, $order->tracking_url, $carrier ?? '', $delivery_date,)
                                    );
                                }
                            } catch (Exception $e) {
                            }
                        }


                        if ($currentstatus == 'RTO INITIATED') {
                            $order->update([
                                'order_status' => 'Request For Return',
                                'order_substatus' => '',
                            ]);
                        }


                        if ($currentstatus == 'RTO DELIVERED') {
                            $order->update([
                                'order_status' => 'Returned',
                                'order_substatus' => '',
                            ]);
                        }



                        if (
                            $currentstatus != 'OUT FOR PICKUP'
                            and $currentstatus != 'AWB ASSIGNED'
                            and $currentstatus != 'LABEL GENERATED'
                            and $currentstatus != 'PICKUP SCHEDULED'
                            and $currentstatus != 'PICKUP GENERATED'
                            and $currentstatus != 'PICKUP QUEUED'
                            and $currentstatus != 'MANIFEST GENERATED'
                            and $currentstatus != 'SHIPPED'
                            and $currentstatus != 'IN TRANSIT'
                            and $currentstatus != 'OUT FOR DELIVERY'
                            and $currentstatus != 'PICKED UP'
                            and $currentstatus != 'CANCELLED'
                            and $currentstatus != 'DELIVERED'
                            and $currentstatus != 'RTO INITIATED'
                            and $currentstatus != 'RTO DELIVERED'
                        ) {
                            $order->update([
                                'order_status' => 'Other',
                                'order_substatus' => $currentstatus,
                            ]);
                        }
                    }
                }
            }
        } catch (Exception $e) {

        }
        return;
    }
}
