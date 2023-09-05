<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Modellist extends Model
{
    protected $table = 'modellists';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
