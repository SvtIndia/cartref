<?php

namespace App\Http\Livewire\Bag;

use Carbon\Carbon;
use App\Models\RewardPointLog;
use App\Models\UserCreditLog;
use App\Order;
use App\Coupon;
use App\Productsku;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\EmailNotification;
use Darryldecode\Cart\Cart;
use Craftsys\Msg91\Facade\Msg91;
use Seshac\Shiprocket\Shiprocket;
use LaravelDaily\Invoices\Invoice;
use App\Notifications\CodOrderEmail;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use LaravelDaily\Invoices\Classes\Party;
use App\Notifications\CodOrderEmailToVendor;
use Illuminate\Support\Facades\Notification;
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
    public $appliedShipping;
    public $tax;

    public $totalMrp;
    public $totalSave;
    public $ordervalue;

    public $fsubtotal;
    public $ftotal;
    public $bagcount;

    public $etd;

    public $currenturl;

    public $disablebtn = true;

    public $pickuppincode;

    public $coupons;

    public $redeemedRewardPoints;
    public $redeemedCredits;

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'name' => 'required',
        'phone' => 'required|integer|digits:10',
        'companyname' => 'required|required_with:gst',
        // https://www.geeksforgeeks.org/how-to-validate-gst-goods-and-services-tax-number-using-regular-expression/
        'gst' => 'required|required_with:companyname|regex:"^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$"',
        'country' => 'required',
        'address1' => 'required',
        'address2' => 'required',
        'deliverypincode' => 'required|integer|digits:6',
        'city' => 'required',
        'state' => 'required',
        'altphone' => 'nullable|integer|digits:10',
        'email' => 'required',
    ];


    public function mount()
    {


        /**
         * Debug with conditions
         */
        // \Cart::session($userID)->removeCartCondition('coupon');
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        \Cart::session($userID)->removeCartCondition('tax');
        \Cart::session($userID)->removeCartCondition('shipping');


        /**
         * If delivery pincode is not set then redirect to bag
         */
        if (empty(Session::get('deliverypincode'))) {
            Session::flash('warning', 'Before proceesing please check shipping service availability.');
            return redirect()->back();
        }

        $this->deliverypincode = Session::get('deliverypincode');
        $this->pickuppincode = setting('seller-name.pincode');

        // fetch applied coupon code in the code
        $this->couponcode = Session::get('appliedcouponcode');

        // check cod formula
        $this->checkshippingavailability();

        // map city state
        $this->mapcitystate($this->deliverypincode);

        // if order method is not selected as cod then prepaid
        if (Session::get('ordermethod') != 'cod') {
            Session::put('ordermethod', 'prepaid');
        }

        // if terms not accepted then false
        if (Session::get('acceptterms') != true) {
            Session::put('acceptterms', false);
        }

        $this->currenturl = url()->current();
    }


    public function render()
    {

        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }

        $carts = \Cart::session($userID)->getContent()->where('attributes.type', '!=', 'Showcase At Home');
        $subtotal = \Cart::session($userID)->getSubtotal();
        $total = \Cart::session($userID)->getTotal();

        if (!empty(Session::get('appliedcouponcode'))) {
            // $this->applycoupon();
        } else {
            Session::remove('appliedcouponcode');
        }

        // calculate discount coupon
        $couponCondition = \Cart::session($userID)->getCondition('coupon');
        if (!empty($couponCondition)) {
            $this->discount = $couponCondition->getCalculatedValue($subtotal);
        } else {
            $this->discount = 0;
        }


        // calculate shipping charges
        if (count($carts) > 0) {

            $this->calcshippingcharges();
        }

        $shippingCondition = \Cart::session($userID)->getCondition('shipping');

        if (!empty($shippingCondition)) {
            if ($shippingCondition->getCalculatedValue($subtotal) > 0) {
                $this->shipping = $shippingCondition->getCalculatedValue($subtotal) + 1;
            } else {
                $this->shipping = $shippingCondition->getCalculatedValue($subtotal);
            }
        } else {
            $this->shipping = 0;
        }

        if ($subtotal > 500) {
            $this->appliedShipping = 0;
        } else {
            $this->appliedShipping = $this->shipping;
        }


        if (Config::get('icrm.tax.type') == 'fixed') {
            // calculate fixed tax
            $this->calculatefixedtax();
        }

        if (Config::get('icrm.tax.type') == 'subcategory') {
            // calculate fixed tax
            $this->calculatesubcategorytax();
        }

        $taxCondition = \Cart::session($userID)->getCondition('tax');
        if (!empty($taxCondition)) {
            $this->tax = $taxCondition->getCalculatedValue($subtotal + $this->appliedShipping - $this->discount);
        } else {
            $this->tax = 0;
        }

        $this->ordervalue = $subtotal;
        $this->fsubtotal = $subtotal + $this->appliedShipping - $this->discount - $this->redeemedRewardPoints - $this->redeemedCredits;
        $this->ftotal = $total - $this->discount + $this->tax + $this->appliedShipping - $this->redeemedRewardPoints - $this->redeemedCredits;
        $this->bagcount = \Cart::session($userID)->getTotalQuantity();

        // if the fields are blank in mount then fetch from session fields
        $this->sessionfields();

        //fetch applied reward point and credits
        if (empty($this->redeemedRewardPoints)) {
            if (Session::get('redeemedRewardPoints')) {
                $this->applyRewardPoints();
            }
        }
        if (empty($this->redeemedCredits)) {
            if (Session::get('redeemedCredits')) {
                $this->applyCredits();
            }
        }

        $this->ordervalue = $subtotal;
        $this->fsubtotal = $subtotal + $this->appliedShipping - $this->discount - $this->redeemedRewardPoints - $this->redeemedCredits;
        $this->ftotal = $total - $this->discount + $this->tax + $this->appliedShipping - $this->redeemedRewardPoints - $this->redeemedCredits;
        $this->bagcount = \Cart::session($userID)->getTotalQuantity();
        // if session field is not present then fetch auth fields
        $this->authfields();

        $sellers = [];
        $this->totalMrp = 0;
        foreach ($carts as $cart) {
            $product = Product::where('id', $cart->attributes->product_id)->first();
            $this->totalMrp += $product->mrp * $cart->quantity;
            array_push($sellers, User::find($product->seller_id));
        }
        $now = date('Y-m-d');
        $coupons = Coupon::where('status', 1)->where('from', '<=', $now)->where('to', '>=', $now)->get();

        $this->totalSave = ($this->totalMrp - $this->ordervalue) + $this->discount + ($this->shipping - $this->appliedShipping);

        foreach ($coupons as $coupon) {
            $coupon->is_applicable = false;
            $coupon->applicable_discount = 0;
            $coupon->not_applicable_error = '';

            if ($subtotal >= $coupon->min_order_value) {
                if ($coupon->is_coupon_for_all || $coupon->hasSellers($sellers)) {
                    if ($coupon->is_uwc || $this->redeemedRewardPoints <= 0) {
                        $coupon->is_applicable = true;

                        // 1. Percentage off
                        if ($coupon->type == 'PercentageOff') {
                            $value = $subtotal * ($coupon->value / 100);
                        }

                        // 2. Fixed off
                        if ($coupon->type == 'FixedOff') {
                            $value = $coupon->value;
                        }

                        $coupon->applicable_discount = $value ?? 0;
                    }
                    else{
                        $coupon->not_applicable_error = 'Not applicable with reward points.';
                    }
                }
                else{
                    $coupon->not_applicable_error = 'Can not use with cart products';
                }
            }
        }
        $this->coupons = $coupons;
        // disable button if required fields are empty
        if (Config::get('icrm.auth.fields.companyinfo') != true) {
            if ($this->name and $this->phone and $this->country and $this->address1 and $this->address2 and $this->deliverypincode and $this->city and $this->state and $this->email) {
                // valid
                $this->disablebtn = false;
            } else {
                // invalid
                $this->disablebtn = true;
            }
        } else {
            if ($this->name and $this->phone and $this->country and $this->address1 and $this->address2 and $this->deliverypincode and $this->city and $this->state and $this->email and $this->companyname and $this->gst) {
                // valid
                $this->disablebtn = false;
            } else {
                // invalid
                $this->disablebtn = true;
            }
        }


        if (Session::get('acceptterms') != true) {
            //
            $this->disablebtn = true;
        }

        Session::get('deliveryavailable');

        return view('livewire.bag.checkout')->with([
            'carts' => $carts,
            // 'ordervalue' => $ordervalue,
            // 'fsubtotal' => $fsubtotal,
            // 'ftotal' => $ftotal,
        ]);
    }

    private function sessionfields()
    {
        // if the fields are blank in mount then fetch from session fields
        if (empty($this->name)) {
            $this->name = Session::get('name');
        }

        if (empty($this->phone)) {
            $this->phone = Session::get('phone');
        }

        if (empty($this->companyname)) {
            $this->companyname = Session::get('companyname');
        }

        if (empty($this->gst)) {
            $this->gst = Session::get('gst');
        }

        if (empty($this->country)) {
            $this->country = Session::get('country');
        }

        if (empty($this->address1)) {
            $this->address1 = Session::get('address1');
        }

        if (empty($this->address2)) {
            $this->address2 = Session::get('address2');
        }

        if (empty($this->deliverypincode)) {
            $this->deliverypincode = Session::get('deliverypincode');
        }

        if (empty($this->city)) {
            $this->city = Session::get('city');
        }

        if (empty($this->state)) {
            $this->state = Session::get('state');
        }

        if (empty($this->altphone)) {
            $this->altphone = Session::get('altphone');
        }

        if (empty($this->email)) {
            $this->email = Session::get('email');
        }


    }

    private function authfields()
    {
        // if session field is not present then fetch auth fields
        if (Auth::check()) {
            if (empty(Session::get('name'))) {
                $this->name = auth()->user()->name;
                Session::put('name', auth()->user()->name);
            }

            if (empty(Session::get('email'))) {
                $this->email = auth()->user()->email;
                Session::put('email', auth()->user()->email);
            }

            if (empty(Session::get('phone'))) {
                $this->phone = auth()->user()->mobile;
                Session::put('phone', auth()->user()->mobile);
            }

            if (empty(Session::get('companyname'))) {
                $this->companyname = auth()->user()->company_name;
                Session::put('companyname', auth()->user()->company_name);
            }

            if (empty(Session::get('gst'))) {
                $this->gst = auth()->user()->gst_number;
                Session::put('gst', auth()->user()->gst_number);
            }

            if (empty(Session::get('address1'))) {
                $this->address_1 = auth()->user()->street_address_1;
                Session::put('address1', auth()->user()->street_address_1);
            }

            if (empty(Session::get('address2'))) {
                $this->address_2 = auth()->user()->street_address_2;
                Session::put('address2', auth()->user()->street_address_2);
            }
        }
    }

    // runs after render
    public function dehydrate()
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }

        if (count(\Cart::session($userID)->getContent()) <= 0) {
            Session::flash('danger', 'Your Bag is empty');
            return redirect()->route('bag');
        }

        /**
         * If the user is inactive then redirect back to bag with error message.
         */

        if (auth()->user()->status == 0) {
            Session::flash('danger', 'Your account has been disabled. Please contact us to reactivate.');
            return redirect()->route('bag');
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

    private function checkshippingavailability()
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        $weight = \Cart::session($userID)->getContent()->sum('attributes.weight');
        // dd($weight);

        if (Config::get('icrm.shipping_provider.shiprocket') == 1) {
            $this->shiprocketcheckavailability($weight);
        }

        if (Config::get('icrm.shipping_provider.dtdc') == 1) {
            $this->dtdccheckavailability();
        }
    }

    private function dtdccheckavailability()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://firstmileapi.dtdc.com/dtdc-api/api/custOrder/service/getServiceTypes/$this->pickuppincode/$this->deliverypincode",
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
        $err = curl_error($curl);

        curl_close($curl);

        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }

        if ($err) {
            // not available
            $this->deliveryavailability = false;
            Session::flash('deliverynotavailable', 'Delivery not available in your area');
            // Session::remove('deliverypincode');
            // return;
        } else {
            $collection = json_encode(collect($response));
            $collection = json_decode($collection);
            $collection = collect(json_decode($collection[0]));
            // dd($collection);
            if (isset($collection['status'])) {
                if ($collection['status'] == true) {
                    $servicelist = $collection['data'];
                    // dd($servicelist);
                    $acceptableservices = ['B2C SMART EXPRESS'];

                    if (in_array('PRIORITY', $servicelist)) {
                        // available
                        $this->deliveryavailability = true;
                        $this->cod = true;

                        /**
                         * Calulate expected delivery date
                         * Today + buffer days
                         */

                        // get maximum day of the manufacturing period
                        foreach (\Cart::session($userID)->getContent() as $cart) {
                            $mpproduct = Product::where('id', $cart->attributes->product_id)->orderBy('manufacturing_period', 'DESC')->first();
                        }

                        if (!empty($mpproduct->manufacturing_period)) {
                            $bufferdays = Config::get('icrm.shipping_provider.buffer_days') + 1 + $mpproduct->manufacturing_period;
                        } else {
                            $bufferdays = Config::get('icrm.shipping_provider.buffer_days') + 1;
                        }


                        $this->etd = date('j F, Y', strtotime("+$bufferdays days"));
                        Session::flash('deliveryavailable', 'Expected delivery by ' . $this->etd);
                        Session::put('etd', $this->etd);
                        Session::put('deliverypincode', $this->deliverypincode);

                        return;
                    } else {
                        // not available
                        $this->deliveryavailability = false;
                        Session::flash('deliverynotavailable', 'Delivery not available in your area');
                        // Session::remove('deliverypincode');
                        // return;
                    }
                } else {
                    // not available
                    $this->deliveryavailability = false;
                    Session::flash('deliverynotavailable', 'Delivery not available in your area');
                    // Session::remove('deliverypincode');
                    // return;
                }
            } else {
                // not available
                $this->deliveryavailability = false;
                Session::flash('deliverynotavailable', 'Delivery not available in your area');
                // Session::remove('deliverypincode');
                // return;
            }
        }

        return;
    }

    private function shiprocketcheckavailability($weight)
    {
        // https://apidocs.shiprocket.in/?version=latest#29ff5116-0917-41ba-8c82-638412604916
        $pincodeDetails = [
            'pickup_postcode' => $this->pickuppincode,
            'delivery_postcode' => $this->deliverypincode,
            // 1 for Cash on Delivery and 0 for Prepaid orders.
            'cod' => 1,
            'weight' => $weight,
        ];
        $token = Shiprocket::getToken();
        $response = Shiprocket::courier($token)->checkServiceability($pincodeDetails);


        if ($response['status'] == 200) {

            /**
             * Usefull fields:
             * courier_name - Ekart
             * rate - 76.0
             * cod - 1/0
             * etd - Apr 27, 2022
             */

            if (Config::get('icrm.shipping_provider.shiprocket_recommendation') == 1) {
                // get the etd & rates from the recommended courier partner by shiprocket
                if (isset($response['data']['available_courier_companies'][0])) {
                    $rate = $response['data']['available_courier_companies'][0]['rate'];

                    $this->etd = $response['data']['available_courier_companies'][0]['etd'];
                    Session::put('etd', $response['data']['available_courier_companies'][0]['etd']);

                    $cod = $response['data']['available_courier_companies'][0]['cod'];
                }
            } else {

                $availablecouriercompanies = collect(json_decode($response)->data->available_courier_companies);

                $availablecouriercompaniess = $availablecouriercompanies->sortBy('rate');

                // get the etd & rates from the lowest cost courier partner by shiprocket
                if (isset($availablecouriercompaniess)) {
                    $rate = $availablecouriercompaniess->first()->rate;

                    $this->etd = $availablecouriercompaniess->first()->etd;
                    Session::put('etd', $availablecouriercompaniess->first()->etd);

                    $cod = $availablecouriercompaniess->first()->cod;
                }
            }

            // shipping available
            $this->deliveryavailability = true;


            if (Config::get('icrm.order_methods.cod') == 1) {
                if ($cod == 1) {
                    // COD available
                    Session::put('deliveryavailable', 'Expected delivery by ' . $this->etd . ' | Cash on delivery available');
                    $this->cod = true;
                } else {
                    // COD not available
                    Session::put('deliveryavailable', 'Expected delivery by ' . $this->etd);
                }
            } else {
                Session::put('deliveryavailable', 'Expected delivery by ' . $this->etd);
            }

            Session::put('deliverypincode', $this->deliverypincode);
        } else {
            // not available
            $this->deliveryavailability = false;
            Session::flash('deliverynotavailable', 'Delivery not available in this area');
            // Session::remove('deliverypincode');
            // return redirect()->back();
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

            if (collect($collection)['Status'] == '404') {
                Session::flash('danger', 'Invalid Pincode');
                // return;
                exit;
                $refresh;
            }


            if (collect($collection)['Status'] != 'Error') {
                if (collect($collection)['PostOffice'][0]->Country == 'India') {
                    $this->city = collect($collection)['PostOffice'][0]->District;
                    Session::put('city', collect($collection)['PostOffice'][0]->District);

                    $this->state = collect($collection)['PostOffice'][0]->State;
                    Session::put('state', collect($collection)['PostOffice'][0]->State);

                    $this->country = collect($collection)['PostOffice'][0]->Country;
                    Session::put('country', collect($collection)['PostOffice'][0]->Country);
                }
            } else {
                Session::remove('city');
                Session::remove('state');
                Session::remove('country');

                $this->disablebtn = false;
            }

            // $this->validate();

        }
    }

    private function calcshippingcharges()
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        $weight = \Cart::session($userID)->getContent()->sum('attributes.weight');


        // if shipping charges are fetched from the courier partner
        if (Config::get('icrm.shipping_provider.calculatefrompartner') == 1) {
            if (Config::get('icrm.shipping_provider.shiprocket') == 1) {
                $this->calcshiprocketcharges($weight);
            }

            if (Config::get('icrm.shipping_provider.dtdc') == 1) {
                Session::remove('shippingcharges');

                if (Config::get('icrm.shipping_provider.fixed.feature') == 1) {
                    // since dtdc dont provide shipping rate api so calculate according to fixed rates

                    if (Config::get('icrm.shipping_provider.fixed.where') == 'subtotal') {
                        if (Config::get('icrm.shipping_provider.fixed.type') == 'perc') {
                            Session::put('shippingcharges', (\Cart::session($userID)->getSubtotal() * Config::get('icrm.shipping_provider.fixed.value') / 100));
                        }

                        if (Config::get('icrm.shipping_provider.fixed.type') == 'amount') {
                            Session::put('shippingcharges', (\Cart::session($userID)->getSubtotal() + Config::get('icrm.shipping_provider.fixed.value')));
                        }
                    }
                } else {

                    // just incase configuration is wrong then use this default settings

                    Session::put('shippingcharges', (\Cart::session($userID)->getSubtotal() * 2 / 100));
                }
            }
        }


        // If shipping charges are fixed rate
        if (Config::get('icrm.shipping_provider.fixed.feature') == 1) {
            if (Config::get('icrm.shipping_provider.fixed.where') == 'subtotal') {
                if (Config::get('icrm.shipping_provider.fixed.type') == 'perc') {
                    Session::put('shippingcharges', (\Cart::session($userID)->getSubtotal() * Config::get('icrm.shipping_provider.fixed.value') / 100));
                }

                if (Config::get('icrm.shipping_provider.fixed.type') == 'amount') {
                    Session::put('shippingcharges', (\Cart::session($userID)->getSubtotal() + Config::get('icrm.shipping_provider.fixed.value')));
                }
            }
        }


        /**
         * get shipping charges from delivery partner or else update null
         * If the platform charges addition shipping charges then add value
         */
        if (Session::has('shippingcharges')) {
            $shippingcharges = Session::get('shippingcharges') + (Session::get('shippingcharges') * Config::get('icrm.shipping_provider.additional_charges_perc') / 100);
        } else {
            $shippingcharges = 0;
        }

        // add shipping charges in condition
        $shipping = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'shipping',
            'type' => 'shipping',
            // 'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => '+' . $shippingcharges,
            'order' => 2
        ));

        \Cart::session($userID)->condition($shipping);
    }

    private function calcshiprocketcharges($weight)
    {
        // https://apidocs.shiprocket.in/?version=latest#29ff5116-0917-41ba-8c82-638412604916
        $pincodeDetails = [
            'pickup_postcode' => $this->pickuppincode,
            'delivery_postcode' => $this->deliverypincode,
            // 1 for Cash on Delivery and 0 for Prepaid orders.
            'cod' => 1,
            'weight' => $weight,
        ];
        $token = Shiprocket::getToken();
        $response = Shiprocket::courier($token)->checkServiceability($pincodeDetails);


        if (isset(json_decode($response)->status_code)) {
            if (json_decode($response)->status_code == 422) {
                // not available
                $this->deliveryavailability = false;
                Session::flash('deliverynotavailable', 'Delivery not available in this area');
                Session::remove('shippingcharges');
                // Session::remove('deliverypincode');
                return;
            }
        }

        if (isset(json_decode($response)->status)) {
            if (json_decode($response)->status == 404) {
                // not available
                $this->deliveryavailability = false;
                Session::flash('deliverynotavailable', 'Delivery not available in your area');
                Session::remove('shippingcharges');
                // Session::remove('deliverypincode');
                return;
            }
        }


        if ($response['status'] == 200) {

            /**
             * Usefull fields:
             * courier_name - Ekart
             * rate - 76.0
             * cod - 1/0
             * etd - Apr 27, 2022
             */

            if (Config::get('icrm.shipping_provider.shiprocket_recommendation') == 1) {
                // get the etd & rates from the recommended courier partner by shiprocket
                if (isset($response['data']['available_courier_companies'][0])) {
                    $rate = $response['data']['available_courier_companies'][0]['rate'];
                    Session::put('shippingcharges', $rate);
                }
            } else {

                $availablecouriercompanies = collect(json_decode($response)->data->available_courier_companies);

                $availablecouriercompaniess = $availablecouriercompanies->sortBy('rate');

                // get the etd & rates from the lowest cost courier partner by shiprocket
                if (isset($availablecouriercompaniess)) {
                    $rate = $availablecouriercompaniess->first()->rate;
                    Session::put('shippingcharges', $rate);
                }
            }
        } else {
            Session::flash('deliverynotavailable', 'Delivery not available in this area');
            // Session::remove('deliverypincode');
            Session::remove('shippingcharges');
            return;
        }
    }

    public function calculatefixedtax()
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        // or add multiple conditions from different condition instances
        $tax = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'tax',
            'type' => 'tax',
            // 'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => Config::get('icrm.tax.fixedtax.perc') . '%',
            'order' => 1
        ));

        \Cart::session($userID)->condition($tax);
    }

    public function calculatesubcategorytax()
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        // or add multiple conditions from different condition instances
        $tax = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'tax',
            'type' => 'tax',
            // 'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => Config::get('icrm.tax.fixedtax.perc') . '%',
            'order' => 1
        ));

        \Cart::session($userID)->condition($tax);
    }

    public function applyCirectCoupon($code){
        $this->couponcode = $code;
        $this->applycoupon();
    }
    public function applycoupon()
    {
        /**
         * Check if the coupon is not blank
         * Check if the coupon is invalid or expired
         * Check coupon type and calculate accordingly
         */
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }

        if (!empty($this->couponcode)) {
            $coupon = Coupon::where('code', $this->couponcode)->where('user_email', null)->first();


            /**
             * If the coupon is empty on above result then maybe user has unique coupon for his account
             */

            if (empty($coupon)) {
                $coupon = Coupon::where('code', $this->couponcode)->where('user_email', auth()->user()->email)->first();
            }


            if (!empty($coupon)) {
                // coupon exists

                //check coupon is applicable for cart products
                $sellers = [];
                $carts = \Cart::session($userID)->getContent()->where('attributes.type', '!=', 'Showcase At Home');
                foreach ($carts as $cart) {
                    $product = Product::where('id', $cart->attributes->product_id)->first();
                    array_push($sellers, User::find($product->seller_id));
                }
//                dd($coupon->hasSellers($sellers));

                if (!$coupon->is_coupon_for_all && !$coupon->hasSellers($sellers)) {
                    $this->dispatchBrowserEvent('showToast', ['msg' => 'Coupon can not be applied with cart products', 'status' => 'error']);
                    return;
                }

                //check coupon is applied reward points
                if ($this->redeemedRewardPoints > 0 && !$coupon->is_uwc) {
                    $this->dispatchBrowserEvent('showToast', ['msg' => 'Coupon can not be applied with reward points', 'status' => 'error']);
                    return;
                    // return redirect()->route('checkout');
                }

                // check if coupon is valid and available for everyone

                $currentDate = date('Y-m-d');
                $currentDate = date('Y-m-d', strtotime($currentDate));
                $startDate = date('Y-m-d', strtotime($coupon->from));
                $endDate = date('Y-m-d', strtotime($coupon->to));

                if (($currentDate >= $startDate) && ($currentDate <= $endDate)) {
                    // coupon is valid and not expired

                    // remove other applied coupons
                    \Cart::session($userID)->removeCartCondition('coupon');

                    /**
                     * check if there is minimum order value exists in coupon
                     * If minimum order value exists then check if the subtotal is lesser than order value and show error
                     */

                    if (!empty($coupon->min_order_value)) {
                        // min order value exists
                        if (\Cart::session($userID)->getSubTotal() < $coupon->min_order_value) {
                            // show error message when the subtotal is lesser than order value
                            Session::flash('warning', 'Coupon is valid only for orders above ' . Config::get('icrm.currency.icon') . $coupon->min_order_value);
                            return redirect()->route('checkout');
                        }
                    }


                    // get the discount amount according to the coupon type calculation and apply coupon condition
                    if ($coupon->type == 'PercentageOff') {
                        $this->PercentageOff($coupon);
                    }

                    // 2. Fixed off
                    if ($coupon->type == 'FixedOff') {
                        $this->FixedOff($coupon);
                    }

                    Session::flash('success', 'Coupon code "' . $this->couponcode . '" successfully applied');
                    // return redirect('shopping-cart/bag/checkout');
                    return redirect()->route('checkout');
                } else {
                    // coupon expired
                    Session::flash('danger', 'Coupon code "' . $this->couponcode . '" expired');
                    return redirect()->route('checkout');
                }
            } else {
                // coupon does not exists
                Session::flash('danger', 'Invalid coupon code "' . $this->couponcode . '"');
                return redirect()->route('checkout');
            }
        }
    }


    private function PercentageOff($coupon)
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        Session::remove('appliedcouponcode');
        $value = $coupon->value . '%';

        // add single condition on a cart bases
        $percentageoffcoupon = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'coupon',
            'type' => 'coupon',
            // 'target' => 'subtotal',
            'value' => '-' . $value,
            'attributes' => array( // attributes field is optional
                'code' => $this->couponcode,
                'type' => 'PercentageOff'
            ),
            'order' => 3
        ));

        \Cart::session($userID)->condition($percentageoffcoupon);

        Session::put('appliedcouponcode', $coupon->code);
        // Session::flash('success', 'The coupon code "'.$coupon->code.'" successfully applied on the bag');
        // return redirect()->route('checkout');
        // return redirect()->back();
        return;
    }

    private function FixedOff($coupon)
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        Session::remove('appliedcouponcode');
        $value = $coupon->value;

        // add single condition on a cart bases
        $fixedoffcoupon = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'coupon',
            'type' => 'coupon',
            // 'target' => 'subtotal',
            'value' => '-' . $value,
            'attributes' => array( // attributes field is optional
                'code' => $this->couponcode,
                'type' => 'FixedOff'
            ),
            'order' => 3
        ));

        \Cart::session($userID)->condition($fixedoffcoupon);

        Session::put('appliedcouponcode', $coupon->code);
        // Session::flash('success', 'The coupon code "'.$coupon->code.'" successfully applied on the bag');
        // return redirect()->route('checkout');
        // return redirect()->back();
        return;
    }

    public function removecoupon()
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        \Cart::session($userID)->removeCartCondition('coupon');
        Session::flash('success', 'Coupon successfully removed');
        Session::remove('appliedcouponcode');
        return redirect()->route('checkout');
    }

    public function codneeded()
    {
        if (Session::get('ordermethod') == 'cod') {
            Session::remove('ordermethod');
        } else {
            Session::put('ordermethod', 'cod');
        }
    }

    public function redeemRewardPoints()
    {
        if (Session::get('redeemedRewardPoints')) {
            Session::remove('redeemedRewardPoints');
            $this->redeemedRewardPoints = 0;
            return;
        }

        Session::remove('redeemedRewardPoints');
        $this->redeemedRewardPoints = 0;
        $this->applyRewardPoints();

    }

    private function applyRewardPoints()
    {
        if (auth()->user()->reward_points > 0 && $this->ordervalue >= 1500) {
            $this->redeemedRewardPoints = auth()->user()->reward_points * 0.20;
            Session::put('redeemedRewardPoints', 1);
        }
    }

    public function redeemCredits()
    {
        if (Session::get('redeemedCredits')) {
            Session::remove('redeemedCredits');
            $this->redeemedCredits = 0;
            return;
        }

        Session::remove('redeemedCredits');
        $this->redeemedCredits = 0;

        $this->applyCredits();

    }

    private function applyCredits()
    {
        $userCredits = auth()->user()->credits;
        if ($userCredits > 0) {
            if ($userCredits >= $this->ftotal) {
                $this->redeemedCredits = $this->ftotal;
                Session::put('ordermethod', 'cod');
            } else {
                $this->redeemedCredits = $userCredits;
            }

            // dd($this->redeemedCredits);
            Session::put('redeemedCredits', 1);
        }
    }

    public function acceptterms()
    {
        if (Session::get('acceptterms') == true) {
            Session::remove('acceptterms');
        } else {
            Session::put('acceptterms', true);
        }
    }

    public function placeorder()
    {

        if ($this->disablebtn == true) {
            Session::flash('danger', 'Before proceeding please fill all the required fields.');
            Session::flash('validationfailed', 'Before proceeding please fill all the required fields.');

            return redirect()->route('checkout');
        }

        /**
         * Check if it is prepaid method then proceed with payment else proceed with cod
         */

        if (Session::get('ordermethod') == 'cod') {
            // cod
            $this->carttoorder();
        } else {
            // prepaid
            $this->collectpayment();
        }
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
        // run javascript code from checkout.blade.php
        $this->emit('razorPay');
    }

    private function carttoorder()
    {
        $userID = 0;
        if (Auth::check()) {
            $userID = auth()->user()->id;
        } else {
            if (session('session_id')) {
                $userID = session('session_id');
            } else {
                $userID = rand(1111111111, 9999999999);
                session(['session_id' => $userID]);
            }
        }
        // Generate random order id
        $orderid = mt_rand(100000, 999999);

        $carts = \Cart::session($userID)->getContent();

        foreach ($carts as $key => $cart) {
            //per product discount calculation
            $ratio  = ($cart->getPriceSumWithConditions() / $this->ordervalue);
            $coupon_discount = 0; $reward_point_discount = 0; $user_credits_discount = 0;

            if($this->discount > 0){
                //coupon discount
                $coupon_discount = round(($ratio * $this->discount), 2);
            }
            if($this->redeemedRewardPoints > 0){
                //reward point discount uptoo 20%
                if(auth()->user()->reward_points >= $this->redeemedRewardPoints)
                    $reward_point_discount = round(($ratio * $this->redeemedRewardPoints), 2);
            }
            if($this->redeemedCredits > 0){
                //wallet credits discount
                if(auth()->user()->credits >= $this->redeemedCredits)
                    $user_credits_discount = round(($ratio * $this->redeemedCredits), 2);
            }
            // fetch product information
            $product = Product::where('id', $cart->attributes->product_id)->first();

            if (Config::get('icrm.product_sku.size') == 1 and Config::get('icrm.product_sku.color') == 1) {
                $sku = Productsku::where('size', $cart->attributes->size)
                    ->where('color', $cart->attributes->color)
                    ->where('product_id', $cart->attributes->product_id)
                    ->first();

                if (!empty($sku->weight)) {
                    $length = $sku->length;
                    $breath = $sku->breath;
                    $height = $sku->height;
                    $weight = $sku->weight;
                } else {
                    $length = $product->length;
                    $breath = $product->breadth;
                    $height = $product->height;
                    $weight = $product->weight;
                }
            } elseif (Config::get('icrm.product_sku.size') == 1 and Config::get('icrm.product_sku.color') == 0) {
                $sku = Productsku::where('size', $cart->attributes->size)->where('product_id', $cart->attributes->product_id)->first();

                if (!empty($sku->weight)) {
                    $length = $sku->length;
                    $breath = $sku->breath;
                    $height = $sku->height;
                    $weight = $sku->weight;
                } else {
                    $length = $product->length;
                    $breath = $product->breadth;
                    $height = $product->height;
                    $weight = $product->weight;
                }
            } else {
                $length = $product->length;
                $breath = $product->breadth;
                $height = $product->height;
                $weight = $product->weight;
            }

            if (Config::get('icrm.site_package.singel_brand_store') == 1) {
                $pickuplocation = [
                    'street_address_1' => setting('seller-name.street_address_1'),
                    'street_address_2' => setting('seller-name.street_address_2') . ' ' . setting('seller-name.landmark'),
                    'pincode' => setting('seller-name.pincode'),
                    'city' => setting('seller-name.city'),
                    'state' => setting('seller-name.state'),
                    'country' => setting('seller-name.country'),
                    'name' => setting('seller-name.name'),
                ];
            }

            if (Config::get('icrm.site_package.multi_vendor_store') == 1) {
                $pickuplocation = [
                    'street_address_1' => $product->vendor->street_address_1,
                    'street_address_2' => $product->vendor->street_address_2 . ' ' . $product->vendor->landmark,
                    'pincode' => $product->vendor->pincode,
                    'city' => $product->vendor->city,
                    'state' => $product->vendor->state,
                    'country' => $product->vendor->country,
                    'name' => $product->vendor->brand_name,
                ];
            }


            if ($cart->attributes->requireddocument == null) {
                $requirementdocument = '';
            } else {
                $requirementdocument = url($cart->attributes->requireddocument);
            }


            if ($cart->attributes->customized_image == null) {
                $customizedimage = '';
            } else {
                $customizedimage = url($cart->attributes->customized_image);
            }


            if ($cart->attributes->original_file == null) {
                $originalfile = '';
            } else {
                $originalfile = json_encode($cart->attributes->original_file);
            }


            $order = new Order;
            $order->order_id = $orderid;
            $order->type = $cart->attributes->type;

            $order->product_id = $product->id;
            $order->product_sku = $product->sku;
            $order->product_subcategory_id = $product->subcategory_id;
            $order->product_offerprice = $cart->getPriceWithConditions();
            $order->product_mrp = $product->mrp;
            $order->qty = $cart->quantity;

            $order->price_sum = $cart->getPriceSumWithConditions() - ($coupon_discount + $reward_point_discount + $user_credits_discount);
//            if($cart->getPriceSumWithConditions() == 799)
//            dd($key, $order->price_sum, $coupon_discount, $reward_point_discount, $user_credits_discount);
            $order->size = $cart->attributes->size;
            $order->color = $cart->attributes->color;

            $order->g_plus = $cart->attributes->g_plus;
            $order->cost_per_g = $cart->attributes->cost_per_g;
            $order->requirement_document = $requirementdocument;

            $order->customized_image = $customizedimage;
            $order->original_file = $originalfile;

            $order->order_value = $this->ordervalue;
            $order->order_discount = $this->discount;
            $order->order_deliverycharges = $this->appliedShipping;
            $order->order_subtotal = $this->fsubtotal;
            $order->order_tax = $this->tax;
            $order->order_total = $this->ftotal;
            $order->pickup_streetaddress1 = $pickuplocation['street_address_1'];
            $order->pickup_streetaddress2 = $pickuplocation['street_address_2'];
            $order->pickup_pincode = $pickuplocation['pincode'];
            $order->pickup_city = $pickuplocation['city'];
            $order->pickup_state = $pickuplocation['state'];
            $order->pickup_country = $pickuplocation['country'];
            $order->vendor_id = $product->seller_id;
            $order->dropoff_streetaddress1 = $this->address1;
            $order->dropoff_streetaddress2 = $this->address2;
            $order->dropoff_pincode = $this->deliverypincode;
            $order->dropoff_city = $this->city;
            $order->dropoff_state = $this->state;
            $order->dropoff_country = $this->country;
            $order->company_name = $this->companyname;
            $order->gst_number = $this->gst;
            $order->customer_name = $this->name;
            $order->customer_email = $this->email;
            $order->customer_contact_number = $this->phone;
            $order->customer_alt_contact_number = $this->altphone;
            $order->registered_contact_number = auth()->user()->mobile;

            $order->length = $length;
            $order->width = $breath;
            $order->height = $height;
            $order->weight = $weight;

            $order->user_id = auth()->user()->id;
            $order->order_weight = $cart->attributes->weight;
            $order->order_status = 'New Order';
            $order->order_method = (($this->redeemedRewardPoints > 0 || $this->redeemedCredits > 0) && $this->ftotal <= 0) ? 'Prepaid' : 'COD';
            $order->exp_delivery_date = date('Y-m-d', strtotime($this->etd));

            $order->used_reward_points = $reward_point_discount ?? 0;
            $order->used_user_credits = $user_credits_discount ?? 0;
            $order->save();

            if ($reward_point_discount > 0) {
//                auth()->user()->decrement('reward_points', $reward_point_discount);
                //make log
                $reward_point = new RewardPointLog();
                $reward_point->user_id = auth()->user()->id;
                $reward_point->order_id = $order->id;
                $reward_point->type = 'out';
                $reward_point->amount = $reward_point_discount;
                $reward_point->closing_bal = auth()->user()->reward_points;
                $reward_point->save();
            }

//            if ($user_credits_discount > 0) {
////                auth()->user()->decrement('credits', $user_credits_discount);
//                //make log `
//                $reward_point = new UserCreditLog();
//                $reward_point->user_id = auth()->user()->id;
//                $reward_point->order_id = $order->id;
//                $reward_point->type = 'out';
//                $reward_point->amount = $user_credits_discount;
//                $reward_point->closing_bal = auth()->user()->credits;
//                $reward_point->save();
//            }

            if (Config::get('icrm.stock_management.feature') == 1) {
                if (Config::get('icrm.product_sku.color') == 1) {
                    $updatestock = Productsku::where('product_id', $product->id)->where('color', $cart->attributes->color)->where('size', $cart->attributes->size)->first();
                } else {
                    $updatestock = Productsku::where('product_id', $product->id)->where('size', $cart->attributes->size)->first();
                }


                $updatestock->update([
                    'available_stock' => $updatestock->available_stock - $cart->quantity,
                ]);
            }

            // \Cart::session($userID)->remove($cart->id);

        }

        if($this->redeemedRewardPoints > 0){
            auth()->user()->decrement('reward_points', $this->redeemedRewardPoints);
        }
        if($this->redeemedCredits > 0){
            auth()->user()->decrement('credits', $this->redeemedCredits);
        }

        //100% reward points on first order
        if (!auth()->user()->is_first_shopping) {
            auth()->user()->increment('reward_points', $this->ftotal);
            Auth::user()->update(['is_first_shopping' => 1]);

            //make log
            $reward_point = new RewardPointLog();
            $reward_point->user_id = auth()->user()->id;
            $reward_point->order_id = $orderid;
            $reward_point->type = 'in';
            $reward_point->amount = $this->ftotal;
            $reward_point->closing_bal = auth()->user()->reward_points;
            $reward_point->save();
        }

        Session::put('cartnotclear', true);
        \Cart::session($userID)->removeCartCondition('maxgplus');
        \Cart::session($userID)->removeCartCondition('coupon');
        \Cart::session($userID)->removeCartCondition('shipping');
        \Cart::session($userID)->removeCartCondition('tax');
        Session::remove('ordermethod');
        Session::remove('acceptterms');
        Session::remove('deliverypincode');
        Session::remove('shippingcharges');
        Session::remove('appliedcouponcode');
        Session::remove('deliveryavailable');
        Session::remove('deliverynotavailable');
        Session::remove('etd');
        Session::remove('redeemedRewardPoints');
        Session::remove('redeemedCredits');


        // send order sms
        try {

            if (Config::get('icrm.sms.msg91.feature') == 1) {

                if (!empty(auth()->user()->mobile)) {
                    if (!empty(Config::get('icrm.sms.msg91.order_placed_flow_id'))) {
                        $mobile = '91' . auth()->user()->mobile;
                        $response = Msg91::sms()->to($mobile)
                            ->flow(Config::get('icrm.sms.msg91.order_placed_flow_id'))
                            ->variable('name', auth()->user()->name)
                            ->variable('orderid', $orderid)
                            ->variable('url', route('trackingurl', ['id' => $orderid]))
                            ->send();
                    }
                }
            }

            $this->orderemail($order, $carts);
        } catch (\Exception $e) {
            // something else went wrong
        }


        return redirect()->route('ordercomplete', ['id' => $order->order_id]);
        // return $this->redirect('/my-orders/order/'.$order->order_id);
    }


    private function orderemail($order, $carts)
    {
        // send order placed email
        Notification::route('mail', auth()->user()->email)->notify(new CodOrderEmail($order));

        if (Config::get('icrm.site_package.multi_vendor_store') == 1) {
            // dd($carts->pluck('attributes.product_id')->getValues());

            // $products = Product::whereIn('id', $carts->pluck('attributes.product_id'))->select('vendor_id')->groupBy('vendor_id')->get();

            // dd($products);


            $vendorinfo = User::where('id', $order->vendor_id)->first();

            if (!empty($vendorinfo->email)) {
                // Send order notification to vendor
                Notification::route('mail', $vendorinfo->email)->notify(new CodOrderEmailToVendor($order, $vendorinfo));
            }
        }
    }
}
