<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function fetchWishlists(){
        $wishlist = Wishlist::with('user')->get();

        return response()->json(['data' => $wishlist]);
    }
}
