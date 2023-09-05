<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;


class Color extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'color_product');
    }

}
