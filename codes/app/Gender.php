<?php

namespace App;

use App\Models\Product;
use TCG\Voyager\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;


class Gender extends Model
{
    use Translatable;
    protected $translatable = ['name'];
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'name', 'gender_id');
    }
}
