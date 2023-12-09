<?php

namespace App\Providers;

use App\Coupon;

use Carbon\Carbon;
use App\Productsku;
use App\Models\Product;
use App\ProductCategory;
use App\Actions\Download;
use Darryldecode\Cart\Cart;
use App\Actions\CancelOrder;
use TCG\Voyager\Models\Page;
use App\Actions\DownloadLabel;
use App\Actions\GenerateLabel;
use App\Actions\MarkAsShipped;
use App\Actions\MoveToNewOrder;
use TCG\Voyager\Facades\Voyager;
use App\Actions\UnderManufacturing;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\FormFields\SelectDependentDropdown;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (array_wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });

        Voyager::addFormField(SelectDependentDropdown::class);

        Voyager::addAction(\App\Actions\CancelOrder::class);
        Voyager::addAction(\App\Actions\CancelShipment::class);
        Voyager::addAction(\App\Actions\Download::class);
        Voyager::addAction(\App\Actions\DownloadLabel::class);
        Voyager::addAction(\App\Actions\UnderManufacturing::class);
        Voyager::addAction(\App\Actions\SchedulePickup::class);
        Voyager::addAction(\App\Actions\GenerateLabel::class);
        Voyager::addAction(\App\Actions\MarkAsShipped::class);
        Voyager::addAction(\App\Actions\MoveToNewOrder::class);
        Voyager::addAction(\App\Actions\Showcases\MarkAsPickedUp::class);
        Voyager::addAction(\App\Actions\Showcases\MarkAsShowcased::class);
        // Voyager::addAction(\App\Actions\CancelOrder::class);

        Paginator::useBootstrap();

        $pages = Page::where('status', 'ACTIVE')->orderBy('order_id', 'ASC')->get();


        $coupons = Coupon::where('status', 1)
                        ->where('from', '<=', Carbon::today())
                        ->where('to', '>=',Carbon::today())
                        ->where('user_email', null)
                        ->where('is_coupon_for_all', true)
                        ->inRandomOrder()
                        ->get();


        if(Auth::check())
        {
            \Cart::session(auth()->user()->id);
        }


        Session::remove('quickviewid');

        // Update sku dimensions
        $this->updateskudimensions();

        // Inactive SKU whose dimensions are not updated
        $this->inactiveskuwithoutdimensions();

        View::share([
            'pages' => $pages,
            'coupons' => $coupons,
        ]);

    }


    private function updateskudimensions()
    {
        // find empty dimensions in skus
        $emptydimensions = Productsku::where('status', 1)->whereNull('weight')->take(200)->get();
        // dd($emptydimensions);

        foreach($emptydimensions as $sku)
        {
            $product = Product::where('id', $sku->product_id)->first();

            // check if product exists
            if(!empty($product))
            {
                // check if dimensions are empty
                if(!empty($sku->weight))
                {
                    $sku->update([
                        'length' => $product->length,
                        'breath' => $product->breadth,
                        'height' => $product->height,
                        'weight' => $product->weight,
                    ]);
                }
            }


        }
    }


    private function inactiveskuwithoutdimensions()
    {
        // find empty dimensions in skus
        $emptydimensions = Productsku::where('status', 1)->whereNull('weight')->get();

        foreach($emptydimensions as $sku)
        {
            // check if weight is empty
            if(empty($sku->weight))
            {
                $sku->update([
                    'status' => 0,
                ]);
            }
        }
    }
}
