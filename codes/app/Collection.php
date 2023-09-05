<?php

namespace App;

use App\CollectionImage;
use Illuminate\Database\Eloquent\Model;


class Collection extends Model
{
    public function collections()
    {
        return $this->belongsTo(CollectionImage::class, 'id', 'collection_id')->where('status', 1)->orderBy('order_id', 'asc');
    }
}
