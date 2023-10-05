<?php

namespace App\Http\Controllers;

use App\Order;
use App\Models\Product;
use Jorenvh\Share\Share;
use Illuminate\Http\Request;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class myorderscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myorders = Order::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->with('product')->get();
        
        // update order status with shipping provider
        $this->shippingstatus($myorders);

        return view('myorders.all')->with([
            'myorders' => $myorders
        ]);
        
    }

    private function shippingstatus($myorders)
    {

        if(Config::get('icrm.shipping_provider.shiprocket') == 1)
        {
            $this->getshiprocketorderstatus($myorders);
        }

        if(Config::get('icrm.shipping_provider.dtdc') == 1)
        {
            $this->getdtdcorderstatus($myorders);
        }

    }

    private function getshiprocketorderstatus($myorders)
    {
        $myorders = $myorders
            ->whereNotIn('order_status', ['New Order', 'Under Manufacturing', 'Scheduled For Pickup', 'Delivered', 'Cancelled'])
            ->where('shipping_provider', 'Shiprocket')
            ->where('order_awb', '!=', null)
            ->where('shipping_id', '!=', null);

            foreach($myorders as $order)
            {
                // dd($order);
                $token =  Shiprocket::getToken();
                $response = Shiprocket::track($token)->throwShipmentId($order->shipping_id);
    
    
    
                if(isset(json_decode($response)->tracking_data->track_url))
                {
                    $order->update([
                        'tracking_url' => json_decode($response)->tracking_data->track_url,
                    ]);
                }
    
                
                if(isset(json_decode($response)->tracking_data->shipment_track))
                {

                    $currentstatus = strtoupper(json_decode($response)->tracking_data->shipment_track[0]->current_status);

                    if(
                        $currentstatus == 'OUT FOR PICKUP' 
                        OR $currentstatus == 'AWB ASSIGNED'
                        OR $currentstatus == 'LABEL GENERATED'
                        OR $currentstatus == 'PICKUP SCHEDULED' 
                        OR $currentstatus == 'PICKUP GENERATED' 
                        OR $currentstatus == 'PICKUP QUEUED' 
                        OR $currentstatus == 'MANIFEST GENERATED'
                        )
                    {
                        $order->update([
                            'order_status' => 'Ready To Dispatch',
                            'order_substatus' => '',
                        ]);
                    }
        
                    if(
                        $currentstatus == 'SHIPPED' 
                        OR $currentstatus == 'IN TRANSIT' 
                        OR $currentstatus == 'OUT FOR DELIVERY' 
                        OR $currentstatus == 'PICKED UP'
                        )
                    {
                        $order->update([
                            'order_status' => 'Shipped',
                            'order_substatus' => '',
                        ]);
                    }
        
                    if($currentstatus == 'CANCELLED')
                    {
                        $order->update([
                            'order_status' => 'Cancelled',
                            // 'order_substatus' => '',
                        ]);
                    }
        
                    if($currentstatus == 'DELIVERED')
                    {
                        $order->update([
                            'order_status' => 'Delivered',
                            'order_substatus' => '',
                        ]);
                    }
        
        
                    if($currentstatus == 'RTO INITIATED')
                    {
                        $order->update([
                            'order_status' => 'Request For Return',
                            'order_substatus' => '',
                        ]);
                    }
        
        
                    if($currentstatus == 'RTO DELIVERED')
                    {
                        $order->update([
                            'order_status' => 'Returned',
                            'order_substatus' => '',
                        ]);
                    }
        
        
        
                    if(
                        $currentstatus != 'OUT FOR PICKUP'
                        AND $currentstatus != 'AWB ASSIGNED'
                        AND $currentstatus != 'LABEL GENERATED'
                        AND $currentstatus != 'PICKUP SCHEDULED'
                        AND $currentstatus != 'PICKUP GENERATED'
                        AND $currentstatus != 'PICKUP QUEUED'
                        AND $currentstatus != 'MANIFEST GENERATED'
                        AND $currentstatus != 'SHIPPED'
                        AND $currentstatus != 'IN TRANSIT'
                        AND $currentstatus != 'OUT FOR DELIVERY'
                        AND $currentstatus != 'PICKED UP'    
                        AND $currentstatus != 'CANCELLED'
                        AND $currentstatus != 'DELIVERED'
                        AND $currentstatus != 'RTO INITIATED'
                        AND $currentstatus != 'RTO DELIVERED'
                    ){
                        $order->update([
                            'order_status' => 'Other',
                            'order_substatus' => $currentstatus,
                        ]);
                    }

                }
    
                
            }
    }

    private function getdtdcorderstatus($myorders)
    {
        $myorders = $myorders
            ->whereNotIn('order_status', ['New Order', 'Under Manufacturing', 'Scheduled For Pickup', 'Delivered', 'Cancelled'])
            ->where('shipping_provider', 'DTDC')
            ->where('order_awb', '!=', null);

        foreach($myorders as $order)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://blktracksvc.dtdc.com/dtdc-api/rest/JSONCnTrk/getTrackDetails",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => 
            "
                {
                    \n\t\"TrkType\":\t\"cnno\",
                    \n\t\"strcnno\":\t\"$order->order_awb\",
                    \n\t\"addtnlDtl\":\t\"Y\"\n\t
                }
            "
                ,
            CURLOPT_HTTPHEADER => array(
            // "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
            // "Postman-Token: c096d7ba-830d-440a-9de4-10425e62e52f",
            // "api-key: eb6e38f684ef558a1d64fcf8a75967",
            // "cache-control: no-cache",
            // "customerId: 259",
            // "organisation-id: 1",
            // "x-access-token: PL2435_trk:a1f86859bcb68b321464e07f159e9747",
            "x-access-token: RO798_trk:bcddd52dd9f433c94376480fca276d9b",
            'Content-Type: application/json',
            ),
            ));


            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                // error
                return;
            } else {
                $collection = json_encode(collect($response));
                $collection = json_decode($collection);
                $collection = collect(json_decode($collection[0]));
                
                if(json_decode($collection)->status == 'SUCCESS')
                {
                    // update shipment status accordingly
                    
                    if(json_decode($collection)->trackHeader->strStatus == 'In Transit' OR json_decode($collection)->trackHeader->strStatus == 'Softdata Upload')
                    {
                        $order->update([
                            'order_status' => 'Shipped',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'Cancelled' OR json_decode($collection)->trackHeader->strStatus == 'CANCELLED')
                    {
                        $order->update([
                            'order_status' => 'Cancelled',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'Shipped' OR json_decode($collection)->trackHeader->strStatus == 'SHIPPED')
                    {
                        $order->update([
                            'order_status' => 'Shipped',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'Delivered' OR json_decode($collection)->trackHeader->strStatus == 'DELIVERED')
                    {
                        $order->update([
                            'order_status' => 'Delivered',
                            'order_substatus' => ''
                        ]);
                    }

                    if(json_decode($collection)->trackHeader->strStatus == 'RTO')
                    {
                        $order->update([
                            'order_status' => 'RTO',
                            'order_substatus' => ''
                        ]);
                    }

                    if(
                        json_decode($collection)->trackHeader->strStatus != 'RTO' AND 
                        json_decode($collection)->trackHeader->strStatus != 'Delivered' AND
                        json_decode($collection)->trackHeader->strStatus != 'DELIVERED' AND
                        json_decode($collection)->trackHeader->strStatus != 'Shipped' AND
                        json_decode($collection)->trackHeader->strStatus != 'SHIPPED' AND
                        json_decode($collection)->trackHeader->strStatus != 'Cancelled' AND
                        json_decode($collection)->trackHeader->strStatus != 'CANCELLED' 
                        AND json_decode($collection)->trackHeader->strStatus != 'In Transit'
                        AND json_decode($collection)->trackHeader->strStatus != 'Softdata Upload'
                    ){
                        $order->update([
                            'order_status' => 'Other',
                            'order_substatus' => json_decode($collection)->trackHeader->strStatus,
                        ]);
                    }


                }

            }
        }


        return;
    }


    public function ordercomplete()
    {
        $myorders = Order::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->with('product')->get();

        // update order status with shipping provider
        $this->shippingstatus($myorders);

        return view('bag.ordercomplete');
    }

    public function downloadinvoice(Request $request)
    {
        $orders = Order::where('order_id', $request->id)->get();

        if(count($orders) == 0)
        {
            return abort('404');
        }

        // set_time_limit(0);

        // fetch seller info
        if(Config::get('icrm.site_package.multi_vendor_store') == 1)
        {
            $client = new Party([
                'name'          => setting('seller-name.name'),
                // 'address'       => $orders->first()->pickup_streetaddress1.' '.$orders->first()->pickup_streetaddress2.' '.$orders->first()->pickup_pincode.' '.$orders->first()->pickup_city.' '.$orders->first()->pickup_state.' '.$orders->first()->pickup_country,
                // 'phone'         => setting('seller-name.phone'),
                'custom_fields' => [
                    'Email'     => setting('seller-name.email'),
                    // 'GST'        => setting('seller-name.gst_number'),
                    // 'PAN'        => setting('seller-name.pan_number'),
                ],
            ]);
        }else{
            $client = new Party([
                'name'          => setting('seller-name.name'),
                'address'       => $orders->first()->pickup_streetaddress1.' '.$orders->first()->pickup_streetaddress2.' '.$orders->first()->pickup_pincode.' '.$orders->first()->pickup_city.' '.$orders->first()->pickup_state.' '.$orders->first()->pickup_country,
                'phone'         => setting('seller-name.phone'),
                'custom_fields' => [
                    'Email'     => setting('seller-name.email'),
                    'GST'        => setting('seller-name.gst_number'),
                    'PAN'        => setting('seller-name.pan_number'),
                ],
            ]);
        }

        
        
        $customer = new Party([
            'name'          => $orders->first()->customer_name,
            'address'       => $orders->first()->dropoff_streetaddress1.' '.$orders->first()->dropoff_streetaddress2.' '.$orders->first()->dropoff_pincode.' '.$orders->first()->dropoff_city.' '.$orders->first()->dropoff_state.' '.$orders->first()->dropoff_country,
            'phone'         => $orders->first()->customer_contact_number,
            'custom_fields' => [
                'company' => $orders->first()->company_name,
                'email' => $orders->first()->customer_email,
                'customer id' => substr(setting('site.title'), 0,1).''.auth()->user()->id,
                'order number' => $orders->first()->order_id,
                'payment method' => $orders->first()->order_method,
                'gst' => $orders->first()->gst_number,
            ],
        ]);
        
        $items = [];
        
        foreach($orders as $item)
        {

            if(Config::get('icrm.site_package.multi_vendor_store') == 1)
            {
                if(!empty($item->vendor_id))
                {
                    $vendor =  'Vendor:'.$item->product->vendor->brand_name.', ';

                    if(!empty($item->product->vendor->gst_number))
                    {
                        $vendorgst =  'GST Number:'.$item->product->vendor->gst_number.', ';
                    }else{
                        $vendorgst = '';    
                    }
                    
                }else{
                    $vendor =  '';
                    $vendorgst = '';
                }
            }else{
                $vendor = '';
                $vendorgst = '';
            }

            if(!empty($item->color) AND $item->color != 'NA')
            {
                $color = 'Color:'.$item->color;
            }else{
                $color = '';
            }

            if(!empty($item->size) AND $item->size != 'NA')
            {
                if(!empty($color)){
                    $sizebeforespace = ', ';
                }else{
                    $sizebeforespace = '';
                }
                $size = $sizebeforespace.'Size:'.$item->size;
            }else{
                $size = '';
            }

            if(!empty($item->g_plus) AND $item->g_plus != 'NA')
            {
                if(!empty($size)){
                    $qplusbeforespace = ', ';
                }else{
                    $qplusbeforespace = '';
                }
                $g_plus = $qplusbeforespace.'G+:'.$item->g_plus.', ';
            }else{
                $g_plus = '';
            }

            if(!empty($item->product->productsubcategory->hsn) AND $item->product->productsubcategory->hsn != 'NA')
            {
                $hsn = ', Hsn:'.$item->product->productsubcategory->hsn;
            }else{
                $hsn = '';
            }

            if(!empty($item->type) AND $item->type != 'NA')
            {
                $type = ', Type:'.$item->type;
            }else{
                $type = '';
            }

            if(!empty($item->product->productsubcategory->gst) AND $item->product->productsubcategory->gst != 'NA')
            {
                $hsntaxperc =  ', '.Config::get('icrm.tax.name').':'.$item->product->productsubcategory->gst.'%';
            }else{
                $hsntaxperc =  '';
            }

            $description = $vendor.$color.$size.$g_plus.$hsn.$type.$hsntaxperc.$vendorgst;


            $items[] = (new InvoiceItem())
                ->title($item->product->name)
                ->description($description)
                ->pricePerUnit(number_format((float)$item->product_offerprice, 2, '.', ''))
                ->quantity($item->qty);
                // ->discount(10);
        }


        $notes = [
            'This is a computer generated invoice and does not require any signature'
        ];

        $notes = implode("<br>", $notes);

        if(empty($orders->first()->order_discount) AND $orders->first()->order_discount == 0){
            $orderdiscount = number_format(0, 2);
        }else{
            $orderdiscount = json_decode($orders->first()->order_discount);
        };

        // dd($orderdiscount);
        // dd($orders->first()->order_deliverycharges);
        

        $invoice = Invoice::make('Order Receipt')
            // ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            // ->status('paid')
            // ->sequence(667)
            // ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date($orders->first()->created_at)
            ->dateFormat('d/M/Y')
            // ->payUntilDays(14)
            ->currencySymbol('₹')
            ->currencyCode('INR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($request->order_id)
            ->addItems($items)
            ->notes($notes)
            ->shipping($orders->first()->order_deliverycharges)
            ->ordertype($orders->first()->type)
            ->totalDiscount($orderdiscount)
            ->orderValue($orders->first()->order_value)
            ->subTotal($orders->first()->order_subtotal)
            ->totalTaxes($orders->first()->order_tax)
            ->finalTotal($orders->first()->order_total)
            ->logo(setting('order-invoice.logo_url'));
            // ->logo(url('storage/'.setting('site.logo')))
            // You can additionally save generated invoice to configured disk
            // ->save('order_invoices');

        $url = $invoice->url();
        // dd('a');
        return $invoice->stream();
        // $updateinvoiceurl = Order::where('order_id', $this->orderid)->update([
        //     'invoice_url' => $url,
        // ]);
    }


    public function orderproduct($id, $slug)
    {
        Session::remove('quickviewid');

        /**
         * Check if the order is for the authenticated user
         * If not then abort 404
         */
        $order = Order::where('order_id', $id)->where('user_id', auth()->user()->id)->first();

        if(empty($order))
        {
            return abort(404);
        }
        
        $product = Product::where('slug', $slug)->first();

        if(empty($product))
        {
            return abort(404);
        }
    
        $relatedproducts = Product::where('admin_status', 'Accepted')->where('subcategory_id', $product->subcategory_id)->take(8)->get();


        
        $shareComponent = \Share::page(
            route('product.slug', ['slug' => $product->slug]),
            $product->description,
        )
        ->facebook()
        ->linkedin()
        ->whatsapp();
        
        $previous = '';
        $next = '';
        
        /**
         * If the product color is sku
         * Check if the url does has color
         * Redirect to product.slug.color first color
         */
        if(Config::get('icrm.product_sku.color') == 1)
        {
            if(empty(request('color')))
            {
                if(count($product->productcolors) > 0)
                {
                    // return redirect()->route('product.slug', ['slug' => $product->slug, 'color' => $product->productcolors[0]->name]);
                }
            }
        }

        return view('product')->with([
            'product' => $product,
            // 'morecolors' => $morecolors,
            'relatedproducts' => $relatedproducts,
            'shareComponent' => $shareComponent,
            'previous' => $previous,
            'next' => $next
        ]);
    }

}
