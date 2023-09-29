<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\EmailNotification;
use Illuminate\Http\Request;
use Craftsys\Msg91\Facade\Msg91;
use TCG\Voyager\Facades\Voyager;
use App\Notifications\OrderEmail;
use Seshac\Shiprocket\Shiprocket;
use LaravelDaily\Invoices\Invoice;
use App\Notifications\WelcomeEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\BagController;
use Illuminate\Support\Facades\Artisan;
use Laravel\Socialite\Facades\Socialite;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\myorderscontroller;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\MyAccountController;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use App\Http\Controllers\DownloadLabelController;
use App\Http\Controllers\ShowcaseAtHomeController;
use App\Http\Controllers\CustomizeProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductBulkUploadController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

// Route::get('/msg91', function(){
//     // https://github.com/craftsys/msg91-laravel#installation
//     try {
//         $response = Msg91::sms()->to(919893147993)->flow('62541b4b9714fc5c2420a659')->send();
//         echo 'done';
//     } catch (\Craftsys\Msg91\Exceptions\ValidationException $e) {
//         // issue with the request e.g. token not provided
//         echo 'issue with the request e.g. token not provided';
//     } catch (\Craftsys\Msg91\Exceptions\ResponseErrorException $e) {
//         // error thrown by msg91 apis or by http client
//         echo 'error thrown by msg91 apis or by http client';
//     } catch (\Exception $e) {
//         // something else went wrong
//         // plese report if this happens :)
//         echo 'something else went wrong';
//     }
// });


// Route::get('/dtdcschedulepickup', [BagController::class, 'dtdcschedulepickup']);
// Route::get('/dtdcpincodesearch', [BagController::class, 'dtdcpincodesearch']);
// Route::post('/dtdcordercancellation', [BagController::class, 'dtdcordercancellation'])->name('dtdc.order.cancel');
// Route::get('/dtdcordercancellation/{order_awb}', [BagController::class, 'dtdcordercancellation'])->name('dtdc.order.cancel');


// Route::get('/smtptest', function(){

//     Notification::route('mail', auth()->user()->email)->notify(new WelcomeEmail(auth()->user()));

// });



/**
 * Laravel admin
 */

Route::group(['prefix' => Config::get('icrm.admin_panel.prefix')], function () {
    Route::get('/products/bulk-upload', [ProductBulkUploadController::class, 'uploadPage'])->name('products.bulk-upload');
    Route::post('/products/bulk-upload', [ProductBulkUploadController::class, 'upload'])->name('products.bulk-upload');

    Voyager::routes(['verify', true]);

    Route::get('/downloadlabel', [DownloadLabelController::class, 'downloadlabel'])->name('downloadlabel');
    Route::post('/orders/downloadtaxinvoice', [DownloadLabelController::class, 'downloadtaxinvoice'])->name('downloadtaxinvoice');
});

/**
 * End Laravel admin
 */


/**
 * Sitemap
 * generate sitemap with https://github.com/spatie/laravel-sitemap
 * this command is also scheduled
 * used this guilde
 */

Route::get("generate-sitemap", function () {
    SitemapGenerator::create(env('APP_URL'))->writeToFile('../../public_html/' . str_replace('https://', '', env('APP_URL')) . '/sitemap.xml');
});

/**
 * End Sitemap
 */


/** Language Transation */
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');



/**
 * For SEO use this package: https://romanzipp.github.io/Laravel-SEO/example-app.html#service-provider
 */





/**
 * Header
 */
Route::post('/search', [WelcomeController::class, 'search'])->name('search');
/**
 * End header
 */







/**
 * Homepage
 */

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/slider/{slug}', [WelcomeController::class, 'slider'])->name('slider.slug');
/**
 * End homepage
 */







/**
 * About us
 */

Route::get('/about-us', [WelcomeController::class, 'aboutus'])->name('aboutus');

/**
 * End about us
 */



/**
 * Contact us
 */

Route::get('/contactus', [WelcomeController::class, 'contactus'])->name('contactus');
Route::post('/contactus', [WelcomeController::class, 'contactuspost'])->name('contactuspost');


