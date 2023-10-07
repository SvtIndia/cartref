<?php

namespace App\Http\Controllers;

use App\Order;
use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class DownloadLabelController extends Controller
{

    public function downloadlabel(Request $request)
    {
        // dd($request->all());
        $order = Order::where('id', $request->id)->first();

        if(empty($order->shipping_label))
        {
            return redirect()->back()->with([
                'message' => "Shipping label is not readable.",
                'alert-type' => 'error',
            ]);
        }

        if($order->shipping_provider == 'DTDC')
        {
            // https://stackoverflow.com/questions/34698016/download-pdf-from-base64-string
            $decoded = base64_decode($order->shipping_label);
            $file = 'shipping_label_for_order_awb_'.$order->order_awb.'.pdf';
            file_put_contents($file, $decoded);

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));


                readfile($file);

            }else{
                return redirect()->back()->with([
                    'message' => "Shipping label is not readable.",
                    'alert-type' => 'error',
                ]);
            }
        }else{

            $token =  Shiprocket::getToken();
            $orderIds = [ 'ids' => [$order->shipping_order_id] ];
            $response = Shiprocket::generate($token)->invoice($orderIds);


            $order->update([
                'order_status' => 'Ready To Dispatch',
                'shipping_label' => $order->shipping_label,
                'tax_invoice' => json_decode($response)->invoice_url,
                'manifest_url' => $order->manifest_url,
            ]);



            // redirect()->to($order->manifest_url);
            // redirect()->to($order->tax_invoice);
            return redirect()->back()->with([
                'success' => 'Shipping labels successfully generated!',
            ]);
        }

    }


    public function downloadtaxinvoice(Request $request)
    {
        // get all the orders for order_awb
        $orders = Order::where('order_awb', $request->order_awb)->get();

        if(count($orders) == 0)
        {
            return redirect()->back()->with([
                'message' => 'Selected order is not scheduled for pickup',
                'alert-type' => 'warning',
            ]);
        }

        // dd($orders[0]->vendor);

        // set_time_limit(0);

        // fetch seller info
        if(Config::get('icrm.site_package.multi_vendor_store') == 1)
        {
            $client = new Party([
                'name'          => $orders[0]->vendor->brand_name,
                'address'       => $orders[0]->vendor->street_address_1.' '.$orders[0]->vendor->street_address_2.' '.$orders[0]->vendor->landmark.' '.$orders[0]->vendor->pincode.' '.$orders[0]->vendor->city.' '.$orders[0]->vendor->state.' '.$orders[0]->vendor->country,
                // 'phone'         => setting('seller-name.phone'),
                'custom_fields' => [
                    // 'Email'     => setting('seller-name.email'),
                    'GST'        => $orders[0]->vendor->gst_number,
                    'PAN'        => $orders[0]->vendor->company_pancard_number,
                    'signature'  => $orders[0]->vendor->signature,
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
            'billing_address'       => $orders->first()->dropoff_streetaddress1.' '.$orders->first()->dropoff_streetaddress2.' '.$orders->first()->dropoff_pincode.' '.$orders->first()->dropoff_city.' '.$orders->first()->dropoff_state.' '.$orders->first()->dropoff_country,
            'shipping_address'       => $orders->first()->dropoff_streetaddress1.' '.$orders->first()->dropoff_streetaddress2.' '.$orders->first()->dropoff_pincode.' '.$orders->first()->dropoff_city.' '.$orders->first()->dropoff_state.' '.$orders->first()->dropoff_country,
            // 'phone'         => $orders->first()->customer_contact_number,
            'custom_fields' => [
                'company' => $orders->first()->company_name,
                'email' => $orders->first()->customer_email,
                // 'customer id' => substr(setting('site.title'), 0,1).''.auth()->user()->id,
                'order Number' => $orders->first()->order_id,
                'order AWB' => $orders->first()->order_awb,
                'Invoice Number' => 'Retail'.$orders->first()->id,
                'payment Method' => $orders->first()->order_method,
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
                        $vendorgst =  ', GST Number:'.$item->product->vendor->gst_number;
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

            if(!empty($item->product->productsubcategory->gst))
            {

                $productpricewithoutgst = ($item->product_offerprice * 100) / (100 + $item->product->productsubcategory->gst);
                $gstcharged = $item->product_offerprice - $productpricewithoutgst;
                // return $item->product_offerprice;
            }else{
                $gstcharged = 0.00;
                $productpricewithoutgst = $item->product_offerprice;
            }


            $items[] = (new InvoiceItem())
                ->title($item->product->name)
                ->taxcharged($gstcharged)
                ->description($description)
                ->pricePerUnit(number_format((float)$productpricewithoutgst, 2, '.', ''))
                ->quantity($item->qty);
                // ->tax($orders->first()->order_tax);
        }


        $notes = [
            // 'This is a computer generated tax invoice and does not require any signature'
            'Wheather tax is payable under reverse charge - NO'
        ];

        $notes = implode("<br>", $notes);

        if(empty($orders->first()->order_discount) AND $orders->first()->order_discount == 0){
            $orderdiscount = number_format(0, 2);
        }else{
            $orderdiscount = json_decode($orders->first()->order_discount);
        };

        // dd($orderdiscount);
        // dd($orders->first()->order_deliverycharges);


        $invoice = Invoice::make('Tax Invoice')
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
            ->filename($orders->first()->order_awb)
            ->addItems($items)
            ->notes($notes)
            ->ordertype($orders->first()->type)
            ->totalDiscount($orderdiscount)
            ->orderValue($orders->first()->order_value)
            ->subTotal($orders->first()->order_subtotal)
            ->shipping($orders->first()->order_deliverycharges)
            ->totalTaxes($orders->first()->order_tax)
            ->finalTotal($orders->first()->order_total)
            ->template('new_default')
            ->logo(setting('order-invoice.logo_url'));
            // ->logo(url('storage/'.setting('site.logo')))
            // You can additionally save generated invoice to configured disk
            // ->save('order_invoices');

        $url = $invoice->url();
        // dd('a');
        return $invoice->toHtml();

    }



}
