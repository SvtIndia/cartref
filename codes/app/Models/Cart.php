<?php

namespace App\Models;

use App\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cartrowid',
        'user_id',
        'name',
        'price',
        'quantity',
        'attributes',
        'conditions',
        'wishlist_data'
    ];


    /**
     * Mutator for wishlist_column
     * @param $value
     */
    public function setWishlistDataAttribute($value)
    {
        $this->attributes['wishlist_data'] = serialize($value);
    }


    /**
     * Accessor for wishlist_column
     * @param $value
     * @return mixed
     */

    public function getWishlistDataAttribute($value)
    {
        $data = unserialize($value);
        if(isset($data)){
            if(is_array($data)){
                $objs = $data;
            }else{
                $objs = json_decode($data, true) ?? [];
            }
        }
        foreach ($objs as $key => $obj) {
            if(isset($obj) && isset($obj['attributes'])&& isset($obj['attributes']['product_id'])){
                $objs[$key]['product'] = Product::find($obj['attributes']['product_id']) ?? [];
            }
            else{
                unset($objs[$key]);
            }
        }
        return (object)['serialize' => $value, 'unserialize' => $data, 'data' => $objs];

    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function scopeUserId($query)
    {
        return $query->has('user');
    }

    public function getOrdersAttribute(){
        if($this->user_id > 0){
            $user = $this->user;
            return $orders = Order::with('product')->where('user_id', $this->user_id)->get();
        }
        else{
            return [];
        }
    }
}
