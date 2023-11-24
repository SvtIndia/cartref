<?php

namespace App;

use App\Models\Product;
use App\ProductSubcategory;
use Illuminate\Database\Eloquent\Model;


class ProductCategory extends Model
{
    protected $fillable = ['name','slug','status'];
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    public function subcategory()
    {
        return $this->hasMany(ProductSubcategory::class, 'category_id')->where('status', 1)->orderBy('order_id', 'ASC');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->where('admin_status', 'Accepted');
    }
}
