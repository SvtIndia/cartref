<?php

namespace App;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class Showcase extends Model
{

    protected $fillable = ['order_status', 'status' ,'showcase_timer', 'is_timer_extended', 'is_discount_applied'];

    public function scopeRolewise($query)
    {
        $this->updateDelayAcceptance();
        if(!empty(request('label'))){
            if(request('label') == 'Showcased')
            {
                $query->whereIn('order_status', ['Showcased', 'Moved to bag']);
            }
            elseif(request('label') == 'Delay Acceptance'){
                $query->where(['is_order_accepted' => 0, 'order_status' => 'Delay Acceptance']);
            }
            else{
                $query->where('order_status', request('label'));    
            }
        }

        if(request('order_id'))
        {
            $query->where('order_id', request('order_id'));
        }

        if(Auth::user()->hasRole(['Vendor']))
        {
            $query->where('vendor_id', auth()->user()->id);
        }

        if(Auth::user()->hasRole(['Delivery Head']))
        {
            $query->where('pickup_city', auth()->user()->city);
            $query->where('is_order_accepted', true);
        }

        if(Auth::user()->hasRole(['Delivery Boy']))
        {
            $query->where('deliveryboy_id', auth()->user()->id);
            $query->where('is_order_accepted', true);
        }

        return $query->orderBy('updated_at', 'desc');
    }

    public function  updateDelayAcceptance(){
        Showcase::where(['is_order_accepted' => 0, 'order_status' => 'New Order'])->where('created_at', '<',now()->subMinute(30))->update([
            'order_status' => 'Delay Acceptance'
        ]);

    }




    public function save(array $options = [])
    {
        

        if(auth()->user()->hasRole(['Delivery Head']))
        {
            if(!empty($this->deliveryboy_id))
            {                
                Showcase::where('order_id', $this->order_id)->update([
                    'deliveryhead_id' => auth()->user()->id,
                    'deliveryboy_id' => $this->deliveryboy_id,
                ]);
            }
            
        }


        parent::save();

    }





    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function deliveryboy()
    {
        return $this->belongsTo(User::class, 'deliveryboy_id', 'id');
    }


    public function deliveryhead()
    {
        return $this->belongsTo(User::class, 'deliveryhead_id', 'id');
    }

    
    
    

}
