<?php

namespace App;

use App\Models\CouponUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Coupon extends Model
{

    public function sellers()
    {
        return $this->belongsToMany(User::class);
    }

    public function hasSellers($sellers)
    {
        if (is_array($sellers) && count($sellers) > 0) {
            foreach ($sellers as $seller) {
                if (!$this->sellers->contains($seller)) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }

    }

}