/**
 *
 */


/**
 * Blogs
 */
if (Config::get('icrm.frontend.blogs.feature') == 1) {
    Route::prefix('blogs')->group(function () {
        Route::get('/all', [BlogsController::class, 'index'])->name('blogs');
        Route::get('/blog/{slug}', [BlogsController::class, 'blog'])->name('blog');
    });
}
/**
 * End blog
 */


/**
 * Newsletters component
 */
if (Config::get('icrm.frontend.newslettersignup.feature') == 1) {
    Route::post('/newslettersignup', [WelcomeController::class, 'newslettersignup'])->name('newslettersignup');
}

/**
 * End newsletter component
 */



/**
 * Catalog and product
 */
Route::get('/category/{category}', [WelcomeController::class, 'dynamicCategory'])->name('category.dynamic');

Route::get('/products', [WelcomeController::class, 'products'])->name('products');
Route::get('/products/category/{category}', [WelcomeController::class, 'productscategory'])->name('products.category');
Route::get('/products/subcategory/{subcategory}', [WelcomeController::class, 'productssubcategory'])->name('products.subcategory');
Route::get('/products/vendor/{slug}', [WelcomeController::class, 'productsfromvendor'])->name('products.vendor');

Route::get('/product/{slug}', [WelcomeController::class, 'product'])->name('product.slug');


if (Config::get('icrm.showcase_at_home.feature') == 1) {
    Route::get('/products/showcase-at-home', [WelcomeController::class, 'productsshowcaseathome'])->name('products.showcase');
    Route::get('/products/showcase-at-home/vendor/{vendor_id}', [WelcomeController::class, 'productsshowcaseathomeforvendor'])->name('products.showcase.vendor');
}

Route::get('/products/{vendor_id}', [WelcomeController::class, 'categoryByVendor'])->name('products-category');

// Route::get('/product/{slug}/{color}', [WelcomeController::class, 'productcolor'])->name('product.slug.color');
// Route::get('/product/{slug}/csin-{sin}', [WelcomeController::class, 'productsin'])->name('product.slug.sin');

/**
 * End catalog and product
 */






/**
 * Bag wishlist
 */

Route::post('/bag/wishlist', [WishlistController::class, 'wishlist'])->name('bag.wishlist');

Route::prefix('shopping-cart')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
});


/**
 * End bag wishlist
 */





/**
 * Customization
 */

if (Config::get('icrm.customize.feature') == 1) {
    Route::prefix('customization')->group(function () {
        Route::get('/introduction', [CustomizeProductController::class, 'introduction'])->name('customize.introduction');
        Route::get('/customize', [CustomizeProductController::class, 'customize'])->name('customize');
        Route::post('/customize/customized', [CustomizeProductController::class, 'customized'])->name('customize.customized');

        // upload media
        Route::post('/customize/uploadmedia', [CustomizeProductController::class, 'uploadmedia'])->name('customize.uploadmedia');

        Route::get('/customize/sharefiles', [CustomizeProductController::class, 'sharefiles'])->name('customize.sharefiles');
        Route::post('/customize/movetobag', [CustomizeProductController::class, 'movetobag'])->name('customize.movetobag');
    });
}

/**
 * End customization
 */


/**
 * Showcase at home
 */
if (Config::get('icrm.showcase_at_home.feature') == 1) {
    Route::prefix('showcase-at-home')->group(function () {
        Route::get('/introduction', [ShowcaseAtHomeController::class, 'introduction'])->name('showcase.introduction');
        Route::get('/get-started', [ShowcaseAtHomeController::class, 'getstarted'])->name('showcase.getstarted');
        Route::post('/activate', [ShowcaseAtHomeController::class, 'activateshowcase'])->name('showcase.activate');
        Route::post('/deactivate', [ShowcaseAtHomeController::class, 'deactivateshowcase'])->name('showcase.deactivate');
    });
}

