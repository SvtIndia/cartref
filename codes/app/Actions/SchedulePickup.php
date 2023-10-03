<?php

namespace App\Actions;

use App\Order;
use App\Models\User;
use App\Orderlifecycle;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use TCG\Voyager\Actions\AbstractAction;

class SchedulePickup extends AbstractAction
{
    public function getId()
    {
        return 'schedulepickup';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to schedule pickup for';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any order to schedule pickup";
    }

    public function getColor()
    {
        return 'warning';
    }

    public function getTitle()
    {
        return 'Schedule Pickup';
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
            'class' => 'btn btn-warning',
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
            if(request('all') == true OR request('label') == 'New Order' OR request('label') == 'Under Manufacturing')
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
            // Session::flash('success', 'You havent selected anthing');
            // $this->alertError('You havent selected anthing');
            return redirect($comingFrom)->with([
                'message' => "You haven't selected any order to schedule pickup",
                'alert-type' => 'warning',
            ]); 
        }


        $orders = Order::whereIn('id', $ids)
                        ->whereIn('order_status', ['New Order', 'Under Manufacturing'])
                        ->get();

        if(count($orders) == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You can only schedule pickup for new and under manufacturing orders",
                'alert-type' => 'error',
            ]); 
        }


        /**
         * Check if the orders selected are for only one order group
        */

        if(count($orders->pluck('order_id')->unique()) > 1){
            return redirect($comingFrom)->with([
                'message' => "You can schedule pickup only for one order at a time.",
                'alert-type' => 'error',
            ]); 
        }



        /**
         * Schedule pickup for these orders
        */

        if(Config::get('icrm.shipping_provider.dtdc') == 1)
        {
            $this->dtdcschedulepickup($ids, $comingFrom, $orders);
        }

        if(Config::get('icrm.shipping_provider.shiprocket') == 1)
        {
            $this->shiprocketschedulepickup($ids, $comingFrom, $orders);
        }
        
        return redirect($comingFrom);
    }
    

    private function dtdcschedulepickup($ids, $comingFrom, $orders)
    {        
        $customername = $orders[0]->customer_name;
        $customerphone = $orders[0]->customer_contact_number;
        $customeralternate_phone = $orders[0]->customer_alt_contact_number;
        $customeraddress_line_1 = $orders[0]->dropoff_streetaddress1;
        $customeraddress_line_2 = $orders[0]->dropoff_streetaddress2;
        $customerpincode = $orders[0]->dropoff_pincode;
        $customercity = $orders[0]->dropoff_city;
        $customerstate = $orders[0]->dropoff_state;
        $customercountry = $orders[0]->dropoff_country;


        $clientname = setting('seller-name.name');
        $clientphone = setting('seller-name.phone');
        $clientalternate_phone = setting('seller-name.alt_number');
        $clientaddress_line_1 = setting('seller-name.street_address_1');
        $clientaddress_line_2 = setting('seller-name.street_address_2').' '.setting('seller-name.landmark');
        $clientpincode = setting('seller-name.pincode');
        $clientcity = setting('seller-name.city');
        $clientstate = setting('seller-name.state');
        $clientcountry = setting('seller-name.country');


        
        /**
         * Check services available
         */

        $this->dtdccheckservicelist($clientpincode, $customerpincode, $comingFrom);


        /**
         * If delivery not available in customers area
         */
        if(isset($deliveryavailability))
        {
            if($deliveryavailability == 2)
            {
                return redirect($comingFrom)->with([
                    'message' => "Delivery not available for this pincode ".$customerpincode,
                    'alert-type' => 'error',
                ]);
            }
        }

        /**
         * Fetch available service lists according to clients acceptable services
         */
        if(isset($servicelist))
        {

        }
        
        
        
        $num_pieces = $orders->sum('qty');
        $total = $orders[0]->order_total;
        $orderid = $orders[0]->order_id;
        
        $subcategory = 'Tools';
        // $servicetype = 'B2C SMART EXPRESS';
        $servicetype = 'PRIORITY';
        $commodityid = 'Tools';

        $weight = json_decode(number_format($orders[0]->order_weight, 0));

        $dimensionunit = 'cm';
        $weightunit = 'kg';

        $length = json_decode(number_format($orders[0]->product->length));
        $breadth = json_decode(number_format($orders[0]->product->breadth));
        $height = json_decode(number_format($orders[0]->product->height));

        // $customercode = 'PL2435';
        $customercode = 'RO798';

        /**
         * API URLs
            * Demo: https://demodashboardapi.shipsy.in/api/customer/integration/consignment/softdata
            * Production: https://app.shipsy.in/api/customer/integration/consignment/softdata
         * api-key
            * Demo: eb6e38f684ef558a1d64fcf8a75967
            * Live: 1d7458885d42002edc2f29e7162049
         * Content-Type: application/json
         * Method: POST 
         */

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.shipsy.in/api/customer/integration/consignment/softdata",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",

        

        CURLOPT_POSTFIELDS => "{
            \n\t\"consignments\":\t[
                {
                    \n\t\t\t\"customer_code\": \"$customercode\",
                    
                    \n\t\t\t\"reference_number\":\"\",
                    \n\t\t\t\"service_type_id\":\t\"$servicetype\",
                    \n\t\t\t\"load_type\":\t\"NON-DOCUMENT\",
                    \n\t\t\t\"description\":\t\"$subcategory\",
                    
                    \n\t\t\t\"cod_amount\":\t\"0\",
                    \n\t\t\t\"cod_favor_of\":\t\"\",
                    \n\t\t\t\"cod_collection_mode\":\t\"\",

                    \n\t\t\t\"num_pieces\":\t\"$num_pieces\",

                    \n\t\t\t\"dimension_unit\":\t\"cm\",
                    
                    \n\t\t\t\"length\":\t\"$length\",
                    \n\t\t\t\"width\":\t\"$breadth\",
                    \n\t\t\t\"height\":\t\"$height\",
                    \n\t\t\t\"weight_unit\":\t\"kg\",
                    \n\t\t\t\"weight\":\t\"$weight\",
                    \n\t\t\t\"declared_value\":\t\"$total\",
                    
                    \n\t\t\t\"eway_bill\":\t\"\",
                    \n\t\t\t\"invoice_number\":\t\"\",
                    \n\t\t\t\"invoice_date\":\t\"\",

                    \n\t\t\t\"customer_reference_number\": \"$orderid\",
                    \n\t\t\t\"commodity_id\":\t\"$commodityid\",

                    \n\t\t\t\"origin_details\":
                    \t{
                        \n\t\t\t\t\"name\":\t\"$clientname\",
                        \n\t\t\t\t\"phone\":\t\"$clientphone\",
                        \n\t\t\t\t\"alternate_phone\":\t\"$clientalternate_phone\",
                        \n\t\t\t\t\"address_line_1\":\t\"$clientaddress_line_1\",
                        \n\t\t\t\t\"address_line_2\":\t\"$clientaddress_line_2\",
                        \n\t\t\t\t\"pincode\":\t\"$clientpincode\",
                        \n\t\t\t\t\"city\":\t\"$clientcity\",
                        \n\t\t\t\t\"state\":\t\"$clientstate\"\n\t\t\t
                    },

                    \n\t\t\t\"destination_details\":
                    \t{
                        \n\t\t\t\t\"name\":\t\"$customername\",
                        \n\t\t\t\t\"phone\":\t\"$customerphone\",
                        \n\t\t\t\t\"alternate_phone\":\t\"$customeralternate_phone\",
                        \n\t\t\t\t\"address_line_1\":\t\"$customeraddress_line_1\",
                        \n\t\t\t\t\"address_line_2\":\t\"$customeraddress_line_2\",
                        \n\t\t\t\t\"pincode\":\t\"$customerpincode\",
                        \n\t\t\t\t\"city\":\t\"$customercity\",
                        \n\t\t\t\t\"state\":\t\"$customerstate\"\n\t\t\t
                    }
                    

                    \n\t\t}]\n}",
        
                    // \n\t\t\t\"pieces_detail\": \t[
                    //         \t{
                    //             \n\t\t\t\t\"description\":\t\"Notebook\",
                    //             \n\t\t\t\t\"declared_value\":\t\"100\",
                    //             \n\t\t\t\t\"weight\":\t\"0.5\",
                    //             \n\t\t\t\t\"height\":\t\"5\",
                    //             \n\t\t\t\t\"length\":\t\"5\",
                    //             \n\t\t\t\t\"width\":\t\"5\"
                    //         \n\t\t}
                    //     ]
                    

        CURLOPT_HTTPHEADER => array(
            // "api-key: 1d7458885d42002edc2f29e7162049",
            "api-key: 403ee1963f8c4a84243444d2d8a010",
            'Content-Type: application/json',
            // "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
        ),
        ));


        $response = curl_exec($curl);

        // dd($response);
        
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response);

        if ($err) {
        // echo "cURL Error #:" . $err;
            return redirect($comingFrom)->with([
                'message' => $err,
                'alert-type' => 'error',
            ]);
        } else {


            // check if error
            if(isset($response->error->message))
            {
                return redirect($comingFrom)->with([
                    'message' => $response->error->message,
                    'alert-type' => 'error',
                ]);
            }
            

            // check if data error
            if(isset($response->data[0]->message))
            {
                if($response->data[0]->success == false)
                {
                    return redirect($comingFrom)->with([
                        'message' => $response->data[0]->message,
                        'alert-type' => 'error',
                    ]);
                }
            }

            // is status is available
            if(isset($response->status))
            {
                if($response->status == 'OK')
                {
                    if(isset($response->data))
                    {
                        if($response->data[0]->success == true)
                        {

                            /**
                             * Update order status and lifecycle to scheduled for pickup
                             */
                            try{
                                Order::whereIn('id', $ids)->update([
                                    'order_status' => 'Scheduled For Pickup',
                                    'order_awb' =>$response->data[0]->reference_number,
                                    'shipping_provider' => 'DTDC'
                                ]);

                                return redirect('/'.Config::get('icrm.admin_panel.prefix').'/orders?label=Scheduled For Pickup')->with([
                                    'message' => "Pickup successfully scheduled for Order ID ".$orderid." with the AWB Number ".$response->data[0]->reference_number,
                                    'alert-type' => 'success',
                                ]);
                            }catch (\Exception $e) {
                        
                                return redirect($comingFrom)->with([
                                    'message' => $e->getMessage(),
                                    'alert-type' => 'error',
                                ]);
                    
                            }

                        }else{
                            // error

                            if(isset($response->data[0]->reason))
                            {
                                return redirect($comingFrom)->with([
                                    'message' => $response->data[0]->message,
                                    'alert-type' => 'error',
                                ]);
                            }else{
                                return redirect($comingFrom)->with([
                                    'message' => 'Pickup failed',
                                    'alert-type' => 'warning',
                                ]);
                            }
                        }
                    }else{
                        // error
                        return redirect($comingFrom)->with([
                            'message' => 'Pickup failed',
                            'alert-type' => 'warning',
                        ]);
                    }
                    
                }else{
                    // error
                    return redirect($comingFrom)->with([
                        'message' => 'Pickup failed',
                        'alert-type' => 'warning',
                    ]);
                }
            }
            

            
        }




    }

    private function dtdccheckservicelist($clientpincode, $customerpincode, $comingFrom)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://firstmileapi.dtdc.com/dtdc-api/api/custOrder/service/getServiceTypes/$customerpincode/$clientpincode",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        // "x-access-token: PL2435_trk:a1f86859bcb68b321464e07f159e9747",
        "x-access-token: RO798_trk:bcddd52dd9f433c94376480fca276d9b",
        'Content-Type: application/json',
        ),
        ));


        $response = curl_exec($curl);
        // dd($response);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            return redirect($comingFrom)->with([
                'message' => $err,
                'alert-type' => 'error',
            ]);
        } else {
            $collection = json_encode(collect($response));
            $collection = json_decode($collection);
            $collection = collect(json_decode($collection[0]));

            if(isset($collection['status']))
            {
                if($collection['status'] == true)
                {
                    $servicelist = $collection['data'];

                    $acceptableservices = ['B2C SMART EXPRESS'];

                    if(in_array('GROUND_EXPRESS', $servicelist))
                    {
                        // available
                        $deliveryavailability = 1;
                        return $servicelist = $servicelist;
                    }else{
                        // not available
                        return $deliveryavailability = 2;
                    }

                      
                }else{
                    // not available
                    return $deliveryavailability = 2;
                }
            }else{
                // not available
                return $deliveryavailability = 2;
            }

        }

        return;
    }


    private function shiprocketschedulepickup($ids, $comingFrom, $orders)
    {

        $customername = $orders[0]->customer_name;
        $customerphone = $orders[0]->customer_contact_number;
        $customeralternate_phone = $orders[0]->customer_alt_contact_number;
        $customeremail = $orders[0]->customer_email;
        $customeraddress_line_1 = $orders[0]->dropoff_streetaddress1;
        $customeraddress_line_2 = $orders[0]->dropoff_streetaddress2.' '.$orders[0]->dropoff_landmark;
        $customerpincode = $orders[0]->dropoff_pincode;
        $customercity = $orders[0]->dropoff_city;
        $customerstate = $orders[0]->dropoff_state;
        $customercountry = $orders[0]->dropoff_country;

        if(!empty($orders[0]->company_name))
        {
            $customername = $orders[0]->company_name;
        }

        $customergst = $orders[0]->gst_number;


        /**
         * If multi vendor then fetch vendor info
         * Else fetch seller info
         */

        if(Config::get('icrm.vendor.multiple_vendors') == 1)
        {
            /**
             * Get the vendor information
             * If vendor not available then redirect back with the error msg
             */

            $vendor = User::where('id', $orders[0]->vendor_id)->first();

            if(!empty($vendor))
            {
                                
                if(!empty($vendor->brand_name))
                {
                    $clientname = $vendor->brand_name;
                }else{
                    $clientname = $vendor->name;
                }
                                

                $clientemail = $vendor->email;
                $clientphone = $vendor->mobile;
                $clientalternate_phone = '';
                $clientaddress_line_1 = $vendor->street_address_1;
                $clientaddress_line_2 = $vendor->street_address_2.' '.$vendor->landmark;
                $clientpincode = $vendor->pincode;
                $clientcity = $vendor->city;
                $clientstate = $vendor->state;
                $clientcountry = $vendor->country;
            }else{
                return redirect($comingFrom)->with([
                    'message' => "Seller information not updated in his profile",
                    'alert-type' => 'error',
                ]); 
            }

        }else{
            $clientname = setting('seller-name.name');
            $clientemail = setting('seller-name.email');
            $clientphone = setting('seller-name.phone');
            $clientalternate_phone = setting('seller-name.alt_number');
            $clientaddress_line_1 = setting('seller-name.street_address_1');
            $clientaddress_line_2 = setting('seller-name.street_address_2').' '.setting('seller-name.landmark');
            $clientpincode = setting('seller-name.pincode');
            $clientcity = setting('seller-name.city');
            $clientstate = setting('seller-name.state');
            $clientcountry = setting('seller-name.country');
        }
        

        $num_pieces = $orders->sum('qty');
        $total = $orders[0]->order_total;
        $orderid = $orders[0]->order_id;
        $orderdate = $orders[0]->created_at->format('Y-m-d');
        
        $length = $orders->sum('length');
        $breadth = $orders->sum('width');
        $height = $orders->sum('height');
        $weight = $orders->sum('weight');

        $dimensionunit = 'cm';
        $weightunit = 'kg';

        $paymentmethod = $orders[0]->order_method;

        $token =  Shiprocket::getToken();

        /**
         * Check if the pickup location is already registered?
         */

        $locations = Shiprocket::pickup($token)->getLocations();

        $pickuplocation = str_replace(' ', '', $vendor->brand_name.'-'.$vendor->id);

        if(isset(json_decode($locations)->data->shipping_address))
        {
            // 0 means no and 1 means yes
            $locationexists = collect(json_decode($locations)->data->shipping_address)->where('pickup_location', $pickuplocation)->count();
        }else{
            $locationexists = 0;
        }

        

        if($locationexists == 0)
        {
            // create address with pickuplocation name

            //Refer the above url for required parameteres
            $newLocation = [
                "pickup_location"=> "$pickuplocation",
                "name"=> "$clientname",
                "email"=> "$clientemail",
                "phone"=> $clientphone,
                "address"=> "$clientaddress_line_1",
                "address_2"=> "$clientaddress_line_2",
                "city"=> "$clientcity",
                "state"=> "$clientstate",
                "country"=> "$clientcountry",
                "pin_code"=> "$clientpincode"
            ];

            $location = Shiprocket::pickup($token)->addLocation($newLocation);
        }


        $orderitems = [];

        foreach($orders as $order)
        {
            $orderitems[] = array(
                "name"=> $order->product->name.' / '.$order->color.' - '.$order->size,
                "sku"=> $order->product_sku,
                "units"=> $order->qty,
                "hsn" => $order->subcategory->hsn, // not required
                "selling_price"=> $order->product_offerprice
            );
        }


        // https://apidocs.shiprocket.in/?version=latest#247e58f3-37f3-4dfb-a4bb-b8f6ab6d41ec
        $orderDetails = [
            // refer above url for required parameters
            "mode" => "Surface",
            "request_pickup" => true,
            "print_label" => true,
            "generate_manifest" => true,

            "order_id"=> $orderid.auth()->user()->id,
            "order_date"=> "$orderdate",
            
            "channel_id"=> "",

            "reseller_name" => "Reseller: [$clientname]",

            "company_name" => "$clientname",


            "billing_customer_name"=> "$customername",
            "billing_last_name"=> "",
            "billing_address"=> "$customeraddress_line_1",
            "billing_address_2" => "$customeraddress_line_2",
            "billing_city"=> "$customercity",
            "billing_pincode"=> "$customerpincode",
            "billing_state"=> "$customerstate",
            "billing_country"=> "$customercountry",
            "billing_email"=> "$customeremail",
            "billing_phone"=> "$customerphone",
            "billing_alternate_phone" => "$customeralternate_phone",

            "shipping_is_billing"=> true,
            
            "order_items"=> $orderitems,

            "payment_method"=> "$paymentmethod",

            "sub_total"=> $total,
            "weight"=> $weight,
            "length"=> $length,
            "breadth"=> $breadth,
            "height"=> $height,

            "pickup_location"=> "$pickuplocation",

            "customer_gstin" => "$customergst",

        ];
        
        // $channelSpecificOrder = true;
//        dd(111);
        $response =  Shiprocket::order($token)->quickCreate($orderDetails);



        // if has any error
        if(isset(json_decode($response)->payload->error_message))
        {
            return redirect($comingFrom)->with([
                'message' => json_decode($response)->payload->error_message,
                'alert-type' => 'error',
            ]); 
        }

        // if payload has required fields then update
        if(isset(json_decode($response)->payload))
        {
            Order::whereIn('id', $ids)
                ->update([
                'pickup_scheduled_date' => json_decode($response)->payload->pickup_scheduled_date,
                'shipping_order_id' => json_decode($response)->payload->order_id,
                'shipping_id' => json_decode($response)->payload->shipment_id,
                'order_awb' => json_decode($response)->payload->awb_code,
                
                'courier_name' => json_decode($response)->payload->courier_name,
                
                'shipping_label' => json_decode($response)->payload->label_url,
                'manifest_url' => json_decode($response)->payload->manifest_url,
                'shipping_provider' => 'Shiprocket',
                ]);
        }



        // if schedulled successfully
        if(isset(json_decode($response)->status))
        {
            if(json_decode($response)->status == '1')
            {

                Order::whereIn('id', $ids)
                ->update([
                    'order_status' => 'Scheduled For Pickup'
                ]);

                return redirect($comingFrom)->with([
                    'message' => 'Order successfully scheduled with shiprocket awb number: '.json_decode($response)->payload->awb_code.'.',
                    'alert-type' => 'success',
                ]);
            }else{
                
                if(isset(json_decode($response)->payload->error_message))
                {
                    return redirect($comingFrom)->with([
                        'message' => 'Failed to schedule: '.json_decode($response)->payload->error_message,
                        'alert-type' => 'error',
                    ]);
                }else{
                    return redirect($comingFrom)->with([
                        'message' => 'Failed to schedule',
                        'alert-type' => 'error',
                    ]);
                }

                
            }
        }

    }

}