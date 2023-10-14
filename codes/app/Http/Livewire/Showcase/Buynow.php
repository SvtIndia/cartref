<?php

namespace App\Http\Livewire\Showcase;

use App\Coupon;
use App\Models\RewardPointLog;
use App\Models\User;
use App\Models\UserCreditLog;
use App\Order;
use App\Showcase;
use App\Productsku;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Darryldecode\Cart\Cart;
use App\DeliveryServicableArea;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ShowcasePurchasedEmail;

class Buynow extends Component
{
    public $deliveryavailability = false;
    public $deliverypincode;
    public $city;
    public $orderid;

    public $ordervalue;
    public $showcaserefund;
    public $subtotal;
    public $tax;
    public $total;

    public $disablebtn = true;

    protected $name;
    protected $email;
    protected $phone;

    public $totalMrp;
    public $totalSave;

    public $buyshowcases;
    public $couponcode;
    public $coupons;
    public $discount;
    public $showcase_redeemedRewardPoints;
    public $showcase_redeemedCredits;

    public $user;

    protected $listeners = ['showcasebag' => 'render'];

    public function mount()
    {
        $this->orderid = request('id');
        $this->deliverypincode = Session::get('deliverypincode');
        // fetch applied coupon code in the code
        $this->couponcode = Session::get('showcase_appliedcouponcode');

        if (auth()->user()->hasRole(['admin', 'Client', 'Delivery Head', 'Delivery Boy'])) {
            $showcase = Showcase::where('order_id', $this->orderid)->whereIn('order_status', ['Moved to Bag', 'Showcased'])->first();
        } else {
            $showcase = Showcase::where('order_id', $this->orderid)->where('user_id', auth()->user()->id)->where('order_status', 'Moved to Bag')->first();
        }


        if (!empty($showcase)) {
            $this->rname = $showcase->customer_name;
            $this->remail = $showcase->customer_email;
            $this->rphone = $showcase->customer_contact_number;
        } else {
            return redirect()->route('showcase.myorders')->with([
                'success' => 'This Showroom order has already being closed!'
            ]);
        }

    }

    public  function  calcTotal(){
        $this->ordervalue = $this->buyshowcases->sum('product_offerprice');
        if(Config::get('icrm.showcase_at_home.delivery_charges') && $this->user->used_showcase_refund < 3){
            $this->showcaserefund = Config::get('icrm.showcase_at_home.delivery_charges');
        }
        else{
            $this->showcaserefund = 0;
        }
        $this->subtotal = $this->ordervalue - $this->showcaserefund - $this->discount - $this->showcase_redeemedRewardPoints - $this->showcase_redeemedCredits;

        $this->tax = $this->subtotal * Config::get('icrm.tax.fixedtax.perc') / 100;
        if ($this->subtotal < 0) {
            $this->subtotal = 0;
        }
        if ($this->tax < 0) {
            $this->tax = 0;
        }

        $this->total = $this->subtotal + $this->tax;
    }

    public function render()
    {
        $buyshowcases = Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->get();
        if($buyshowcases && count($buyshowcases) > 0){
            $this->buyshowcases = $buyshowcases;
            $this->user = User::find($buyshowcases[0]->user_id);
        }
        else{
            abort(404);
        }

        //calculate before all discounts
        $this->calcTotal();

        //fetch applied coupon code
        if ((int)$this->discount <= 0 && !empty(Session::get('showcase_appliedcouponcode'))) {
            $this->applycoupon();
        }
        //fetch applied reward point
        if (empty($this->showcase_redeemedRewardPoints) && Session::get('showcase_redeemedRewardPoints')) {
            $this->applyRewardPoints();
        }
        //fetch applied wallet credits
        if (empty($this->showcase_redeemedCredits) && Session::get('showcase_redeemedCredits')) {
            $this->applyCredits();
        }

        //calculate after applied all discounts
        $this->calcTotal();

        $sellers = [];
        $this->totalMrp = 0;
        foreach ($this->buyshowcases as $sc) {
            $product = Product::where('id', $sc->product_id)->first();
            $this->totalMrp += $product->mrp * 1;
            array_push($sellers, User::find($product->seller_id));
        }
        $now = date('Y-m-d');
        $coupons = Coupon::where('status', 1)->where('from', '<=', $now)->where('to', '>=', $now)->get();

        $this->totalSave = ($this->totalMrp - $this->ordervalue) + $this->discount;

            //fetch all coupons list
        foreach ($coupons as $coupon) {
            $coupon->is_applicable = false;
            $coupon->applicable_discount = 0;
            $coupon->not_applicable_error = '';

            if ($this->ordervalue >= $coupon->min_order_value) {
                if ($coupon->is_coupon_for_all || $coupon->hasSellers($sellers)) {
                    if ($coupon->is_uwc || $this->showcase_redeemedRewardPoints <= 0) {

                        $coupon->is_applicable = true;

                        // 1. Percentage off
                        if ($coupon->type == 'PercentageOff') {
                            $value = $this->ordervalue * ($coupon->value / 100);
                        }

                        // 2. Fixed off
                        if ($coupon->type == 'FixedOff') {
                            $value = $coupon->value;
                        }

                        $coupon->applicable_discount = $value ?? 0;
                    } else {
                        $coupon->not_applicable_error = 'Not applicable with reward points.';
                    }
                } else {
                    $coupon->not_applicable_error = 'Can not use with cart products';
                }
            }
        }
        $this->coupons = $coupons;

        if (Session::get('showcasebagacceptterms') != true) {
            // 
            $this->disablebtn = true;
        } else {
            $this->disablebtn = false;
        }

        return view('livewire.showcase.buynow')->with([
            'buyshowcases' => $buyshowcases,
        ]);
    }


