<?php

namespace App;

use App\Models\Product;
use TCG\Voyager\Models\User;
use Illuminate\Database\Eloquent\Model;


class ProductReview extends Model
{
    protected $fillable = ['rate', 'comment', 'product_id', 'user_id', 'status',];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->where('status', 1);
    }

}
