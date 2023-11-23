<?php

namespace App;

use App\Models\Wishlist;
use Darryldecode\Cart\CartCollection;

class WishlistStorage
{

    public function has($key)
    {
        return Wishlist::find($key);
    }


    public function get($key)
    {
        if ($this->has($key)) {
            return new CartCollection(Wishlist::find($key)->wishlist_data->unserialize);
        } else {
            return [];
        }
    }


    public function put($key, $value)
    {
        // dd($key);
        $obj = json_decode(json_encode($value));
        $myKey = array_keys((array)$obj)[0] ?? 0;
        $myObj = $obj->$myKey ?? (object)[];

        if ($row = Wishlist::find($key)) {
            // update
            $row->wishlist_data = $value;
            $row->user_id = auth()->user()->id ?? 0;
            $row->save();
        } else {

            Wishlist::create([
                'id' => $key,
                'user_id' => auth()->user()->id ?? 0,
                'wishlist_data' => $value,
            ]);
        }
    }


}
