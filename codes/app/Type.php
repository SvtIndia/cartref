<?php

namespace App;

use App\Models\Product;
use App\ProductSubcategory;
use Illuminate\Database\Eloquent\Model;


class Type extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }



}
