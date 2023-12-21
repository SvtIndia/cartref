<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Style extends Model
{
    protected $fillable = ['name', 'slug', 'status', 'order_id'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
