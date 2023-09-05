<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Displaycolor extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