Route::prefix('showcase-at-home')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/bag', [ShowcaseAtHomeController::class, 'bag'])->name('showcase.bag');
    Route::get('/bag/checkout', [ShowcaseAtHomeController::class, 'checkout'])->name('showcase.checkout');
    Route::post('/paynow', [ShowcaseAtHomeController::class, 'paynow'])->name('showcase.paynow');
    Route::post('/purchase/paynow', [ShowcaseAtHomeController::class, 'purchasepaynow'])->name('showcase.purchase.paynow');

    Route::prefix('my-orders')->middleware(['auth', 'verified'])->group(function () {
        Route::get('/all', [ShowcaseAtHomeController::class, 'myorders'])->name('showcase.myorders');
        Route::get('/order/{id}', [ShowcaseAtHomeController::class, 'ordercomplete'])->name('showcase.ordercomplete');
        Route::get('/order/{id}/buynow', [ShowcaseAtHomeController::class, 'buynow'])->name('showcase.buynow');
    });
});

/**
 * End showcase at home
 */



/**
 * Bag
 */

Route::prefix('shopping-cart')->group(function () {
    Route::get('/bag', [BagController::class, 'bag'])->name('bag');
});

Route::prefix('shopping-cart')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/bag/checkout', [BagController::class, 'checkout'])->name('checkout');
    Route::post('/bag/paynow', [BagController::class, 'paynow'])->name('bag.paynow');
});


/**
 * End bag
 */




/**
 * My orders
 */


Route::prefix('my-orders')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/all', [myorderscontroller::class, 'index'])->name('myorders');
    Route::get('/order/{id}', [myorderscontroller::class, 'ordercomplete'])->name('ordercomplete');
    Route::post('/order/{id}/downloadinvoice', [myorderscontroller::class, 'downloadinvoice'])->name('downloadinvoice');

    Route::get('/order/{id}/product/{slug}', [myorderscontroller::class, 'orderproduct'])->name('ordercomplete.orderproduct');
});

Route::get('/tu/{id}', [myorderscontroller::class, 'ordercomplete'])->name('trackingurl')->middleware('auth');


/**
 * end my orders
 */



/**
 * Page generator
 */

Route::get('/page/{slug}', [WelcomeController::class, 'page'])->name('page.slug');


/**
 * End page generator
 */


/**
 * My account
 */

Route::prefix('my-account')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/account-details', [MyAccountController::class, 'myaccount'])->name('myaccount');
    // Route::post('/updateprofile', [MyAccountController::class, 'updateprofile'])->name('update-profile');

    // Route::get('/change-password', [MyAccountController::class, 'changepassword'])->name('myaccount-change-password');

    // Route::get('/manage-addresses', [MyAccountController::class, 'manageaddresses'])->name('myaccount-manage-addresses');
    // Route::post('/manage-addresses', [MyAccountController::class, 'postmanageaddresses'])->name('post.myaccount-manage-addresses');
    // Route::get('/request-return', [MyAccountController::class, 'requestreturn'])->name('myaccount.return');
});

/**
 * End my account
 */









/**
 * Vendor signup
 */
if (Config::get('icrm.vendor.signup') == 1) {
    Route::get('/become-a-seller', [VendorController::class, 'becomeseller'])->name('becomeseller');
    Route::post('/become-a-seller', [VendorController::class, 'vendorsignup'])->name('vendorsignup');
}
/**
 * End vendor signup
 */



/**
 * Laravel optimize
 * All these routes are only for developer to use for the laravel optimization
 */

//Clear Cache facade value:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Config cached</h1>';
});

//Clear Config cache:
Route::get('/config-clear', function () {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Config cleared</h1>';
});


//Clear Config cache:
Route::get('/backup-run', function () {
    $exitCode = Artisan::call('backup:run');
    return '<h1>Backup done</h1>';
});

//Clear Config cache:
Route::get('/backup-clean', function () {
    $exitCode = Artisan::call('backup:clean');
    return '<h1>Backup cleaned</h1>';
});

/**
 * End laravel optimize
 */

Route::view('/invoice/test', 'vendor.invoices.templates.default');

Route::get('/get',function(){
    $a = 'redeemedRewardPoints => '. Session::get('redeemedRewardPoints');
    $b = 'redeemedCredits => '. Session::get('redeemedCredits');
    dd($a,$b);
});