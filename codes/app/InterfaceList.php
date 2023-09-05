<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class InterfaceList extends Model
{
    protected $table = 'interfaces';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
