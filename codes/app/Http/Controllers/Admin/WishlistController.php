<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function fetchWishlists()
    {
        $rows = request()->rows ?? 25;
        if($rows == 'all'){
            $rows = Wishlist::count();
        }
        $keyword = request()->keyword ?? null;

        $wishlist = Wishlist::with('user')
            ->whereHas('user', function ($query) use ($keyword) {
                $query->when($keyword, function ($query1) use ($keyword) {
                    $query1->where(function ($q) use ($keyword) {
                        $q->orWhere('name', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('mobile', 'LIKE', '%' . $keyword . '%');
                    });
                });
            })->paginate($rows);

        return response()->json($wishlist);
    }
}
