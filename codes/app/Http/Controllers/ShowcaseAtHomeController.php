<?php

namespace App\Http\Controllers;

use App\Component;
use App\DeliveryServicableArea;
use App\Models\Product;
use App\Models\RewardPointLog;
use App\Models\UserCreditLog;
use App\Notifications\OrderEmail;
use App\Notifications\PushNotification;
use App\Notifications\ShowcaseInitiatedEmail;
use App\Notifications\ShowcasePurchasedEmail;
use App\Notifications\ShowroomAtHomeOrder;
use App\Order;
use App\Payment;
use App\Productsku;
use App\Showcase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use App\Models\User;

class ShowcaseAtHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function introduction()
    {
        $components = Component::where('page_name', 'Showcase At Home')->where('status', 1)->get();
        return view('showcase')->with([
            'components' => $components
        ]);
    }


    public function getstarted()
    {
        return view('showcase.getstarted')->with([

        ]);
    }

    public function activateshowcase(Request $request)
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

        $request->validate([
            'showcasepincode' => 'required'
        ]);

        if (!empty($request->showcasepincode)) {

            /**
             * Check if the showcasepincode is part of servicable city
             * Map City
             */

            $this->mapcitystate($request->showcasepincode);

            $deliveryservicable = DeliveryServicableArea::where('city', Session::get('city'))->where('status', 1)->first();

            if (!empty($deliveryservicable)) {
                // check if the selected product is from the vendor who offers delivery in the customers city
                $showcase = app('showcase')->session($userID);
                $showcasecontents = app('showcase')->session($userID)->getContent();

                if ($showcasecontents->count() > 0) {
                    // check if the customer and vendor city is same else show error
                    if ($showcasecontents->first()->attributes->vendor_city == Session::get('city')) {
                        // same city
                        Session::put('showcasepincode', $request->showcasepincode);
                        Session::put('showcasecity', Session::get('city'));
                    } else {
                        // not same city
                        // dd($showcasecontent->first());

                        foreach ($showcasecontents as $showcasecontent) {
                            app('showcase')->session($userID)->remove($showcasecontent->id);
                        }

                        Session::remove('showcasepincode');
                        Session::remove('showcasecity');

                        Session::put('showcasepincode', $request->showcasepincode);
                        Session::put('showcasecity', Session::get('city'));


                        Session::flash('danger', 'Selected product is not deliverable in ' . Session::get('city') . ' - ' . $request->showcasepincode . ' area.');

                        return redirect()->route('product.slug', ['slug' => $showcasecontents->first()->attributes->slug])->with([
                            'danger' => 'Selected product is not deliverable in ' . Session::get('city') . ' - ' . $request->showcasepincode . ' area.',
                        ]);
                    }
                }


                Session::put('showcasepincode', $request->showcasepincode);
                Session::put('showcasecity', Session::get('city'));


                if ($showcasecontents->count() == 0) {
                    Session::flash('success', 'Showcase At Home activated on your catalog for ' . Session::get('city') . ' - ' . $request->showcasepincode . ' area.');
                    return redirect()->route('products');
                }

                Session::flash('success', 'Showcase At Home activated on your catalog for ' . Session::get('city') . ' - ' . $request->showcasepincode . ' area.');
                return redirect()->route('showcase.bag');
            } else {
                Session::flash('danger', 'Showcase At Home service is not available in ' . Session::get('city') . ' area.');
                Session::remove('showcasepincode');
                Session::remove('showcasecity');
                return redirect()->route('products');
            }


        } else {
            Session::remove('showcasepincode');
            Session::remove('showcasecity');
            Session::flash('danger', 'Please enter your delivery pincode to activate Showcase At Home');
            return redirect()->back();
        }


    }

    private function mapcitystate($pincode)
    {
        Session::remove('city');
        Session::remove('state');
        Session::remove('country');

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
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
            )
        );


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
                Session::remove('city');
                Session::remove('state');
                Session::remove('country');
                exit;
                $refresh;
            }


            if (collect($collection)['Status'] != 'Error') {
                if (collect($collection)['PostOffice'][0]->Country == 'India') {
                    // dd($this->city = collect($collection)['PostOffice'][0]);
                    $this->city = collect($collection)['PostOffice'][0]->District;
                    Session::put('city', collect($collection)['PostOffice'][0]->District);

                    $this->state = collect($collection)['PostOffice'][0]->State;
                    Session::put('state', collect($collection)['PostOffice'][0]->State);

                    $this->country = collect($collection)['PostOffice'][0]->Country;
                    Session::put('country', collect($collection)['PostOffice'][0]->Country);
                }
            }

            // $this->validate();

        }


    }


    public function deactivateshowcase()
    {
        Session::remove('showcasepincode');
        Session::remove('showcasecity');
        Session::remove('showcasevendor');
        Session::remove('showcasevendorid');
        Session::flash('success', 'Showcase At Home deactivated!');
        return redirect()->back();
    }

    public function bag()
    {
        return view('showcase.bag')->with([

        ]);
    }


    public function checkout()
    {
        return view('showcase.checkout')->with([

        ]);
    }


    public function paynow(Request $request)
    {
        /** Proceed Razorpay payment */
        $input = $request->all();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {

                $payment->capture(array('amount' => $request->amount));

            } catch (\Exception $e) {
                return $e->getMessage();
                \Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        }


        /** if payment successful then insert transaction data into the database */
        $payInfo = [
            'payment_id' => $request->razorpay_payment_id,
            'order_id' => $payment->id,
            'payer_email' => $request->email,
            'amount' => $request->amount,
            'currency' => $payment->currency,
            'payment_status' => $payment->status,
            'method' => $payment->method,
        ];

        Payment::insertGetId($payInfo);

        /**
         * after successfull payment add order information in the orders table
         * Clear cart
         */
        $this->carttoorder($payInfo);

        Session::flash('success', 'Showcase At Home order successfully placed! You can expect delivery within ' . Config::get('icrm.showcase_at_home.delivery_tat') . ' ' . Config::get('icrm.showcase_at_home.delivery_tat_name') . '.');
        // return redirect()->route('myorders');
        return response()->json(['success' => 'Payment successful']);
    }


    public function carttoorder($payInfo)
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

        $carts = app('showcase')->session($userID)->getContent();

        foreach ($carts as $key => $cart) {
            // fetch product information
            $product = Product::where('id', $cart->attributes->product_id)->first();


            /**
             * Fetch pickup location
             */

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


            $order = new Showcase;
            $order->order_id = $orderid;
            $order->type = 'Showcase At Home';
            $order->product_id = $product->id;
            $order->product_sku = $product->sku;
            $order->product_subcategory_id = $product->subcategory_id;
            $order->product_offerprice = $cart->price;
            $order->product_mrp = $product->mrp;
            $order->qty = $cart->quantity;
            $order->price_sum = $cart->price;
            $order->size = $cart->attributes->size;
            $order->color = $cart->attributes->color;
            $order->order_value = Config::get('icrm.showcase_at_home.delivery_charges');
            $order->order_discount = 0;
            $order->order_deliverycharges = 0;
            $order->order_subtotal = Config::get('icrm.showcase_at_home.delivery_charges');
            $order->order_tax = 0;
            $order->order_total = Config::get('icrm.showcase_at_home.delivery_charges');
            $order->pickup_streetaddress1 = $pickuplocation['street_address_1'];
            $order->pickup_streetaddress2 = $pickuplocation['street_address_2'];
            $order->pickup_pincode = $pickuplocation['pincode'];
            $order->pickup_city = $pickuplocation['city'];
            $order->pickup_state = $pickuplocation['state'];
            $order->pickup_country = $pickuplocation['country'];
            $order->vendor_id = $product->seller_id;
            $order->dropoff_streetaddress1 = Session::get('address1');
            $order->dropoff_streetaddress2 = Session::get('address2');
            $order->dropoff_pincode = Session::get('deliverypincode');
            $order->dropoff_city = Session::get('city');
            $order->dropoff_state = Session::get('state');
            $order->dropoff_country = Session::get('country');
            $order->company_name = Session::get('companyname');
            $order->gst_number = Session::get('gst');
            $order->customer_name = Session::get('name');
            $order->customer_email = Session::get('email');
            $order->customer_contact_number = Session::get('phone');
            $order->customer_alt_contact_number = Session::get('altphone');
            $order->registered_contact_number = auth()->user()->mobile;
            $order->height = $product->height;
            $order->length = $product->length;
            $order->width = $product->breadth;
            $order->weight = $product->weight;
            $order->user_id = auth()->user()->id;
            $order->order_weight = $cart->attributes->weight;
            $order->order_status = 'New Order';
            $order->order_method = 'Prepaid';
            $order->exp_delivery_date = date('Y-m-d');
            $order->status = '1';
            $order->save();

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

        }

        //Pusher notification to seller [Real-Time]
        $notify = new PushNotification();
        $showcases = Showcase::with('product')->where('order_id', $orderid)->get();
        $notify->send($showcases[0]->vendor_id, $orderid);

        // send order email
        $this->orderemail($orderid);

        /**
         * No need to schedule dynamic pickup
         */
        // $this->dtdcschedulepickup($carts, $total, $order, $orderid);

        app('showcase')->session($userID)->clear();


        Session::remove('ordermethod');
        Session::remove('acceptterms');
        Session::remove('deliverypincode');
        Session::remove('sdeliveryavailable');
        Session::remove('sdeliverynotavailable');

        Session::remove('city');
        Session::remove('state');
        Session::remove('country');
    }


    public function orderemail($orderid)
    {

        /**
         * Send email to customer about showcase initiated
         */
        try {

            //to customer
            if (Config::get('icrm.showcase_at_home.showcase_initiated_email') == 1) {
                Notification::route('mail', auth()->user()->email)->notify(new ShowcaseInitiatedEmail($orderid));
            }

            //to vendor
            $order = Showcase::where('order_id', $orderid)->first();
            $vendorinfo = User::where('id', $order->vendor_id)->first();

            if(isset($order) && isset($vendorinfo)){
                Notification::route('mail', $vendorinfo->email)->notify(
                    new ShowroomAtHomeOrder($orderid, $vendorinfo->name, $order->customer_name, $order->customer_email)
                );
            }
        } catch (Exception $e) {

        }


    }


    public function myorders()
    {
        return view('showcase.myorders');
    }


    public function ordercomplete()
    {
        return view('showcase.ordercomplete');
    }

    public function buynow()
    {
        return view('showcase.buynow');
    }

    public function addTime($id)
    {
        $orders = Showcase::where('order_id', $id)->where('order_status', 'Showcased')->get();
        foreach ($orders as $order) {
            if (!$order->is_timer_extended) {
                $order->showcase_timer = Carbon::parse($order->showcase_timer)->addMinutes($orders->count() * 2.5);
                $order->is_timer_extended = true;
                $order->save();
            }
        }
        return redirect()->back()->with([
            'message' => "Showcase order time has been extended successfully",
            'alert-type' => 'success',
        ]);
    }

    public function acceptOrder($id)
    {
        if (auth()->user()->hasRole(['Vendor'])) {
            $orders = Showcase::where(['order_id' => $id, 'vendor_id' => auth()->user()->id])
                ->where('is_order_accepted', false)
                ->where('order_status', '!=', 'Non Acceptance')
                ->update([
                    'is_order_accepted' => true,
                    'order_status' => 'Accepted'
                ]);

            return redirect()->route('voyager.showcases.index', ['order_id' => $id])->with([
                'message' => "Showcase order accepted successfully",
                'alert-type' => 'success',
            ]);
            //            return redirect()->back()->with([
            //                'message' => "Showcase order accepted successfully",
            //                'alert-type' => 'success',
            //            ]);
        } else {
            abort(404);
        }
    }

    public function cancelOrder($id)
    {
        $orders = Showcase::where('order_id', $id)->get();

        $orderStatus = true;
        foreach ($orders as $item) {
            if ($item->order_status != 'Showcased') {
                $orderStatus = false;
                break;
            }
        }
        if ($orderStatus) {
            $orders = Showcase::where('order_id', $id)->where('order_status', 'Showcased')->get();
            foreach ($orders as $order) {

                $order->update([
                    'order_status' => 'Returned',
                    'status' => '0',
                ]);

                if (Config::get('icrm.stock_management.feature') == 1) {
                    if (Config::get('icrm.product_sku.color') == 1) {
                        $updatestock = Productsku::where('product_id', $order->product_id)->where('color', $order->color)->where('size', $order->size)->first();
                    } else {
                        $updatestock = Productsku::where('product_id', $order->product_id)->where('size', $order->size)->first();
                    }

                    $updatestock->update([
                        'available_stock' => $updatestock->available_stock + $order->qty,
                    ]);
                }
            }

            return redirect()->route('voyager.showcases.index', ['label' => 'Returned'])->with([
                'message' => "Showcase order has been cancelled",
                'alert-type' => 'warning',
            ]);
        } else {
            return redirect()->route('voyager.showcases.index')->with([
                'message' => "Failed to cancel the order",
                'alert-type' => 'error',
            ]);
        }
    }


    public function purchasepaynow(Request $request)
    {
        /** Proceed Razorpay payment */
        $input = $request->all();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {

                $payment->capture(array('amount' => $request->amount));

            } catch (\Exception $e) {
                return $e->getMessage();
                \Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        }


        /** if payment successful then insert transaction data into the database */
        $payInfo = [
            'payment_id' => $request->razorpay_payment_id,
            'order_id' => $payment->id,
            'payer_email' => $request->email,
            'amount' => $request->amount,
            'currency' => $payment->currency,
            'payment_status' => $payment->status,
            'method' => $payment->method,
        ];

        Payment::insertGetId($payInfo);

        /**
         * after successfull payment add order information in the orders table
         * Clear cart
         */
        $this->purchasecarttoorder($request->showcaseorderid);


        Session::flash('success', 'Showcase At Home order successfully placed! You can now collect product from our delivery boy.');
        // return redirect()->route('myorders');
        return response()->json(['success' => 'Payment successful']);
    }

    private function purchasecarttoorder($showcaseorderid)
    {

        // Generate random order id
        $orderid = mt_rand(100000, 999999);

        $carts = Showcase::where('order_id', $showcaseorderid)->where('order_status', 'Moved to Bag')->get();
        $notincarts = Showcase::where('order_id', $showcaseorderid)->where('order_status', '!=', 'Moved to Bag')->get();

        foreach ($carts as $key => $cart) {
            //per product discount calculation
            $ratio = 0;
            $showcase_refund = 0;
            $coupon_discount = 0;
            $reward_point_discount = 0;
            $user_credits_discount = 0;

            if (Session::get('sordervalue') >= 0) {
                $ratio = ($cart->price_sum / Session::get('sordervalue'));
            }

            if (request()->showcaserefund > 0 && auth()->user()->used_showcase_refund < 3) {
                //showcase refund discount
                $showcase_refund = round(($ratio * request()->showcaserefund), 2);
            }
            if (request()->discount > 0) {
                //coupon discount
                $coupon_discount = round(($ratio * request()->discount), 2);
            }
            if (request()->showcase_redeemedRewardPoints > 0) {
                //reward point discount uptoo 20%
                if (auth()->user()->reward_points >= request()->showcase_redeemedRewardPoints)
                    $reward_point_discount = round(($ratio * request()->showcase_redeemedRewardPoints), 2);
            }
            if (request()->showcase_redeemedCredits > 0) {
                //wallet credits discount
                if (auth()->user()->credits >= request()->showcase_redeemedCredits)
                    $user_credits_discount = round(($ratio * request()->showcase_redeemedCredits), 2);
            }

            $product = Product::where('id', $cart->product_id)->first();

            /**
             * Fetch pickup location
             */


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


            $order = new Order;
            $order->order_id = $orderid;
            $order->type = 'Showcase At Home';
            $order->product_id = $cart->product_id;
            $order->product_sku = $cart->product->sku;
            $order->product_subcategory_id = $cart->product->subcategory_id;
            $order->product_offerprice = $cart->product_offerprice;
            $order->product_mrp = $cart->product->mrp;
            $order->qty = $cart->qty;
            $order->price_sum = $cart->price_sum - ($showcase_refund + $coupon_discount + $reward_point_discount + $user_credits_discount);
            $order->size = $cart->size;
            $order->color = $cart->color;
            $order->order_value = Session::get('sordervalue');
            $order->order_discount = request()->discount ?? 0;
            $order->order_deliverycharges = request()->showcaserefund ?? 0;
            $order->order_subtotal = Session::get('ssubtotal');
            $order->order_tax = Session::get('stax');
            $order->order_total = Session::get('stotal');
            $order->pickup_streetaddress1 = $pickuplocation['street_address_1'];
            $order->pickup_streetaddress2 = $pickuplocation['street_address_2'];
            $order->pickup_pincode = $pickuplocation['pincode'];
            $order->pickup_city = $pickuplocation['city'];
            $order->pickup_state = $pickuplocation['state'];
            $order->pickup_country = $pickuplocation['country'];
            $order->vendor_id = $cart->vendor_id;
            $order->dropoff_streetaddress1 = $cart->dropoff_streetaddress1;
            $order->dropoff_streetaddress2 = $cart->dropoff_streetaddress2;
            $order->dropoff_pincode = $cart->dropoff_pincode;
            $order->dropoff_city = $cart->dropoff_city;
            $order->dropoff_state = $cart->dropoff_state;
            $order->dropoff_country = $cart->dropoff_country;
            $order->company_name = $cart->companyname;
            $order->gst_number = $cart->gst_number;
            $order->customer_name = $cart->customer_name;
            $order->customer_email = $cart->customer_email;
            $order->customer_contact_number = $cart->customer_contact_number;
            $order->customer_alt_contact_number = $cart->customer_alt_contact_number;
            $order->registered_contact_number = auth()->user()->mobile;
            $order->height = $cart->height;
            $order->length = $cart->length;
            $order->width = $cart->breadth;
            $order->weight = $cart->weight;
            $order->user_id = $cart->user_id;
            $order->order_weight = $cart->order_weight;
            $order->order_status = 'Delivered';
            $order->order_method = 'Prepaid';
            $order->exp_delivery_date = date('Y-m-d');

            $order->used_reward_points = $reward_point_discount ?? 0;
            $order->used_user_credits = $user_credits_discount ?? 0;
//            dd($order);
            $order->save();

            if ($reward_point_discount > 0) {
                //make log
                $reward_point = new RewardPointLog();
                $reward_point->user_id = auth()->user()->id;
                $reward_point->order_id = $order->id;
                $reward_point->type = 'out';
                $reward_point->amount = $reward_point_discount;
                $reward_point->closing_bal = auth()->user()->reward_points;
                $reward_point->save();
            }

            if ($user_credits_discount > 0) {
                //make log
                $reward_point = new UserCreditLog();
                $reward_point->user_id = auth()->user()->id;
                $reward_point->order_id = $order->id;
                $reward_point->type = 'out';
                $reward_point->amount = $user_credits_discount;
                $reward_point->closing_bal = auth()->user()->credits;
                $reward_point->save();
            }

            $cart->update([
                'order_status' => 'Purchased',
                'status' => '0',
            ]);


        }
        Session::remove('sordervalue');
        Session::remove('sshowcaserefund');
        Session::remove('ssubtotal');
        Session::remove('stax');
        Session::remove('stotal');

        if (request()->showcase_redeemedRewardPoints > 0) {
            auth()->user()->decrement('reward_points', request()->showcase_redeemedRewardPoints);
        }
        if (request()->showcase_redeemedCredits > 0) {
            auth()->user()->decrement('credits', request()->showcase_redeemedCredits);
        }
        if (request()->showcaserefund > 0) {
            auth()->user()->increment('used_showcase_refund', 1);
        }

        foreach ($notincarts as $notincart) {
            $notincart->update([
                'order_status' => 'Returned',
                'status' => '0',
            ]);

            if (Config::get('icrm.stock_management.feature') == 1) {
                if (Config::get('icrm.product_sku.color') == 1) {
                    $updatestock = Productsku::where('product_id', $notincart->product_id)->where('color', $notincart->color)->where('size', $notincart->size)->first();
                } else {
                    $updatestock = Productsku::where('product_id', $notincart->product_id)->where('size', $notincart->size)->first();
                }


                $updatestock->update([
                    'available_stock' => $updatestock->available_stock + $notincart->qty,
                ]);
            }
        }

        $this->purchaseorderemail($orderid);

        Session::remove('showcasebagordermethod');
        Session::remove('showcasebagacceptterms');

        Session::remove('showcase_appliedcouponcode');
        Session::remove('showcase_redeemedRewardPoints');
        Session::remove('showcase_redeemedCredits');
        // Session::flash('success', 'Showcase At Home Order Successfully Placed');
        // return redirect()->route('myorders');
    }


    private function purchaseorderemail($orderid)
    {
        /**
         * Send email to customer about showcase initiated
         */

        if (Config::get('icrm.showcase_at_home.showcase_purchased_email') == 1) {
            Notification::route('mail', auth()->user()->email)->notify(new ShowcasePurchasedEmail($orderid));

        }
    }

    public function getOrder($order_id)
    {
        $showcases = Showcase::with('product')->where('order_id', $order_id)->get();
        return response()->json(['showcases' => $showcases]);
    }
}
