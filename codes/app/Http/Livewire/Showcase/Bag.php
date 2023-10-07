<?php

namespace App\Http\Livewire\Showcase;

use App\Models\Product;
use Livewire\Component;
use Darryldecode\Cart\Cart;
use App\DeliveryServicableArea;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class Bag extends Component
{
    public $deliveryavailability = false;
    public $deliverypincode;
    public $city;

    protected $listeners = ['showcasebag' => 'render'];

    public function mount()
    {
        if(Session::get('showcasepincode') != null)
        {
            Session::put('deliverypincode', Session::get('showcasepincode'));
        }
        
        $this->deliverypincode = Session::get('deliverypincode');
        
    }


    public function render()
    {
        // \Cart::clear();
        $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }

        $showcasecarts = app('showcase')->session($userID)->getContent();

        if(count($showcasecarts) == 0)
        {
            Session::remove('deliverypincode');
            Session::remove('sdeliveryavailable');
            Session::remove('sdeliverynotavailable');
        }

        $subtotal = Config::get('icrm.showcase_at_home.delivery_charges');

        $total = Config::get('icrm.showcase_at_home.delivery_charges');


        if(!empty(Session::get('deliverypincode')))
        {
            $this->deliveryavailability = true;
            // Session::flash('deliveryavailable', 'Delivery available in this area');
        }
        
        return view('livewire.showcase.bag')->with([
            'showcasecarts' => $showcasecarts,
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }



    public function removeShowcase($showcaseid)
    {
        $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }

        $showcase = app('showcase')->session($userID);
        $showcase->remove($showcaseid);

        $this->emit('showcasecount');
    }

    public function checkserviceavailability()
    {
        $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }
        /**
         * Find city for entered delivery pincode
         * Check if the city is under servicable area for showcase at home
         */
        $this->mapcitystate($this->deliverypincode);

        if(!empty($this->city))
        {
            // check status of service in this city
            $deliveryservicablearea = DeliveryServicableArea::where('status', 1)->where('city', $this->city)->first();
        }else{
            // notdeliverable
            Session::flash('sdeliverynotavailable', 'Showcase at home not available in your area');
            Session::remove('deliverypincode');
            return;
        }

        if(empty($deliveryservicablearea))
        {
            // notdeliverable
            Session::flash('sdeliverynotavailable', 'Showcase at home not available in your area');
            Session::remove('deliverypincode');
            return;
        }else{

            $showcasecarts = app('showcase')->session($userID)->getContent();

            foreach($showcasecarts as $showcase)
            {
                // check if there is any product whos vendor city is not matching with customer city, if exists then show error message.
                if($showcase->attributes->vendor_city != $deliveryservicablearea->city){
                    Session::flash('sdeliverynotavailable', 'Please select products from vendors within '.$deliveryservicablearea->city.'.');
                    Session::remove('deliverypincode');
                    return;
                }
            }
            // deliverable
            Session::flash('sdeliveryavailable', 'Showcase at home available in your area');
            Session::put('deliverypincode', $this->deliverypincode);
            return;
        }
    }

    private function mapcitystate($pincode)
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.postalpincode.in/pincode/{$pincode}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        // "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
        // "Postman-Token: c096d7ba-830d-440a-9de4-10425e62e52f",
        // "api-key: eb6e38f684ef558a1d64fcf8a75967",
        "cache-control: no-cache",
        // "customerId: 259",
        // "organisation-id: 1",
        'Content-Type: 	application/json; charset=utf-8',
        ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // dd($response);

            $collection = json_encode(collect($response));
            $collection = json_decode(json_decode($collection)[0])[0];

            if(collect($collection)['Status'] == '404')
            {
                Session::flash('danger', 'Invalid Pincode');
                // return;
                exit;
                $refresh;
            }
            
            
            if(collect($collection)['Status'] != 'Error')
            {
                if(collect($collection)['PostOffice'][0]->Country == 'India')
                {
                    // dd($this->city = collect($collection)['PostOffice'][0]);
                    $this->city = collect($collection)['PostOffice'][0]->District;
                    // $this->state = collect($collection)['PostOffice'][0]->State;
                    // $this->country = collect($collection)['PostOffice'][0]->Country;
                }
            }

            // $this->validate();

        }

        
    }


    public function proceedcheckout()
    {
        /**
         * First check if the shipping serviceavailibity is checked
         * If not then redirect back with error message
         */

        if($this->deliveryavailability == false)
        {
            Session::flash('warning', 'Before proceesing please check service availability.');
            return redirect()->route('showcase.bag');
        }

        if(empty(Session::get('deliverypincode')))
        {
            Session::flash('warning', 'Before proceesing please check service availability.');
            return redirect()->route('showcase.bag');
        }

        return redirect()->route('showcase.checkout');
    }
}