    public function removeShowcaseBag($showcaseid)
    {
        Showcase::where('id', $showcaseid)->update([
            'order_status' => 'New Order',
        ]);

        $buyshowcases = Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->get();

        if (count($buyshowcases) == 0) {
            return redirect()->route('showcase.ordercomplete', $this->orderid);
        } else {
            return redirect()->back();
        }


    }

    public function applyDirectCoupon($code)
    {
        $this->couponcode = $code;
        $this->applycoupon();
    }

    public function applycoupon()
    {
        if (!empty($this->couponcode)) {
            $this->discount = 0;
            Session::remove('showcase_appliedcouponcode');

            $coupon = Coupon::where('code', $this->couponcode)->where('user_email', null)->first();
            /**
             * If the coupon is empty on above result then maybe user has unique coupon for his account
             */
            if (empty($coupon)) {
                $coupon = Coupon::where('code', $this->couponcode)->where('user_email', auth()->user()->email)->first();
            }
            if (!empty($coupon)) {
                //check coupon is applicable for cart products
                $sellers = [];
                $buyshowcases = Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->get();
                foreach ($buyshowcases as $sc) {
                    $product = Product::where('id', $sc->product_id)->first();
                    array_push($sellers, User::find($product->seller_id));
                }

                if (!$coupon->is_coupon_for_all && !$coupon->hasSellers($sellers)) {
                    $this->dispatchBrowserEvent('showToast', ['msg' => 'Coupon can not be applied with cart products', 'status' => 'error']);
                    return;
                }

                //check coupon is applied reward points
                if ($this->showcase_redeemedRewardPoints > 0 && !$coupon->is_uwc) {
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

                    /**
                     * check if there is minimum order value exists in coupon
                     * If minimum order value exists then check if the subtotal is lesser than order value and show error
                    */
                    if (!empty($coupon->min_order_value)) {
                        // min order value exists
                        if ($this->ordervalue < $coupon->min_order_value) {
                            // show error message when the subtotal is lesser than order value
                            $this->dispatchBrowserEvent('showToast', ['msg' => 'Coupon is valid only for orders above ' . Config::get('icrm.currency.icon') . $coupon->min_order_value, 'status' => 'warning']);
                        }
                    }

                    // get the discount amount according to the coupon type calculation and apply coupon condition
                    Session::remove('showcase_appliedcouponcode');

                    // 1. Percentage off
                    if ($coupon->type == 'PercentageOff') {
                        $value = $this->ordervalue * ($coupon->value / 100);
                        $this->discount = $value ?? 0;
                    }
                    // 2. Fixed off
                    if ($coupon->type == 'FixedOff') {
                        $value = $coupon->value;
                        $this->discount = $value ?? 0;
                    }
                    Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->update(['is_discount_applied' => true]);

//                    if(isset($this->coupons) && is_array($this->coupons) && count($this->coupons) > 0){
//                        $this->coupons->where('code', $coupon->code);
//                    }
                    Session::put('showcase_appliedcouponcode', $coupon->code);
                    $this->dispatchBrowserEvent('showToast', ['msg' => 'Coupon code "' . $this->couponcode . '" successfully applied', 'status' => 'success']);
                    $this->calcTotal();
                } else {
                    // coupon expired
                    $this->dispatchBrowserEvent('showToast', ['msg' => 'Coupon code "' . $this->couponcode . '" expired', 'status' => 'danger']);
                }
            } else {
                // coupon does not exists
                $this->dispatchBrowserEvent('showToast', ['msg' => 'Invalid coupon code "' . $this->couponcode . '"', 'status' => 'danger']);
            }
        }
    }

