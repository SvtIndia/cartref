<?php

namespace App\Http\Livewire\Showcase;

use App\Order;
use App\Coupon;
use App\Payment;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Product;
use Livewire\Component;
use App\EmailNotification;
use Darryldecode\Cart\Cart;
use App\Notifications\OrderEmail;
use Seshac\Shiprocket\Shiprocket;
use LaravelDaily\Invoices\Invoice;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ShowcaseInitiatedEmail;
use App\Notifications\ShowcasePurchasedEmail;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class Checkout extends Component
{
    public $couponcode;

    public $name;
    public $phone;
    public $companyname;
    public $gst;
    public $country;
    public $address1;
    public $address2;
    public $deliverypincode;
    public $city;
    public $state;
    public $altphone;
    public $email;

    public $cod = false;

    public $discount;
    public $shipping;
    public $tax;

    public $ordervalue;
    public $fsubtotal;
    public $ftotal;

    public $etd;

    public $currenturl;

    public $disablebtn = true;
    
    protected $rules = [
        'name' => 'required',
        'phone' => 'required|integer|digits:10',
        'companyname' => 'nullable|required_with:gst',
        'gst' => 'nullable|regex:"^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$"',
        'country' => 'required',
        'address_1' => 'required',
        'address_2' => 'required',
        'deliverypincode' => 'required|integer|digits:6',
        'city' => 'required',
        'state' => 'required',
        'altphone' => 'nullable|integer|digits:10',
        'email' => 'required',
    ];


    public function mount()
    {


        
        /**
         * If delivery pincode is not set then redirect to bag
         */
        if(empty(Session::get('deliverypincode')))
        {
            Session::flash('warning', 'Before proceesing please check service availability.');
            return redirect()->back();
        }

        $this->deliverypincode = Session::get('deliverypincode');
        $this->pickuppincode = setting('seller-name.pincode');



        // set order method
        Session::put('ordermethod', 'showcase at home');

        // if terms not accepted then false
        if(Session::get('acceptterms') != true)
        {
            Session::put('acceptterms', false);
        }

        // map city state
        $this->mapcitystate($this->deliverypincode);
        // $this->currenturl = url()->current();

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
                    $this->state = collect($collection)['PostOffice'][0]->State;
                    $this->country = collect($collection)['PostOffice'][0]->Country;
                }
            }

            // $this->validate();

        }

        
    }

    public function render()
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

        $carts = app('showcase')->session($userID)->getContent();
        if(count($carts) > 0)
        {
            $this->fsubtotal = Config::get('icrm.showcase_at_home.delivery_charges');
        }else{
            $this->fsubtotal = 0;
        }


        if(count($carts) > 0)
        {
            $this->ftotal = Config::get('icrm.showcase_at_home.delivery_charges');
        }else{
            $this->ftotal = 0;
        }
        


         // if the fields are blank in mount then fetch from session fields
        $this->sessionfields();
        
        // if session field is not present then fetch auth fields
        $this->authfields();

        // disable button if required fields are empty
        if($this->name AND $this->phone AND $this->country AND $this->address1 AND $this->address2 AND $this->deliverypincode AND $this->city AND $this->state AND $this->email)
        {
            // valid
            $this->disablebtn = false;

        }else{
            // invalid
            $this->disablebtn = true;
        }

        if(Session::get('acceptterms') != true){
            // 
            $this->disablebtn = true;
        }
        
        Session::get('deliveryavailable');

        return view('livewire.showcase.checkout')->with([
            'carts' => $carts,
            // 'ordervalue' => $fsubtotal,
            // 'fsubtotal' => $fsubtotal,
            // 'ftotal' => $ftotal,
        ]);
    }

    private function sessionfields()
    {
        // if the fields are blank in mount then fetch from session fields
        if(empty($this->name))
        {
            $this->name = Session::get('name');
        }

        if(empty($this->phone))
        {
            $this->phone = Session::get('phone');
        }
        
        if(empty($this->companyname))
        {
            $this->companyname = Session::get('companyname');
        }

        if(empty($this->gst))
        {
            $this->gst = Session::get('gst');
        }

        if(empty($this->country))
        {
            $this->country = Session::get('country');
        }

        if(empty($this->address1))
        {
            $this->address1 = Session::get('address1');
        }

        if(empty($this->address2))
        {
            $this->address2 = Session::get('address2');
        }

        if(empty($this->deliverypincode))
        {
            $this->deliverypincode = Session::get('deliverypincode');
        }

        if(empty($this->city))
        {
            $this->city = Session::get('city');
        }

        if(empty($this->state))
        {
            $this->state = Session::get('state');
        }

        if(empty($this->altphone))
        {
            $this->altphone = Session::get('altphone');
        }

        if(empty($this->email))
        {
            $this->email = Session::get('email');
        }
    }

    private function authfields()
    {
        // if session field is not present then fetch auth fields
        if(Auth::check())
        {
            if(empty(Session::get('name')))
            {
                $this->name = auth()->user()->name;
            }

            if(empty(Session::get('email')))
            {
                $this->email = auth()->user()->email;
            }

            if(empty(Session::get('phone')))
            {
                $this->phone = auth()->user()->mobile;
            }

            if(empty(Session::get('companyname')))
            {
                $this->companyname = auth()->user()->company_name;
            }

            if(empty(Session::get('gst')))
            {
                $this->gst = auth()->user()->gst_number;
            }

            if(empty(Session::get('address_1')))
            {
                $this->address_1 = auth()->user()->address_1;
            }

            if(empty(Session::get('address_2')))
            {
                $this->address_2 = auth()->user()->address_2;
            }

        }
    }

    // runs after render
    public function dehydrate()
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

        if(count(app('showcase')->session($userID)->getContent()) <= 0)
        {
            Session::flash('danger', 'Your showcase at home is empty');
            return $this->redirect('/showcase-at-home/bag');
        }

        
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedName()
    {
        $this->name = $this->name;
        Session::put('name', $this->name);
    }

    public function updatedPhone()
    {
        $this->phone = $this->phone;
        Session::put('phone', $this->phone);
    }

    public function updatedCompanyname()
    {
        $this->companyname = $this->companyname;
        Session::put('companyname', $this->companyname);
    }

    public function updatedGst()
    {
        $this->gst = $this->gst;
        Session::put('gst', $this->gst);
    }

    public function updatedCountry()
    {
        $this->country = $this->country;
        Session::put('country', $this->country);
    }

    public function updatedAddress1()
    {
        $this->address1 = $this->address1;
        Session::put('address1', $this->address1);
    }

    public function updatedAddress2()
    {
        $this->address2 = $this->address2;
        Session::put('address2', $this->address2);
    }

    public function updatedAltphone()
    {
        $this->altphone = $this->altphone;
        Session::put('altphone', $this->altphone);
    }

    public function updatedEmail()
    {
        $this->email = $this->email;
        Session::put('email', $this->email);
    }

    
    public function acceptterms()
    {
        if(Session::get('acceptterms') == true)
        {
            Session::remove('acceptterms');
        }else{
            Session::put('acceptterms', true);
        }        
    }

    public function placeorder()
    {
        if($this->disablebtn == true)
        {
            Session::flash('danger', 'Before proceeding please fill all the required fields.');
            Session::flash('validationfailed', 'Before proceeding please fill all the required fields.');

            return redirect()->route('showcase.checkout');
        }

        $this->collectpayment();

        // dd('a');
        // $this->carttoorder();
    }

    private function collectpayment()
    {
        /**
         * Catch payment with the payment gateway and redirect with payment info & status
         */ 
        

        $this->razorpay();
    }

    public function razorpay()
    {
        Session::put('address1', $this->address1);
        Session::put('address2', $this->address2);
        Session::put('city', $this->city);
        Session::put('state', $this->state);
        Session::put('country', $this->country);
        
        Session::put('companyname', $this->companyname);
        Session::put('gst', $this->gst);

        Session::put('name', $this->name);
        Session::put('email', $this->email);
        Session::put('phone', $this->phone);
        Session::put('altphone', $this->altphone);

        // run javascript code from checkout.blade.php
        $this->emit('razorPay');
    }

    

}
