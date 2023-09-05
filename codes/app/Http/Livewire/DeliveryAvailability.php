<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;

class DeliveryAvailability extends Component
{
    public $frompincode;
    public $topincode;
    public $weight;
    public $deliveryavailability;

    public $etd;
    public $cod;

    public function mount($frompincode, $weight)
    {
        $this->frompincode = $frompincode;
        $this->weight = $weight;
    }

    public function render()
    {
        return view('livewire.delivery-availability');
    }

    public function updatedTopincode()
    {   
        // $this->checkavailability();
    }

    public function checkavailability()
    {
        if(Config::get('icrm.shipping_provider.dtdc') == 1)
        {
            $this->dtdccheckavailability();
        }

        if(Config::get('icrm.shipping_provider.shiprocket') == 1)
        {
            $this->shiprocketcheckavailability();
        }
    }

    public function shiprocketcheckavailability()
    {
        if(strlen($this->topincode) <> Config::get('icrm.delivery_options.pincodelen'))
        {
            $this->deliveryavailability = 3;
        }

        // https://apidocs.shiprocket.in/?version=latest#29ff5116-0917-41ba-8c82-638412604916
        $pincodeDetails = [
            'pickup_postcode' => $this->frompincode,
            'delivery_postcode' => $this->topincode,
            // 1 for Cash on Delivery and 0 for Prepaid orders.
            'cod' => 0,
            'weight' => $this->weight,
        ];
        $token =  Shiprocket::getToken();
        $response =  Shiprocket::courier($token)->checkServiceability($pincodeDetails);

        // dd($response);

        if($response['status'] == 200)
        {
            $this->deliveryavailability = 1;

            /**
             * Usefull fields:
             * courier_name - Ekart
             * rate - 76.0
             * cod - 1/0
             * etd - Apr 27, 2022
            */ 

            if(isset($response['data']['available_courier_companies'][0]))
            {
                $this->etd = $response['data']['available_courier_companies'][0]['etd'];
                $this->cod = $response['data']['available_courier_companies'][0]['cod'];            
            }


        }else{
            // not available
            $this->deliveryavailability = 2;
        }
    }

    public function dtdccheckavailability()
    {
        if(strlen($this->topincode) <> Config::get('icrm.delivery_options.pincodelen'))
        {
            $this->deliveryavailability = 3;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://firstmileapi.dtdc.com/dtdc-api/api/custOrder/service/getServiceTypes/$this->frompincode/$this->topincode",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        // CURLOPT_POSTFIELDS => 
        // "
        //     {
        //         \n\t\"orgPincode\":\t\"$this->frompincode\",
        //         \n\t\"desPincode\":\t\"$this->topincode\"\n\t
        //     }
        // "
        //     ,
        CURLOPT_HTTPHEADER => array(
        // "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
        // "Postman-Token: c096d7ba-830d-440a-9de4-10425e62e52f",
        // "api-key: eb6e38f684ef558a1d64fcf8a75967",
        // "cache-control: no-cache",
        // "customerId: 259",
        // "organisation-id: 1",
        "x-access-token: PL2435_trk:a1f86859bcb68b321464e07f159e9747",
        'Content-Type: application/json',
        ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $collection = json_encode(collect($response));
            $collection = json_decode($collection);
            $collection = collect(json_decode($collection[0]));
            
            if(isset($collection['status']))
            {
                if($collection['status'] == true)
                {
                    $servicelist = $collection['data'];
                    // dd($servicelist);
                    $acceptableservices = ['B2C PRIORITY', 'B2B SMART EXPRESS', 'B2C SMART EXPRESS'];

                    if(in_array('B2C PRIORITY', $servicelist) OR in_array('B2B SMART EXPRESS', $servicelist) OR in_array('B2C SMART EXPRESS', $servicelist))
                    {
                        // available
                        $this->deliveryavailability = 1;
                    }else{
                        // not available
                        $this->deliveryavailability = 2;
                    }

                      
                }else{
                    // not available
                    $this->deliveryavailability = 2;
                }
            }else{
                // not available
                $this->deliveryavailability = 2;
            }

        }
    }
}
