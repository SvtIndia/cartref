<?php

namespace App\Http\Livewire\Bag;

use App\Order;
use App\Productsku;
use Livewire\Component;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class Ordercomplete extends Component
{
    public $orderid;
    public $items;
    public $canbecancelled = false;
    public $canbereturned = false;
    public $shiprockettoken;

    public function mount()
    {
        /**
         * Because of the checkout page with COD order it wasn't redirecting to order complete page
         * If sessiong cartnot clear is true then clear cart
         */

        if(Session::get('cartnotclear') == true)
        {
            \Cart::clear();
        }

        $this->orderid = request('id');
        if(Config::get('icrm.shipping_provider.shiprocket') == 1)
        {
            $this->shiprockettoken = Shiprocket::getToken();
        }
        Session::remove('danger');


        if(auth()->user()->hasRole(['admin']))
        {
            $this->items = Order::where('order_id', $this->orderid)->get();
        }else{
            $this->items = Order::where('order_id', $this->orderid)->where('user_id', auth()->user()->id)->get();
        }

        if(count($this->items) == 0)
        {
            return abort(404);
        }

        /**
         * Check if the order can be cancelled
         */

        // If the order has any customized item then order can be only cancelled until it is moved the under_manufacturing
        if($this->items->where('type', 'Customized')->count() > 0)
        {
            if($this->items->where('type', 'Customized')->count() > 0)
            {
                foreach($this->items->where('type', 'Customized') as $item)
                {

                    if($item->whereIn('order_status', ['Under Manufacturing', 'Ready To Dispatch', 'Shipped', 'Delivered', 'Other', 'RTO', 'Cancelled'])->count() > 0)
                    {
                        $this->canbecancelled = false;
                        break;
                    }else{
                        $this->canbecancelled = true;
                    }

                    
                }
            }
            
        }else{
            foreach($this->items as $item)
            {
                
                // If the order does not have customized item then order can be cancelled until it is ready_to_dispatch
                
                if($this->canbecancelled == false)
                {
                    if($this->items->whereIn('order_status', ['Ready To Dispatch', 'Shipped', 'Delivered', 'Other', 'RTO', 'Cancelled', 'Requested For Return', 'Return Request Accepted', 'Return Request Rejected', 'Returned'])->count() > 0)
                    {
                        $this->canbecancelled = false;
                        break;
                    }else{
                        $this->canbecancelled = true;
                    }
                }

            }
        }


        
        
        

        /**
         * Update item tracking info from shipping provider
         */
        $this->updateitemtrackinginfo();
    }

    private function updateitemtrackinginfo()
    {
        if(Config::get('icrm.shipping_provider.shiprocket') == 1)
        {
            $this->shiprockettrackorder();
        }

        if(Config::get('icrm.shipping_provider.dtdc') == 1)
        {
            $this->dtdctrackorder();
        }
    }


    private function shiprockettrackorder()
    {
        $myorders = $this->items
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
    
                    if(
                        json_decode($response)->tracking_data->shipment_track[0]->current_status == 'OUT FOR PICKUP' 
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'AWB ASSIGNED'
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'LABEL GENERATED'
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'PICKUP SCHEDULED' 
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'PICKUP GENERATED' 
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'PICKUP QUEUED' 
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'MANIFEST GENERATED'
                        )
                    {
                        $order->update([
                            'order_status' => 'Ready To Dispatch',
                            'order_substatus' => '',
                        ]);
                    }
        
                    if(
                        json_decode($response)->tracking_data->shipment_track[0]->current_status == 'SHIPPED' 
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'IN TRANSIT' 
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'OUT FOR DELIVERY' 
                        OR json_decode($response)->tracking_data->shipment_track[0]->current_status == 'PICKED UP'
                        )
                    {
                        $order->update([
                            'order_status' => 'Shipped',
                            'order_substatus' => '',
                        ]);
                    }
        
                    if(json_decode($response)->tracking_data->shipment_track[0]->current_status == 'CANCELLED')
                    {
                        $order->update([
                            'order_status' => 'Cancelled',
                            // 'order_substatus' => '',
                        ]);
                    }
        
                    if(json_decode($response)->tracking_data->shipment_track[0]->current_status == 'DELIVERED')
                    {
                        $order->update([
                            'order_status' => 'Delivered',
                            'order_substatus' => '',
                        ]);
                    }
        
        
                    if(json_decode($response)->tracking_data->shipment_track[0]->current_status == 'RTO INITIATED')
                    {
                        $order->update([
                            'order_status' => 'Request For Return',
                            'order_substatus' => '',
                        ]);
                    }
        
        
                    if(json_decode($response)->tracking_data->shipment_track[0]->current_status == 'RTO DELIVERED')
                    {
                        $order->update([
                            'order_status' => 'Returned',
                            'order_substatus' => '',
                        ]);
                    }
        
        
        
                    if(
                        json_decode($response)->tracking_data->shipment_track[0]->current_status != 'OUT FOR PICKUP'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'AWB ASSIGNED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'LABEL GENERATED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'PICKUP SCHEDULED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'PICKUP GENERATED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'PICKUP QUEUED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'MANIFEST GENERATED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'SHIPPED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'IN TRANSIT'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'OUT FOR DELIVERY'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'PICKED UP'    
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'CANCELLED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'DELIVERED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'RTO INITIATED'
                        AND json_decode($response)->tracking_data->shipment_track[0]->current_status != 'RTO DELIVERED'
                    ){
                        $order->update([
                            'order_status' => 'Other',
                            'order_substatus' => json_decode($response)->tracking_data->shipment_track[0]->current_status,
                        ]);
                    }
    
                }
    
                
            }
    }

    private function dtdctrackorder()
    {
        foreach($this->items->whereNotIn('order_status', ['New Order', 'Under Manufacturing', 'Scheduled For Pickup', 'Delivered', 'Cancelled']) as $order)
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

                // dd($collection);
                
                if(json_decode($collection)->status == 'SUCCESS')
                {
                    // update shipment status accordingly

                    if(json_decode($collection)->trackHeader->strStatus == 'Not Picked' OR json_decode($collection)->trackHeader->strStatus == 'Pickup Scheduled')
                    {
                        $order->update([
                            'order_status' => 'Ready To Dispatch',
                            'order_substatus' => ''
                        ]);
                    }
                         
                    if(json_decode($collection)->trackHeader->strStatus == 'Booked' OR json_decode($collection)->trackHeader->strStatus == 'In Transit' OR json_decode($collection)->trackHeader->strStatus == 'Softdata Upload')
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

                    if(json_decode($collection)->trackHeader->strStatus == 'Delivered' OR json_decode($collection)->trackHeader->strStatus == 'DELIVERED' OR json_decode($collection)->trackHeader->strStatus == 'OTP Based Delivered')
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
                        AND json_decode($collection)->trackHeader->strStatus != 'Not Picked'
                        AND json_decode($collection)->trackHeader->strStatus != 'Booked'
                        AND json_decode($collection)->trackHeader->strStatus != 'Pickup Scheduled'
                        AND json_decode($collection)->trackHeader->strStatus != 'OTP Based Delivered'
                    ){
                        $order->update([
                            'order_status' => 'Other',
                            'order_substatus' => json_decode($collection)->trackHeader->strStatus,
                        ]);
                    }


                }

            }
        }
    }

    public function render()
    {
        

        return view('livewire.bag.ordercomplete')->with([
            
        ]);
    }


    public function downloadinvoice()
    {
        /**
         * This function is currently not in use we are using controller function
         */
        
        // set_time_limit(0);

        // fetch seller info
        $client = new Party([
            'name'          => setting('seller-name.name'),
            'address'       => $this->items->first()->pickup_streetaddress1.' '.$this->items->first()->pickup_streetaddress2.' '.$this->items->first()->pickup_pincode.' '.$this->items->first()->pickup_city.' '.$this->items->first()->pickup_state.' '.$this->items->first()->pickup_country,
            'phone'         => setting('seller-name.phone'),
            'custom_fields' => [
                'Email'     => setting('seller-name.email'),
                'GST'        => setting('seller-name.gst_number'),
                'PAN'        => setting('seller-name.pan_number'),
            ],
        ]);
        
        

        $customer = new Party([
            'name'          => $this->items->first()->customer_name,
            'address'       => $this->items->first()->dropoff_streetaddress1.' '.$this->items->first()->dropoff_streetaddress2.' '.$this->items->first()->dropoff_pincode.' '.$this->items->first()->dropoff_city.' '.$this->items->first()->dropoff_state.' '.$this->items->first()->dropoff_country,
            'phone'         => $this->items->first()->customer_contact_number,
            'custom_fields' => [
                'email' => $this->items->first()->customer_email,
                'customer id' => substr(setting('site.title'), 0,1).''.auth()->user()->id,
                'order number' => $this->orderid,
            ],
        ]);
        
        
        $items = [];

        foreach($this->items as $item)
        {
            $items[] = (new InvoiceItem())
                ->title($item->product->name.'- '.$item->size.'- '.$item->color)
                // ->description('Your product or service description')
                ->pricePerUnit(number_format((float)$item->price_sum, 2, '.', ''))
                ->quantity($item->qty);
                // ->discount(10);
        }

        $notes = [
            // 'your multiline',
            // 'additional notes',
            // 'in regards of delivery or something else',
        ];

        $notes = implode("<br>", $notes);
        
        $invoice = Invoice::make('payment receipt')
            // ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            // ->status('paid')
            // ->sequence(667)
            // ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('d/M/Y')
            // ->payUntilDays(14)
            ->currencySymbol('₹')
            ->currencyCode('INR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($this->orderid)
            ->addItems($items)
            ->notes($notes)
            ->shipping($this->items->first()->order_deliverycharges)
            ->totalDiscount($this->items->first()->order_discount)
            ->orderValue($this->items->first()->order_value)
            ->subTotal($this->items->first()->order_subtotal)
            ->totalTaxes($this->items->first()->order_tax)
            ->finalTotal($this->items->first()->order_total)
            ->logo(setting('order-invoice.logo_url'))
            // ->logo(url('storage/'.setting('site.logo')))
            // You can additionally save generated invoice to configured disk
            ->save('order_invoices');

        $url = $invoice->url();
        // dd('a');
        return $invoice->stream();
        $updateinvoiceurl = Order::where('order_id', $this->orderid)->update([
            'invoice_url' => $url,
        ]);

    
    }




    public function cancelorder()
    {
        if($this->canbecancelled == false)
        {
            Session::flash('danger', 'This order can not be cancelled');
            return redirect()->route('ordercomplete', ['id' => $this->orderid]);
        }

        /**
         * Dont need to check if the order can be cancelled or not because the shipping provider is doing this job automatically
         * Fetch awb code and share with shipping provider to cancel order
         */

        
         /**
          * Check if the order is not scheduled with shipping partner and awb code is empty then directly update the order status to cancelled with substatus cancelled before shipping initiated
          */

        if(empty($this->items->first()->order_awb))
        {
            Order::where('order_id', $this->items->first()->order_id)->update([
                'order_status' => 'Cancelled',
                'order_substatus' => 'Cancelled before shipping initiated'
            ]);

            /**
             * Update sku qty on order cancellation
             * Fetch orders and update sku
             */

            $cancelledorders = Order::where('order_id', $this->items->first()->order_id)->get();

            foreach($cancelledorders as $cancelled)
            {
                if(Config::get('icrm.product_sku.color') == 1)
                {
                    
                    $sku = Productsku::where('product_id', $cancelled->product_id)
                            ->where('size', $cancelled->size)
                            ->where('color', $cancelled->color)
                            ->first();
                    
                    $sku->update([
                        'available_stock' => $sku->available_stock + $cancelled->qty,
                    ]);

                }else{

                    $sku = Productsku::where('product_id', $cancelled->product_id)
                            ->where('size', $cancelled->size)
                            ->first();
                    
                    $sku->update([
                        'available_stock' => $sku->available_stock + $cancelled->qty,
                    ]);
                }
            }

            Session::flash('success', 'Order with the ID number "'.$this->items->first()->order_id.'" has been successfully cancelled');
            return redirect()->route('ordercomplete', ['id' => $this->orderid]);
        }


        /**
         * Cancel order with shipping provider
         * Check which shipping provider is used on platform and proceed
         */

         if(Config::get('icrm.shipping_provider.shiprocket') == 1)
         {
            $this->shipirocketcancelorder($this->items->first()->order_awb);
         }

         if(Config::get('icrm.shipping_provider.dtdc') == 1)
         {
            $this->dtdccancelorder($this->items->first()->order_awb);
         }

    }


    private function shipirocketcancelorder($awb)
    {
        
        $ids = [$awb];
        $response =  Shiprocket::order($this->shiprockettoken)->cancel($ids);


        Order::where('order_id', $this->items->first()->order_id)->update([
            'order_status' => 'Cancelled',
            'order_substatus' => 'Cancelled after shipping initiated'
        ]);

        Session::flash('success', 'Order with the ID number "'.$this->items->first()->order_id.'" has been successfully cancelled');                
        return redirect()->route('ordercomplete', ['id' => $this->orderid]);
    }

    private function dtdccancelorder($awb)
    {
        
        
    }

}
