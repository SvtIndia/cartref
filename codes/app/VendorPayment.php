<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class VendorPayment extends Model
{
    public function save(array $options = [])
    {

        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->created_by && Auth::user()) {
            $this->created_by = Auth::user()->id;
        }


        parent::save();

    }


    public function scopeRoleWise($query)
    {

        // if admin show all data else show only individual data
        if(auth()->user()->hasRole(['admin', 'Client']))
        {
            $query;
        }else{
            $query->where('vendor_id', auth()->user()->id);
        }

        return $query;
    }
}
