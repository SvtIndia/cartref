<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Productsdashboard extends Component
{
    public $products = 0;
    public $activeproducts = 0;
    public $inactiveproducts = 0;
    public $pendingforverificationproducts = 0;
    public $outofstockproducts = 0;

    public function render()
    {
        $productsquery = Product::
                            when(request('type'), function($q){
                                if(request('type') == 'customized')
                                {
                                    $q->where('customize_images', '!==', null);
                                }else{
                                    $q->where('customize_images', null);
                                }
                            })
                            ->when(auth()->user()->hasRole(['Vendor']), function($q){
                                $q->where('seller_id', auth()->user()->id);
                            })->get();
                            
                            
        Product::where('admin_status', null)->update([
                'admin_status' => 'Pending For Verification'
            ]);
        // dd();
                

        $this->products = $productsquery->count();
        $this->activeproducts = $productsquery->where('admin_status', 'Accepted')->count();
        $this->inactiveproducts = $productsquery->whereNotIn('admin_status', ['Accepted', 'Pending For Verification', 'Updated'])->count();
        
        $this->pendingforverificationproducts =  $productsquery->whereNotIn('admin_status', ['Accepted', 'Rejected'])
            ->count();
        // $this->outofstockproducts = $productsquery->productskus()->where('available_stock', '<=', 0)->where('status', 1)->count();

        return view('livewire.productsdashboard');
    }
}
