<?php

namespace App\Http\Controllers;

use App\Models\RewardPointLog;
use App\Models\UserCreditLog;
use App\Size;
use Redirect;
use App\Order;
use Exception;
use App\Coupon;
use App\Vendor;
use App\Payment;
use App\Productsku;
use Razorpay\Api\Api;
use App\Models\Product;
use App\EmailNotification;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use TCG\Voyager\Models\User;
use Craftsys\Msg91\Facade\Msg91;
use App\Notifications\OrderEmail;
use LaravelDaily\Invoices\Invoice;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Notifications\PrepaidOrderEmail;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Support\Facades\Notification;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use App\Notifications\PrepaidOrderEmailToVendor;
use Illuminate\Support\Facades\Auth;


class BagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bag()
    {

        return view('bag.bag')->with([

        ]);
    }

    public function checkout()
    {
        return view('bag.checkout')->with([

        ]);
    }


    public function paynow(Request $request)
    {
        /** Proceed Razorpay payment */
        $input = $request->all();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {

                $payment->capture(array('amount'=>$request->amount));

            } catch (\Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
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
         * Generate invoice
         * Send email notification to the customer with invoice
        */
        $this->carttoorder();



        Session::flash('success', 'Payment done and order placed successfully');
        // return redirect()->route('myorders');
        return response()->json(['success' => 'Payment successful']);
    }


    public function carttoorder()
    {

        // Generate random order id
        $orderid = mt_rand(100000, 999999);

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
        $carts = \Cart::session($userID)->getContent();

        foreach($carts as $key => $cart)
        {

            // fetch product information
            $product = Product::where('id', $cart->attributes->product_id)->first();


            if(Config::get('icrm.site_package.singel_brand_store') == 1)
            {
                $pickuplocation = [
                    'street_address_1' => setting('seller-name.street_address_1'),
                    'street_address_2' => setting('seller-name.street_address_2').' '.setting('seller-name.landmark'),
                    'pincode' => setting('seller-name.pincode'),
                    'city' => setting('seller-name.city'),
                    'state' => setting('seller-name.state'),
                    'country' => setting('seller-name.country'),
                    'name' => setting('seller-name.name'),
                ];
            }

            if(Config::get('icrm.site_package.multi_vendor_store') == 1)
            {
                $pickuplocation = [
                    'street_address_1' => $product->vendor->street_address_1,
                    'street_address_2' => $product->vendor->street_address_2.' '.$product->vendor->landmark,
                    'pincode' => $product->vendor->pincode,
                    'city' => $product->vendor->city,
                    'state' => $product->vendor->state,
                    'country' => $product->vendor->country,
                    'name' => $product->vendor->brand_name,
                ];
            }


            $subtotal = \Cart::session($userID)->getSubtotal();
            $total = \Cart::session($userID)->getTotal();

            $ordervalue = $subtotal;


            $couponCondition = \Cart::session($userID)->getCondition('coupon');
            if(!empty($couponCondition))
            {
                $discount = $couponCondition->getCalculatedValue($subtotal);
            }else{
                $discount = 0;
            }


            $shippingCondition = \Cart::session($userID)->getCondition('shipping');
            if(!empty($shippingCondition))
            {
                $shipping = $shippingCondition->getCalculatedValue($subtotal);
            }else{
                $shipping = 0;
            }


            $taxCondition = \Cart::session($userID)->getCondition('tax');
            if(!empty($taxCondition))
            {
                $tax = $taxCondition->getCalculatedValue($subtotal + $shipping - $discount);
            }else{
                $tax = 0;
            }

            $fsubtotal = $subtotal + $shipping - $discount - request()->redeemed_credits - request()->redeemed_reward_points;
            $ftotal = $total + $shipping - $discount + $tax - request()->redeemed_credits - request()->redeemed_reward_points;

            if($cart->attributes->requireddocument == null)
            {
                $requirementdocument = '';
            }else{
                $requirementdocument = url($cart->attributes->requireddocument);
            }


            if($cart->attributes->customized_image == null)
            {
                $customizedimage = '';
            }else{
                $customizedimage = url($cart->attributes->customized_image);
            }

            if($cart->attributes->original_file == null)
            {
                $originalfile = '';
            }else{
                $originalfile = json_encode($cart->attributes->original_file);
            }

            //per product discount calculation
//            $ov = \Cart::session($userID)->getSubtotal() ?? 1;
            $ratio  = ($cart->getPriceSumWithConditions() / $ordervalue);
            $coupon_discount = 0; $reward_point_discount = 0; $user_credits_discount = 0;

            if($discount > 0){
                //coupon discount
                $coupon_discount = round(($ratio * $discount), 2);
            }
            if(request()->redeemed_reward_points > 0){
                //reward point discount uptoo 20%
                if(auth()->user()->reward_points >= request()->redeemed_reward_points)
                    $reward_point_discount = round(($ratio * request()->redeemed_reward_points), 2);
            }
            if(request()->redeemed_credits > 0){
                //wallet credits discount
                if(auth()->user()->credits >= request()->redeemed_credits)
                    $user_credits_discount = round(($ratio * request()->redeemed_credits), 2);
            }

            $order = new Order;
            $order->order_id = $orderid;
            $order->type = $cart->attributes->type;
            $order->product_id = $cart->attributes->product_id;
            $order->product_sku = $product->sku;
            $order->product_subcategory_id = $product->subcategory_id;
            $order->product_offerprice = $cart->getPriceWithConditions();
            $order->product_mrp = $product->mrp;
            $order->qty = $cart->quantity;
            $order->price_sum = $cart->getPriceSumWithConditions() - ($coupon_discount + $reward_point_discount + $user_credits_discount);
            $order->size = $cart->attributes->size;
            $order->color = $cart->attributes->color;

            $order->g_plus = $cart->attributes->g_plus;
            $order->cost_per_g = $cart->attributes->cost_per_g;
            $order->requirement_document = $requirementdocument;

            $order->customized_image = $customizedimage;
            $order->original_file = $originalfile;

            $order->order_value = $ordervalue;
            $order->order_discount = $discount;
            $order->order_deliverycharges = $shipping;
            $order->order_subtotal = $fsubtotal;
            $order->order_tax = $tax;
            $order->order_total = $ftotal;
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
            $order->exp_delivery_date = date('Y-m-d', strtotime(Session::get('etd')));

            $order->used_reward_points = request()->redeemed_reward_points ?? 0;
            $order->used_user_credits = request()->redeemed_credits ?? 0;
            $order->save();

            if ($reward_point_discount > 0) {
                auth()->user()->decrement('reward_points', $reward_point_discount);
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
                auth()->user()->decrement('credits', $user_credits_discount);
                //make log `
                $reward_point = new UserCreditLog();
                $reward_point->user_id = auth()->user()->id;
                $reward_point->order_id = $order->id;
                $reward_point->type = 'out';
                $reward_point->amount = $user_credits_discount;
                $reward_point->closing_bal = auth()->user()->credits;
                $reward_point->save();
            }


            if(Config::get('icrm.stock_management.feature') == 1)
            {
                if(Config::get('icrm.product_sku.color') == 1)
                {
                    $updatestock = Productsku::where('product_id', $cart->attributes->product_id)->where('color', $cart->attributes->color)->where('size', $cart->attributes->size)->first();
                }else{
                    $updatestock = Productsku::where('product_id', $cart->attributes->product_id)->where('size', $cart->attributes->size)->first();
                }


                $updatestock->update([
                    'available_stock' => $updatestock->available_stock - $cart->quantity,
                ]);
            }
        }

        //100% reward points on first order
        if (!auth()->user()->is_first_shopping) {
            auth()->user()->increment('reward_points', $ftotal);
            Auth::user()->update(['is_first_shopping' => 1]);

            //make log
            $reward_point = new RewardPointLog();
            $reward_point->user_id = auth()->user()->id;
            $reward_point->order_id = $orderid;
            $reward_point->type = 'in';
            $reward_point->amount = $ftotal;
            $reward_point->closing_bal = auth()->user()->reward_points;
            $reward_point->save();
        }

        // send order sms & email
        try {

            if(Config::get('icrm.sms.msg91.feature') == 1)
            {

                if(!empty(auth()->user()->mobile))
                {
                    if(!empty(Config::get('icrm.sms.msg91.order_placed_flow_id')))
                    {
                        // SEND ORDER PLACED SMS TO CUSTOMER
                        $mobile = '91'.Session::get('phone');
                        $response = Msg91::sms()->to($mobile)
                        ->flow(Config::get('icrm.sms.msg91.order_placed_flow_id'))
                        ->variable('name', auth()->user()->name)
                        ->variable('orderid', $orderid)
                        ->variable('url', route('trackingurl', ['id' => $orderid]))
                        ->send();
                    }

                }
            }

            // SEND ORDER PLACED EMAIL TO CUSTOMER
            $this->orderemail($order);

            // echo 'done';
        } catch (\Craftsys\Msg91\Exceptions\ValidationException $e) {
            // issue with the request e.g. token not provided
            // echo 'issue with the request e.g. token not provided';
        } catch (\Craftsys\Msg91\Exceptions\ResponseErrorException $e) {
            // error thrown by msg91 apis or by http client
            // echo 'error thrown by msg91 apis or by http client';
        } catch (\Exception $e) {
            // something else went wrong
            // plese report if this happens :)
            // echo 'something else went wrong';
        }



        \Cart::session($userID)->clear();


        \Cart::session($userID)->removeCartCondition('coupon');
        \Cart::session($userID)->removeCartCondition('shipping');
        \Cart::session($userID)->removeCartCondition('tax');
        Session::remove('ordermethod');
        Session::remove('acceptterms');
        Session::remove('deliverypincode');
        Session::remove('shippingcharges');
        Session::remove('appliedcouponcode');
        Session::remove('deliveryavailable');
        Session::remove('etd');
        Session::remove('redeemedRewardPoints');
        Session::remove('redeemedCredits');


    }


    private function orderemail($order)
    {
        // send order placed email
        Notification::route('mail', auth()->user()->email)->notify(new PrepaidOrderEmail($order));

        if(Config::get('icrm.site_package.multi_vendor_store') == 1)
        {
            $vendorinfo = User::where('id', $order->vendor_id)->first();

            if(!empty($vendorinfo->email))
            {
                // Send order notification to vendor
                Notification::route('mail', $vendorinfo->email)->notify(new PrepaidOrderEmailToVendor($order));
            }

        }
    }




    /**
         * API URLs
            * Demo: https://demodashboardapi.shipsy.in/api/client/integration/consignment/cancellation
            * Production: https://app.shipsy.in/api/client/integration/consignment/cancellation
         * api-key
            * Demo: eb6e38f684ef558a1d64fcf8a75967
            * Live: 1d7458885d42002edc2f29e7162049
         * Content-Type: application/json
         * Method: POST
    */
    public function dtdcordercancellation(Request $request)
    {
        // Dummy Curl Request to call api
       /**
        * Check if the order awb holds any of the orders which has customized product type
        */

        $orderstatus = Order::where('order_awb', $request->order_awb)->whereIn('order_status', ['New order', 'Under manufacturing'])->get();

        if(isset($orderstatus))
        {
            if(count($orderstatus) == 0)
            {
                Session::flash('warning', 'Your order is already schedulled for shipping and can not to cancelled. Order ID:'.$request->order_id.'.');

                return redirect()->route('myorders');
            }
        }

        $customized = Order::where('order_awb', $request->order_awb)->where('type', 'customized')->get();

        if(isset($customized))
        {
            if(count($customized) > 0)
            {
                Session::flash('warning', 'You can not request cancellation for orders which has customized products. Order ID:'.$request->order_id.'.');

                return redirect()->route('myorders');
            }
        }




        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.shipsy.in/api/client/integration/consignment/cancellation",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>
        "
            {
                \n\t\"AWBNo\":[\"$request->order_awb\"],
                \n\t\"customerCode\":\t\"PL2435\"\n\t
            }
        "
        ,
        CURLOPT_HTTPHEADER => array(
        "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
        // "Postman-Token: c096d7ba-830d-440a-9de4-10425e62e52f",
        "api-key: 1d7458885d42002edc2f29e7162049",
        "cache-control: no-cache",
        // "customerId: 259",
        // "organisation-id: 1",
        'Content-Type: application/json',
        ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        // echo "cURL Error #:" . $err;
            Session::flash('danger', $err);
            return redirect()->route('myorders');
        } else {
        // echo $response;
        // dd($response);
            $collection = json_encode(collect($response));
            $collection = json_decode(json_decode($collection)[0]);

            if(collect($collection)['success'] == false)
            {
                Session::flash('danger', 'Cancelation request failed for order '.$request->order_id.'. Please contact '.env('APP_NAME').'.');
                // return;

                // error message by DTDC
                // collect($collection)['failures'][0]->message

                return redirect()->route('myorders');
            }else{
                // update in database
                Order::where('order_awb', $request->order_awb)->update([
                    'order_status' => 'Cancelled'
                ]);
                // send email notification to customer

                // show alert on frontend
                Session::flash('success', 'Order successfully cancelled for order id '.$request->order_id.'.');

                return redirect()->route('myorders');
            }

        }



    }






}
