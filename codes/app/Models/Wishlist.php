<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'wishlist_data'
    ];

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
        $objs = json_decode($data, true) ?? [];
        foreach ($objs as $key => $obj) {
            if(isset($obj) && isset($obj['id'])){
                $objs[$key]['product'] = Product::find($obj['id']) ?? [];
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
}
