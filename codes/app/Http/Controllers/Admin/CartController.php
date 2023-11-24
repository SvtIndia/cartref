<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;

class CartController extends Controller
{
    public function fetchCarts()
    {
        $rows = request()->rows ?? 25;
        if($rows == 'all'){
            $rows = Cart::count();
        }
        $keyword = request()->keyword ?? null;

        $cart = Cart::with('user')
            ->whereHas('user', function ($query) use ($keyword) {
                $query->when($keyword, function ($query1) use ($keyword) {
                    $query1->where(function ($q) use ($keyword) {
                        $q->orWhere('name', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('mobile', 'LIKE', '%' . $keyword . '%');
                    });
                });
            })
            ->where('id','LIKE','%cart_items')
            ->orderBy('updated_at', 'desc')
            ->paginate($rows);
        return response()->json($cart);
    }
}
