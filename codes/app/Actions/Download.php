<?php

namespace App\Actions;

use App\Order;
use Illuminate\Support\Facades\Session;
use TCG\Voyager\Actions\AbstractAction;

class Download extends AbstractAction
{
    public function getId()
    {
        return 'downloadorders';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to download records for selected query?';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any orders to download";
    }

    public function getColor()
    {
        return 'primary';
    }

    public function getTitle()
    {
        return '';
    }

    public function getIcon()
    {
        return 'voyager-cloud-download';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-primary',
        ];
    }

    public function getDefaultRoute()
    {
        return route('welcome');
    }

    public function shouldActionDisplayOnDataType()
    {
        // this code is not working as expected
        // because of the wrong code download button is showing on all the pages
        return $this->dataType->where('slug', ['orders', 'products', 'contacts']);
    }

    public function massAction($ids, $comingFrom)
    {
        // Do something with the IDs
        
        $filename = ucwords($this->dataType->name).' Updated Till '.date('d-M-Y h:i:sa');

        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename='.$filename.'.csv',
                'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $modelname = $this->dataType->model_name::query();
        
        if($this->dataType->name == 'products')
        {
            $this->productqueries($modelname);
        }

        if($this->dataType->name == 'orders')
        {
            $this->orderqueries($modelname);
        }

        $list = $modelname->get()->toArray();

        if($ids[0] > 0)
        {
            $list = $modelname->where('id', $ids)->get()->toArray();
        }

        
        

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function() use ($list) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        Session::flash('message', ucwords($this->dataType->name).' table successfully downloaded');
        Session::flash('alert-type', 'success');

        return response()->stream($callback, 200, $headers);

        // return redirect($comingFrom);
    }

    private function productqueries($modelname)
    {
        if(request('type') == 'regular')
        {
            $modelname->where('customize_images', null);
        }

        if(request('type') == 'customized')
        {
            $modelname->where('customize_images', '!=', null);
        }

        if(request('filter') == 'activeproducts')
        {
            $modelname->where('admin_status', 'Accepted');
        }

        if(request('filter') == 'inactiveproducts')
        {
            $modelname->where('admin_status', 'Pending For Verification')->orWhere('admin_status', 'Rejected');
        }

        if(request('outofstockproducts') == 'outofstockproducts')
        {
            $modelname->whereHas('productskus', function($q){
                    $q->where('available_stock', '<=', 0)->where('status', 1);
                });
        }

        // if admin show all data else show only individual data
        if(auth()->user()->hasRole(['admin']))
        {
            $modelname;
        }elseif(auth()->user()->hasRole(['Client'])){
            $modelname;
        }else{
            $modelname->where('created_by', auth()->user()->id);
        }
    }

    private function orderqueries($modelname)
    {
        if(request('type') == 'regular')
        {
            $modelname->where('type', 'Regular');
        }

        if(request('type') == 'customized')
        {
            $modelname->where('type', 'Customized');
        }

        if(request('type') == 'showcaseathome')
        {
            $modelname->where('type', 'Showcase at home');
        }

        if(request('filter') == 'neworders')
        {
            $modelname->where('order_status', 'New order');
        }

        if(request('filter') == 'underprocessing')
        {
            $modelname->where('order_status', 'Under processing');
        }

        if(request('filter') == 'readytodispatch')
        {
            $modelname->where('order_status', 'Ready to dispatch');
        }

        if(request('filter') == 'shipped')
        {
            $modelname->where('order_status', 'Shipped');
        }

        if(request('filter') == 'rto')
        {
            $modelname->where('order_status', 'RTO');
        }

        if(request('filter') == 'delivered')
        {
            $modelname->where('order_status', 'Delivered');
        }

        if(request('filter') == 'ndr')
        {
            $modelname->where('order_status', 'NDR');
        }

        if(request('order_id'))
        {
            $modelname->where('order_id', request('order_id'));
        }

        if(auth()->user()->hasRole(['admin']))
        {
            $modelname;
        }elseif(auth()->user()->hasRole(['Client'])){
            $modelname;
        }elseif(auth()->user()->hasRole(['Vendor'])){
            $modelname->where('vendor_id', auth()->user()->id);
        }else{
            $modelname->where('vendor_id', auth()->user()->id);
        }
    }

}