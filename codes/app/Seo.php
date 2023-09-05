<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class Seo extends Model
{

    public function save(array $options = [])
    {

        if (!$this->created_by && Auth::user()) {
            $this->created_by = Auth::user()->id;
        }

        parent::save();

    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
