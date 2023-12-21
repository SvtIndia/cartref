<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;


class Gender extends Model
{
    use Translatable;

    protected $translatable = ['name'];

    protected $fillable = ['name', 'status', 'order_id'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'name', 'gender_id');
    }
}
