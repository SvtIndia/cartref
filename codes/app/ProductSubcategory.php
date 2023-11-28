<?php

namespace App;

use App\Size;
use App\Models\Product;
use App\ProductCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;


class ProductSubcategory extends Model
{
    use SoftDeletes;
    protected $table = "product_subcategories";

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'status',
        'image',
        'hsn',
        'gst'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id', 'id')->where('admin_status', 'Accepted');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    
}
