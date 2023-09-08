<?php
namespace App;

use Darryldecode\Cart\CartCollection;
use App\Models\Cart;

class CartStorage {

    public function has($key)
    {
        return Cart::find($key);
    }


    public function get($key)
    {
        if($this->has($key))
        {
            return new CartCollection(Cart::find($key)->wishlist_data);
        }
        else
        {
            return [];
        }
    }


    public function put($key, $value)
    {
        // dd($key);
        $obj = json_decode(json_encode($value));
        $myKey = array_keys((array)$obj)[0] ?? 0;
        $myObj = $obj->$myKey ?? (object)[];
        if($row = Cart::find($key))
        {
            // update
            $row->wishlist_data = $value;

            $row->cartrowid = $myKey;
            $row->name = $myObj->name ?? null;
            $row->price = $myObj->price ?? 0;
            $row->user_id = auth()->user()->id ?? 0;
            $row->quantity = $myObj->quantity ?? 0;
            $row->attributes = json_encode($myObj->attributes ?? []);
            $row->conditions = json_encode($myObj->conditions ?? []);
            $row->save();
        }
        else
        {

            Cart::create([
                'id' => $key,
                'user_id' => auth()->user()->id ?? 0,
                'wishlist_data' => $value,
                'cartrowid' => $myKey,
                'name' => $myObj->name ?? null,
                'price' => $myObj->price ?? 0,
                'quantity' => $myObj->quantity ?? 0,
                'attributes' => json_encode($myObj->attributes ?? []),
                'conditions' => json_encode($myObj->conditions ?? []),
            ]);
        }
    }


}
