<?php

namespace App\Providers;

use App\WishlistStorage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Darryldecode\Cart\Cart;

class WishlistServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('wishlist', function($app)
        {
            $userID = 0;
            if (Auth::check()) {
                $userID = auth()->user()->id;
            } else {
                if (session('session_id')) {
                    $userID = session('session_id');
                } else {
                    $userID = rand(1111111111, 9999999999);
                    session(['session_id' => $userID]);
                }
            }

            $storage = $app[\App\WishlistStorage::class];
            $events = $app['events'];
            $instanceName = 'wishlist';
            $session_key = $userID;

            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_wishlist')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
