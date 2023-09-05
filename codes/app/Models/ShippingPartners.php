<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPartners extends Model
{
    use HasFactory;

    public function getChannelidBrowseAttribute()
    {
        return $this->channel_id ?? 'null';
    }
}
