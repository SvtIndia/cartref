<?php

namespace App;

use App\Productsku;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;


class StockManagement extends Model
{
    protected $table = 'stock_managements';
    
    public function save(array $options = [])
    {

        // change value in productskus table

        // if product size and color both are considered as sku
        if(Config::get('icrm.product_sku.color') == 1)
        {
            $productsku = Productsku::where('size', $this->size)->where('color', $this->color)->whereHas('product', function($q){
                $q->where('sku', $this->sku);
            })->first();
        }else{
            $productsku = Productsku::where('size', $this->size)->whereHas('product', function($q){
                $q->where('sku', $this->sku);
            })->first();
        }

        // if product sku is not listed then update status
        if(empty($productsku))
        {
            $this->listed_status = 'Not Listed';
        }else{
            $this->listed_status = 'Listed';

            // if listed then update the stock
            if($this->type == 'Inward')
            {
                $calculatestock = $productsku->available_stock + $this->qty;
            }else{
                $calculatestock = $productsku->available_stock - $this->qty;
            }

            if($calculatestock < 0)
            {
                $calculatestock = '0';
            }
            
            $updatestock = $productsku->update([
                                'available_stock' => $calculatestock,
                            ]);
        }

        
                        
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->created_by && Auth::user()) {
            $this->created_by = Auth::user()->id;
        }


        parent::save();



    }
}
