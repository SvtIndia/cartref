<?php

namespace App\Actions;

use App\Order;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class GenerateLabel extends AbstractAction
{
    public function getId()
    {
        return 'generatelabel';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to generate shipping label for';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any scheduled pickup to generate shipping label";
    }

    public function getColor()
    {
        return 'primary';
    }

    public function getTitle()
    {
        return 'Generate Label';
    }

    public function getIcon()
    {
        return 'voyager-file-text';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-primary',
        ];
    }

    public function getDefaultRoute()
    {
        return route('welcome');
    }

    public function shouldActionDisplayOnDataType()
    {
        if(request('label') == 'Scheduled For Pickup')
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
                'message' => "You haven't selected any order to generate shipping label",
                'alert-type' => 'warning',
            ]); 
        }


        if(Config::get('icrm.shipping_provider.dtdc') == 1)
        {
            $this->dtdcgeneratelabel($ids, $comingFrom);
        }

        if(Config::get('icrm.shipping_provider.shiprocket') == 1)
        {
            $this->shiprocketgeneratelabel($ids, $comingFrom);
        }

        
        return redirect($comingFrom);
    }
    

    private function shiprocketgeneratelabel($ids, $comingFrom)
    {
        $orders = Order::whereIn('id', $ids)
            ->get();

        $token =  Shiprocket::getToken();
        // dd(json_encode($orders->pluck('shipping_order_id')));
        $orderIds = [ 'ids' => json_encode($orders->pluck('shipping_order_id')) ];
        
        
        
        // $orderIds = [ 'ids' => ['230830441'] ];
        $response = Shiprocket::generate($token)->invoice($orderIds);
        
        
        // dd(json_decode($response)->invoice_url);

        if(isset(json_decode($response)->invoice_url))
        {
            // dd(json_decode($response)->invoice_url);

            foreach($orders as $order)
            {
                $order->update([
                    'order_status' => 'Ready To Dispatch',
                    'tax_invoice' => json_decode($response)->invoice_url,
                ]);
            }
        }

            

    }

    private function dtdcgeneratelabel($ids, $comingFrom)
    {
        $orders = Order::whereIn('id', $ids)
                    ->get();

        /**
         * Check if the orders selected are for only one order awb
        */
        
        if(count($orders->pluck('order_awb')->unique()) > 1){
            return redirect($comingFrom)->with([
                'message' => "You can generate shipping label for one order awb at a time.",
                'alert-type' => 'error',
            ]); 
        }


        $orderawb = $orders[0]->order_awb;
        $orderid = $orders[0]->order_id;


        $curl = curl_init();


        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.shipsy.in/api/customer/integration/consignment/label/multipiece",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",



        CURLOPT_POSTFIELDS => 
        "{
            \n\t\"reference_number\":[\"$orderawb\"]
         }
        ",
        
        CURLOPT_HTTPHEADER => array(
            // "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
            // "Postman-Token: c096d7ba-830d-440a-9de4-10425e62e52f",
            // "api-key: 1d7458885d42002edc2f29e7162049",
            "api-key: 403ee1963f8c4a84243444d2d8a010",
            'Content-Type: application/json',
        ),
        ));


        


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            return redirect($comingFrom)->with([
                'message' => 'Shipping label failed to generate for AWB No:'.$orderawb.'. Reason: '.$err,
                'alert-type' => 'error',
            ]);
        } else {
        // echo $response['reference_number'];
            $collection = json_encode(collect($response));
            $collection = json_decode(json_decode($collection)[0]);
            
            if(isset(collect($collection)['error']))
            {
                return redirect($comingFrom)->with([
                    'message' => 'Shipping label failed to generate for AWB No:'.$orderawb.'. Reason: '.collect($collection)['error']->message,
                    'alert-type' => 'error',
                ]);
            }
            

            if(collect(json_decode(collect($collection)))['status'] == 'OK')
            {
                /**
                 * Check if the dtdc awb number and order awb number matches
                 */

                if(collect(collect(json_decode(collect($collection)))['data'][0])['reference_number'] == $orderawb)
                {
                    

                    Order::whereIn('id', $ids)
                            ->where('order_awb', $orderawb)
                            ->update([
                                'shipping_label' => collect(collect(json_decode(collect($collection)))['data'][0])['label'],
                                'order_status' => 'Ready To Dispatch'
                            ]);

                    return redirect('/'.Config::get('icrm.admin_panel.prefix').'/orders?label=Ready to Dispatch')->with([
                        'message' => "Shipping label successfully generated for AWB No:".$orderawb,
                        'alert-type' => 'success',
                    ]);

                    
                }

                
            }else{
                
                return redirect($comingFrom)->with([
                    'message' => 'Shipping label failed to generate for AWB No:'.$orderawb,
                    'alert-type' => 'error',
                ]);
                
            }
            
        }


        // {"status":"OK","data":[{"success":true,"reference_number":"7D3958231","courier_partner":null,"courier_account":"","courier_partner_reference_number":null,"third_party_pickup_id":"","barCodeData":"","customer_reference_number":"1749502","pieces":[{"reference_number":"7D3958231001"}]}]}


    }



}