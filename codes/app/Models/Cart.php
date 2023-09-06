<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
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
        return unserialize($value);
    }

}
