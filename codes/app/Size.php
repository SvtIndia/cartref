<?php

namespace App;

use App\Models\Product;
use App\ProductSubcategory;
use Illuminate\Database\Eloquent\Model;


class Size extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'size_product');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'size_id');
    }

    public function productsizes()
    {
        return $this->belongsToMany(Product::class, 'size_product', 'size_id', 'product_id');
    }

    public function sizessubcategory()
    {
        return $this->belongsToMany(ProductSubcategory::class, 'size_product_subcategory', 'size_id', 'product_subcategory_id');
    }

}