    public function removecoupon()
    {
        $this->discount = 0;
        Session::remove('showcase_appliedcouponcode');
        Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->update(['is_discount_applied' => false]);
        $this->dispatchBrowserEvent('showToast', ['msg' => 'Coupon successfully removed', 'status' => 'success']);
    }

    public function redeemRewardPoints()
    {
        if (Session::get('showcase_redeemedRewardPoints')) {
            Session::remove('showcase_redeemedRewardPoints');
            Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->update(['is_reward_point_applied' => false]);
            $this->showcase_redeemedRewardPoints = 0;
            return;
        }

        Session::remove('showcase_redeemedRewardPoints');
        $this->showcase_redeemedRewardPoints = 0;
        $this->applyRewardPoints();

    }

    private function applyRewardPoints()
    {
        if (auth()->user()->reward_points > 0 && $this->ordervalue >= 1500) {
            $this->showcase_redeemedRewardPoints = auth()->user()->reward_points * 0.20;
            Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->update(['is_reward_point_applied' => true]);
            Session::put('showcase_redeemedRewardPoints', 1);
        }
    }

    public function redeemCredits()
    {
        if (Session::get('showcase_redeemedCredits')) {
            Session::remove('showcase_redeemedCredits');
            Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->update(['is_credit_applied' => false]);
            $this->showcase_redeemedCredits = 0;
            return;
        }

        Session::remove('showcase_redeemedCredits');
        $this->showcase_redeemedCredits = 0;

        $this->applyCredits();

    }

    private function applyCredits()
    {
        $userCredits = auth()->user()->credits;
        if ($userCredits > 0) {
            if ($userCredits >= $this->subtotal) {
                $this->showcase_redeemedCredits = $this->subtotal;
                Session::put('showcasebagordermethod', 'cod');
            } else {
                $this->showcase_redeemedCredits = $userCredits;
            }
            Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->update(['is_credit_applied' => true]);
            Session::put('showcase_redeemedCredits', 1);
        }
    }
    public function scodneeded()
    {
        if (Session::get('showcasebagordermethod') == 'cod') {
            Session::remove('showcasebagordermethod');
        } else {
            if(auth()->user()->hasRole(['Delivery Boy', 'Delivery Head', 'admin', 'Client'])){
                $flag = 0;
                foreach ($this->buyshowcases as $item){
                    if($item->is_discount_applied || $item->is_reward_point_applied || $item->is_credit_applied){
                        $flag = 1;
                        break;
                    }
                }
                if($flag){
                    $this->dispatchBrowserEvent('showToast', ['msg' => 'Customer has applied some coupon or cashback', 'status' => 'error']);
                    return;
                }else{
                    Session::put('showcasebagordermethod', 'cod');
                }
            }
        }
    }

    public function sacceptterms()
    {
        if (Session::get('showcasebagacceptterms') == true) {
            Session::remove('showcasebagacceptterms');
        } else {
            Session::put('showcasebagacceptterms', true);
        }
    }

    public function placeorder()
    {
        /**
         * If order total is 0 then show error message
         */
        if ($this->showcase_redeemedRewardPoints <= 0 && $this->showcase_redeemedCredits <= 0 && $this->total <= 0) {
            Session::flash('danger', 'Order total cannot be zero');
            return redirect()->route('showcase.buynow', ['id' => $this->orderid]);
        }

        if (Session::get('showcasebagordermethod') == 'cod') {
            // cash on delivery
            $this->carttoorder();
        } else {
            // online payment
            $this->collectpayment();
        }

    }

    private function collectpayment()
    {
        Session::remove('sordervalue');
        Session::remove('sshowcaserefund');
        Session::remove('ssubtotal');
        Session::remove('stax');
        Session::remove('stotal');

        /**
         * Catch payment with the payment gateway and redirect with payment info & status
         */
        $this->razorpay();
    }

