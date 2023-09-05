<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;


class Productsku extends Model
{
    
    protected $table = 'productsku';
    
    protected $fillable = ['available_stock', 'status', 'length', 'breath', 'height', 'weight'];   


    public function save(array $options = [])
    {

        parent::save();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
