<?php

namespace App\Http\Livewire\Showcase;

use App\Order;
use App\Showcase;
use App\Productsku;
use App\Models\Product;
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

    protected $listeners = ['showcasebag' => 'render'];

    public function mount()
    {   
        $this->orderid = request('id');
        $this->deliverypincode = Session::get('deliverypincode');

        if(auth()->user()->hasRole(['admin', 'Client', 'Delivery Head', 'Delivery Boy']))
        {
            $showcase = Showcase::where('order_id', $this->orderid)->whereIn('order_status', ['Moved to Bag', 'Showcased'])->first();
        }else{
            $showcase = Showcase::where('order_id', $this->orderid)->where('user_id', auth()->user()->id)->where('order_status', 'Moved to Bag')->first();
        }

        
        if(!empty($showcase))
        {
            $this->rname = $showcase->customer_name;
            $this->remail = $showcase->customer_email;
            $this->rphone = $showcase->customer_contact_number;
        }else{
            return redirect()->route('showcase.myorders')->with([
                'success' => 'This showcase order has already being closed!'
            ]);
        }
        
    }


    public function render()
    {
        $buyshowcases = Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->get();

        $this->ordervalue = $buyshowcases->sum('product_offerprice');
        $this->showcaserefund = Config::get('icrm.showcase_at_home.delivery_charges');
        $this->subtotal = $this->ordervalue - $this->showcaserefund;
        
        $this->tax = $this->subtotal * Config::get('icrm.tax.fixedtax.perc') / 100;

        if($this->subtotal < 0)
        {
            $this->subtotal = 0;
        }

        if($this->tax < 0)
        {
            $this->tax = 0;
        }


        $this->total = $this->subtotal + $this->tax;

        if(Session::get('showcasebagacceptterms') != true){
            // 
            $this->disablebtn = true;
        }else{
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

        if(count($buyshowcases) == 0)
        {
            return redirect()->route('showcase.ordercomplete', $this->orderid);
        }else{
            return redirect()->back();
        }
        

    }


    public function scodneeded()
    {
        if(Session::get('showcasebagordermethod') == 'cod')
        {
            Session::remove('showcasebagordermethod');
        }else{
            Session::put('showcasebagordermethod', 'cod');
        }

        
    }

    public function sacceptterms()
    {
        if(Session::get('showcasebagacceptterms') == true)
        {
            Session::remove('showcasebagacceptterms');
        }else{
            Session::put('showcasebagacceptterms', true);
        }        
    }

    public function placeorder()
    {

        /**
         * If order total is 0 then show error message
        */

        if($this->total <= 0)
        {
            Session::flash('danger', 'Order total cannot be zero');
            return redirect()->route('showcase.buynow', ['id' => $this->orderid]);
        }


        if(Session::get('showcasebagordermethod') == 'cod')
        {
            // cash on delivery
            $this->carttoorder();
        }else{
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

        $this->emit('srazorPay');
    }

    
    private function carttoorder()
    {
        
        // Generate random order id
        $orderid = mt_rand(100000, 999999);

        $carts = Showcase::where('order_id', $this->orderid)->where('order_status', 'Moved to Bag')->get();
        $notincarts = Showcase::where('order_id', $this->orderid)->where('order_status', '!=', 'Moved to Bag')->get();

        foreach($carts as $key => $cart)
        {
            
            $product = Product::where('id', $cart->product_id)->first();

            /**
             * Fetch pickup location
             */

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


            $order = new Order;
            $order->order_id = $orderid;
            $order->type = 'Showcase At Home';
            $order->product_id = $cart->product_id;
            $order->product_sku = $cart->product->sku;
            $order->product_subcategory_id = $cart->product->subcategory_id;
            $order->product_offerprice = $cart->product_offerprice;
            $order->product_mrp = $cart->product->mrp;
            $order->qty = $cart->qty;
            $order->price_sum = $cart->price_sum;
            $order->size = $cart->size;
            $order->color = $cart->color;
            $order->order_value = $this->ordervalue;
            $order->order_discount = 0;
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
            $order->registered_contact_number = auth()->user()->mobile;
            $order->height = $cart->height;
            $order->length = $cart->length;
            $order->width = $cart->breadth;
            $order->weight = $cart->weight;
            $order->user_id = $cart->user_id;
            $order->order_weight = $cart->order_weight;
            $order->order_status = 'Delivered';
            $order->order_method = 'COD';
            $order->exp_delivery_date = date('Y-m-d');
            $order->save();


            $cart->update([
                'order_status' => 'Purchased',
                'status' => '0',
            ]);

            
        }

        foreach($notincarts as $notincart)
        {
            $notincart->update([
                'order_status' => 'Returned',
                'status' => '0',
            ]);

            if(Config::get('icrm.stock_management.feature') == 1)
            {
                if(Config::get('icrm.product_sku.color') == 1)
                {
                    $updatestock = Productsku::where('product_id', $notincart->product_id)->where('color', $notincart->color)->where('size', $notincart->size)->first();
                }else{
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

        Session::flash('success', 'Showcase At Home Order Successfully Placed');
        return redirect()->route('myorders');
    }


    private function orderemail($orderid)
    {
        /**
         * Send email to customer about showcase initiated
         */

        if(Config::get('icrm.showcase_at_home.showcase_purchased_email') == 1)
        {
            Notification::route('mail', auth()->user()->email)->notify(new ShowcasePurchasedEmail($orderid));
        }
        
    }
}