    public function razorpay()
    {
        // run javascript code from checkout.blade.php
        Session::put('sordervalue', $this->ordervalue);
        Session::put('sshowcaserefund', $this->showcaserefund);
        Session::put('ssubtotal', $this->subtotal);
        Session::put('stax', $this->tax);
        Session::put('stotal', $this->total);

        $this->emit('srazorPay', $this->total, $this->showcaserefund, $this->discount, $this->showcase_redeemedRewardPoints, $this->showcase_redeemedCredits);
    }


    private function carttoorder()
    {
        if(auth()->user()->hasRole(['Delivery Boy', 'Delivery Head', 'admin', 'Client'])){
            $flag = 0;
            foreach ($this->buyshowcases as $item){
                if($item->is_discount_applied || $item->is_reward_point_applied || $item->is_credit_applied){
                    $flag = 1;
                    break;
                }
            }
            if($flag){
                $this->dispatchBrowserEvent('showToast', ['msg' => 'Customer has applied some coupon or cashback', 'status' => 'error']);
                return;
            }
        }

        // Generate random order id
        $orderid = mt_rand(100000, 999999);

        $carts = Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->get();
        $notincarts = Showcase::where('order_id', $this->orderid)->where('order_status', '!=', 'Moved to Bag')->get();

        foreach ($carts as $key => $cart) {
            //per product discount calculation
            $ratio  = ($cart->price_sum / $this->ordervalue);
            $showcase_refund = 0; $coupon_discount = 0; $reward_point_discount = 0; $user_credits_discount = 0;

            if($this->showcaserefund > 0) {
                //showcase refund discount
                $showcase_refund = round(($ratio * $this->showcaserefund), 2);
            }
            if($this->discount > 0){
                //coupon discount
                $coupon_discount = round(($ratio * $this->discount), 2);
            }
            if($this->showcase_redeemedRewardPoints > 0){
                //reward point discount uptoo 20%
                if(auth()->user()->reward_points >= $this->showcase_redeemedRewardPoints)
                    $reward_point_discount = round(($ratio * $this->showcase_redeemedRewardPoints), 2);
            }
            if($this->showcase_redeemedCredits > 0){
                //wallet credits discount
                if(auth()->user()->credits >= $this->showcase_redeemedCredits)
                    $user_credits_discount = round(($ratio * $this->showcase_redeemedCredits), 2);
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
            $order->order_value = $this->ordervalue;
            $order->order_discount = $this->discount;
            $order->order_deliverycharges = $this->showcaserefund;
            $order->order_subtotal = $this->subtotal;
            $order->order_tax = $this->tax;
            $order->order_total = $this->total;
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
            if($cart->user_id && User::find($cart->user_id)){
                $order->registered_contact_number = User::find($cart->user_id)->mobile;
            }
            $order->height = $cart->height;
            $order->length = $cart->length;
            $order->width = $cart->breadth;
            $order->weight = $cart->weight;
            $order->user_id = $cart->user_id;
            $order->order_weight = $cart->order_weight;
            $order->order_status = 'Delivered';
            $order->order_method = (($this->showcase_redeemedRewardPoints > 0 || $this->showcase_redeemedCredits > 0) && $this->total <= 0) ? 'Prepaid' : 'COD';
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

        if($this->showcase_redeemedRewardPoints > 0){
            auth()->user()->decrement('reward_points', $this->showcase_redeemedRewardPoints);
        }
        if($this->showcase_redeemedCredits > 0){
            auth()->user()->decrement('credits', $this->showcase_redeemedCredits);
        }
        if($this->showcaserefund > 0) {
            $this->user->increment('used_showcase_refund', 1);
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

        $this->orderemail($orderid);

        Session::remove('showcasebagordermethod');
        Session::remove('showcasebagacceptterms');

        Session::remove('showcase_appliedcouponcode');
        Session::remove('showcase_redeemedRewardPoints');
        Session::remove('showcase_redeemedCredits');

        Session::flash('success', 'Showcase At Home Order Successfully Placed');
        return redirect()->route('myorders');
    }


    private function orderemail($orderid)
    {
        /**
         * Send email to customer about showcase initiated
         */

        if (Config::get('icrm.showcase_at_home.showcase_purchased_email') == 1) {
            Notification::route('mail', auth()->user()->email)->notify(new ShowcasePurchasedEmail($orderid));
        }

    }
}
