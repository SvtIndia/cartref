<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Style extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
