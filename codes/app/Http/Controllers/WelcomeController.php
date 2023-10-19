<?php

namespace App\Http\Controllers;

use App\Productcolor;
use App\Size;
use App\Brand;
use App\Color;
use App\Order;
use App\Contact;
use App\Component;
use App\Collection;
use App\HomeSlider;
use App\Newsletter;
use App\Productsku;
use App\Models\Product;
use App\Models\User;
use App\ProductCategory;
use App\ProductSubcategory;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use TCG\Voyager\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use TCG\Voyager\Models\Role;

class WelcomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homesliders = HomeSlider::where(['status' => 1, 'category' => 'Home'])->orderBy('order_id', 'ASC')->get();

        if (Config::get('icrm.frontend.flashsale.feature') == 1) {

            $flashsales = Product::where('flash_sale', 1)
                ->where('admin_status', 'Accepted')
                ->whereHas('vendor', function ($q) {
                    $q->where('status', 1);
                })
                ->inRandomOrder()->limit(Config::get('icrm.frontend.flashsale.count'))->get();
        } else {
            $flashsales = [];
        }


        // $categories = ProductCategory::where('status', 1)->get();
        // $subcategories = ProductSubcategory::where('status', 1)->get();

        // 3 column collections
        if (Config::get('icrm.frontend.threecolumncomponent.feature') == 1) {
            $collections3c = Collection::where(['status' => 1, 'category' => 'Home'])->where('group_name', '3Column')->take(3)->get();
        } else {
            $collections3c = [];
        }

        // 2 column collections
        if (Config::get('icrm.frontend.twocolumncomponent.feature') == 1) {
            $collections2c = Collection::where(['status' => 1, 'category' => 'Home'])->where('group_name', '2Column')->take(2)->get();
        } else {
            $collections2c = [];
        }


        if (Config::get('icrm.frontend.twocolumnfreerowscomponent.feature') == 1) {
            $collections2cfr = Collection::where(['status' => 1, 'category' => 'Home'])->where('group_name', '2Columnandfreerows')->get();
        } else {
            $collections2cfr = [];
        }


        if (Config::get('icrm.frontend.threecolumnfreerowscomponent.feature') == 1) {
            $collections3cfr = Collection::where(['status' => 1, 'category' => 'Home'])->where('group_name', '3Columnandfreerows')->get();
        } else {
            $collections3cfr = [];
        }

        if (Config::get('icrm.frontend.fivecolumnfreerowscomponent.feature') == 1) {
            $collections5cfr = Collection::where(['status' => 1, 'category' => 'Home'])->where('group_name', '5Columnandfreerows')->get();
        } else {
            $collections5cfr = [];
        }


        if (Config::get('icrm.frontend.trendingproducts.feature') == 1) {
            $trendings = $this->trendingproducts();
        } else {
            $trendings = [];
        }

        if (Config::get('icrm.frontend.blogs.feature') == 1) {
            $blogs = Post::where('status', 'PUBLISHED')->where('featured', 1)->take(4)->get();
        } else {
            $blogs = [];
        }


        if (Config::get('icrm.frontend.recentlyviewed.feature') == 1) {
            $recentlyviewedcontent = app('recentlyviewed')->getContent();
            $recentlyviewed = Product::where('admin_status', 'Accepted')
                ->whereIn('id', $recentlyviewedcontent->pluck('id'))
                ->whereHas('vendor', function ($q) {
                    $q->where('status', 1);
                })
                ->take(Config::get('icrm.frontend.recentlyviewed.count'))
                ->get();
        } else {
            $recentlyviewed = [];
        }

        $dynamiccollections = Collection::where(['status' => 1, 'category' => 'Home'])->where('desktop_columns', '>', '0')->whereHas('collections')->orderBy('order_id', 'asc')->get();

        // return ($dynamiccollections);


        return view('welcome')->with([
            'homesliders' => $homesliders,
            'flashsales' => $flashsales,
            // 'trendingcategories' => $trendingcategories,
            'recentlyviewed' => $recentlyviewed,
            // 'categories' => $categories,
            // 'subcategories' => $subcategories,
            'collections3c' => $collections3c,
            'collections2cfr' => $collections2cfr,
            'collections3cfr' => $collections3cfr,
            'collections5cfr' => $collections5cfr,
            'collections2c' => $collections2c,
            'trendings' => $trendings,
            'blogs' => $blogs,
            'dynamiccollections' => $dynamiccollections,
        ]);
    }

    public function dynamicCategory($category)
    {
        $homesliders = HomeSlider::where(['status' => 1, 'category' => $category])->orderBy('order_id', 'ASC')->get();

        // if (Config::get('icrm.frontend.flashsale.feature') == 1){

        //     $flashsales = Product::
        //         where('flash_sale', 1)
        //         ->where('admin_status', 'Accepted')
        //         ->whereHas('vendor', function($q){
        //             $q->where('status', 1);
        //         })
        //         ->inRandomOrder()->limit(Config::get('icrm.frontend.flashsale.count'))->get();
        // }else{
        // }
        $flashsales = [];


        // $categories = ProductCategory::where('status', 1)->get();
        // $subcategories = ProductSubcategory::where('status', 1)->get();

        // 3 column collections
        if (Config::get('icrm.frontend.threecolumncomponent.feature') == 1) {
            $collections3c = Collection::where(['status' => 1, 'category' => $category])
                ->where('group_name', '3Column')->take(3)->get();
        } else {
            $collections3c = [];
        }

        // 2 column collections
        if (Config::get('icrm.frontend.twocolumncomponent.feature') == 1) {
            $collections2c = Collection::where(['status' => 1, 'category' => $category])
                ->where('group_name', '2Column')->take(2)->get();
        } else {
            $collections2c = [];
        }


        if (Config::get('icrm.frontend.twocolumnfreerowscomponent.feature') == 1) {
            $collections2cfr = Collection::where(['status' => 1, 'category' => $category])
                ->where('group_name', '2Columnandfreerows')->get();
        } else {
            $collections2cfr = [];
        }


        if (Config::get('icrm.frontend.threecolumnfreerowscomponent.feature') == 1) {
            $collections3cfr = Collection::where(['status' => 1, 'category' => $category])
                ->where('group_name', '3Columnandfreerows')->get();
        } else {
            $collections3cfr = [];
        }

        if (Config::get('icrm.frontend.fivecolumnfreerowscomponent.feature') == 1) {
            $collections5cfr = Collection::where(['status' => 1, 'category' => $category])
                ->where('group_name', '5Columnandfreerows')->get();
        } else {
            $collections5cfr = [];
        }


        // if(Config::get('icrm.frontend.trendingproducts.feature') == 1)
        // {
        //     $trendings = $this->trendingproducts();
        // }else{
        // }
        $trendings = [];

        // if(Config::get('icrm.frontend.blogs.feature') == 1)
        // {
        //     $blogs = Post::where('status', 'PUBLISHED')->where('featured', 1)->take(4)->get();
        // }else{
        // }
        $blogs = [];


        // if(Config::get('icrm.frontend.recentlyviewed.feature') == 1)
        // {
        //     $recentlyviewedcontent = app('recentlyviewed')->getContent();
        //     $recentlyviewed = Product::where('admin_status', 'Accepted')
        //                         ->whereIn('id', $recentlyviewedcontent->pluck('id'))
        //                         ->whereHas('vendor', function($q){
        //                             $q->where('status', 1);
        //                         })
        //                         ->take(Config::get('icrm.frontend.recentlyviewed.count'))
        //                         ->get();
        // }else{
        // }
        $recentlyviewed = [];

        $dynamiccollections = Collection::where(['status' => 1, 'category' => $category])
            ->where('desktop_columns', '>', '0')->whereHas('collections')->orderBy('order_id', 'asc')->get();

        // return ($dynamiccollections);


        return view('category')->with([
            'homesliders' => $homesliders,
            'flashsales' => $flashsales,
            // 'trendingcategories' => $trendingcategories,
            'recentlyviewed' => $recentlyviewed,
            // 'categories' => $categories,
            // 'subcategories' => $subcategories,
            'collections3c' => $collections3c,
            'collections2cfr' => $collections2cfr,
            'collections3cfr' => $collections3cfr,
            'collections5cfr' => $collections5cfr,
            'collections2c' => $collections2c,
            'trendings' => $trendings,
            'blogs' => $blogs,
            'dynamiccollections' => $dynamiccollections,
        ]);
    }


    public function aboutus()
    {
        $components = Component::where('page_name', 'About Us')->where('status', 1)->get();
        return view('aboutus')->with([
            'components' => $components
        ]);
    }

    private function trendingproducts()
    {
        /**
         * Fetch most purchased top 10 products from order table
         */

//        $orders = DB::table('orders')
//            ->select('product_id', DB::raw('count(*) as productcount'))
//            ->groupBy('product_id')
//            ->orderBy('productcount', 'desc')
//            ->inRandomOrder()
//            ->limit(Config::get('icrm.frontend.trendingproducts.count'))
//            ->get();
//
//        if (count($orders) > 0) {
//            $trendings = Product::where('admin_status', 'Accepted')
//                ->whereIn('id', $orders->pluck('product_id'))
//                ->whereHas('vendor', function ($q) {
//                    $q->where('status', 1);
//                })
//                ->take(Config::get('icrm.frontend.trendingproducts.count'))
//                ->get();
//        } else {
//            $trendings = Product::where('admin_status', 'Accepted')
//                ->take(Config::get('icrm.frontend.trendingproducts.count'))
//                ->get();
//        }
        $trendings = Product::withCount('users')
            ->where('admin_status', 'Accepted')
            ->take(Config::get('icrm.frontend.trendingproducts.count'))
            ->orderBy('users_count', 'desc')
            ->get();

        return $trendings;
    }


    public function contactuspost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|integer|digits:10',
            'message' => 'required'
        ]);

        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->mobile = $request->phone;
        $contact->message = $request->message;
        $contact->save();

        Session::flash('success', 'Your contact request has been submited successfully!');

        return redirect()->route('contactus');
    }


    public function search(Request $request)
    {
        return redirect()->route('products', ['search' => $request->search]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        if (Session::get('showcasecity') && !isset($_GET['brand_name']) && !isset($_GET['search'])) {
            $city = Session::get('showcasecity');
            $vendorRole = Role::whereName('Vendor')->first();
            $users = User::where('city', 'LIKE', '%' . $city . '%')->where('role_id', $vendorRole->id)->where('status', true)->get();

            return view('vendors')->with([
                'users' => $users
            ]);
        }
        return view('products')->with([]);
    }

    public function categoryByVendor($user_id)
    {
        if (Session::get('showcasecity')) {
            $city = Session::get('showcasecity');
            $user = User::where('city', 'LIKE', '%' . $city . '%')->whereId($user_id)->where('status', true)->first();

            $subCategories = ProductSubcategory::join('products', 'product_subcategories.id', 'products.subcategory_id')
                ->where(['products.seller_id' => $user->id])
                ->groupBy('products.subcategory_id')
                ->select('product_subcategories.*')
                ->get();


            return view('sub_category')->with([
                'user' => $user,
                'subCategories' => $subCategories
            ]);
        }

        return redirect()->route('products');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productscategory($category)
    {
        // filter accordig to category

        return view('products')->with([]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productssubcategory($subcategory)
    {
        // filter accordig to subcategory

        return view('products')->with([]);
    }


    public function productsfromvendor($slug)
    {
        // filter according to vendor
        return view('products')->with([]);
    }


    public function productsshowcaseathome()
    {
        // filter only products which has showcase at home
        return view('products')->with([]);
    }


    public function productsshowcaseathomeforvendor()
    {
        // filter only products which has showcase at home from selected vendor
        return view('products')->with([]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product($slug)
    {
        Session::remove('quickviewid');

        if (Auth::check()) {
            if (auth()->user()->hasRole(['Vendor', 'admin', 'Client'])) {
                $product = Product::where('slug', $slug)->first();
            } else {
                // if customer
                $product = Product::where('slug', $slug)
                    ->where('admin_status', 'Accepted')
                    ->whereHas('vendor', function ($q) {
                        $q->where('status', 1);
                    })
                    ->first();
            }
        } else {
            $product = Product::where('slug', $slug)
                ->where('admin_status', 'Accepted')
                ->whereHas('vendor', function ($q) {
                    $q->where('status', 1);
                })
                ->first();
        }

        if (empty($product)) {
            return abort(404);
        }

//

        $relatedproducts = Product::where('admin_status', 'Accepted')
            ->where('subcategory_id', $product->subcategory_id)
            ->whereHas('vendor', function ($q) {
                $q->where('status', 1);
            })
            ->take(15)
            ->get();


        $subCat = ProductSubcategory::find($product->subcategory_id);
        $gender = $product->gender_id;

        /*
         * More "Sub Category name" from “Brand Name”
            as "More Formal Shoes from Maeve & Shelby"
        */
        $brandMoreText = 'More ' . $subCat->name . ' From ' . $product->brand_id;
        $brandLink = route('products.subcategory', [
            'subcategory' => $subCat->slug,
            'brands[' . $product->brand_id . ']' => $product->brand_id,
            'gender[' . $gender . ']' => $gender
        ]);
        $brandCount = $this->getNumberMoreButton($subCat->slug, [$gender], [$product->brand_id]);

        /*
         * More "Style id"  “Sub Category Name”
            as "More Floral-Print Formal-Shoes"
        */
        $moreStyleText = 'More ' . $product->style_id . ' ' . $subCat->name;
        $styleLink = route('products.subcategory', [
            'subcategory' => $subCat->slug,
            'style[' . $product->style_id . ']' => $product->style_id,
            'gender[' . $gender . ']' => $gender
        ]);

        $styleCount = $this->getNumberMoreButton($subCat->slug, [$gender], [], [], [$product->style_id]);
        /*
         * Colour
        */
        if (request('color') != null) {
            $selectedColor = request('color');
            $selectedColor = Productcolor::where('status', 1)->where('color', $selectedColor)->first();

        } else {
            $firstcolor = Productcolor::where('status', 1)->where('product_id', $product->id)->first();

            if (isset($firstcolor)) {
                if (!empty($firstcolor->color)) {
                    $selectedColor = $firstcolor;
                }
            }
        }

        $selectedColor = Color::where('name', 'Like', '%' . $selectedColor->color . '%')->first();
        $moreColourText = 'More ' . $selectedColor->name . ' ' . $subCat->name;
        $colourCount = $this->getNumberMoreButton($subCat->slug, [$gender], null, [$selectedColor->id]);

        $colourLink = route('products.subcategory', [
            'subcategory' => $subCat->slug,
            'color[' . $selectedColor->id . ']' => $selectedColor->id,
            'gender[' . $gender . ']' => $gender
        ]);

        if (Config::get('icrm.frontend.recentlyviewed.feature') == 1) {
            // add product in recently viewed list
            $this->recentlyviewed($product);
        }

        $shareComponent = \Share::page(
            route('product.slug', ['slug' => $product->slug]),
            $product->description,
        )
            ->facebook()
            ->linkedin()
            ->whatsapp();

        $previous = Product::where('admin_status', 'Accepted')->where('id', '<', $product->id)->orderBy('id')->first();
        $next = Product::where('admin_status', 'Accepted')->where('id', '>', $product->id)->orderBy('id')->first();

        /**
         * If the product color is sku
         * Check if the url does has color
         * Redirect to product.slug.color first color
         */
        // if(Config::get('icrm.product_sku.color') == 1)
        // {
        //     if(empty(request('color')))
        //     {
        //         if(count($product->productcolors) > 0)
        //         {
        //             // return redirect()->route('product.slug', ['slug' => $product->slug, 'color' => $product->productcolors[0]->name]);
        //         }
        //     }else{
        //         return redirect()->route('product.slug', ['slug' => $product->slug, 'color' => $product->productcolors[0]->name]);
        //     }
        // }

        // if(Config::get('icrm.multi_color_products.feature') == 1)
        // {
        //     if(Config::get('icrm.multi_color_products.select_first_color_by_default') == 1)
        //     {
        //         if(empty(request('color')))
        //         {
        //             if(count($product->productcolors) > 0)
        //             {
        //                 if(!empty($product->productcolors[0]->color))
        //                 {
        //                     return redirect()->route('product.slug', ['slug' => $product->slug, 'color' => $product->productcolors[0]->color]);
        //                 }
        //             }
        //         }
        //     }

        // }

//        dd($brandCount, $styleCount, $colourCount);

        return view('product')->with([
            'product' => $product,
            'brandLink' => $brandLink,
            'brandMoreText' => $brandMoreText,
            'brandCount' => $brandCount,

            'styleLink' => $styleLink,
            'styleCount' => $styleCount,
            'moreStyleText' => $moreStyleText,

            'colourLink' => $colourLink,
            'colourCount' => $colourCount,
            'moreColourText' => $moreColourText,
            // 'morecolors' => $morecolors,
            'relatedproducts' => $relatedproducts,
            'shareComponent' => $shareComponent,
            'previous' => $previous,
            'next' => $next
        ]);
    }

    private function getNumberMoreButton($selectedsubcategory, $genders, $brands = [], $colors = [], $styles = []){
        $products = Product::where('admin_status', 'Accepted')
            ->when($selectedsubcategory, function ($query) use($selectedsubcategory){
                $query->whereHas('productsubcategory', function ($q) use($selectedsubcategory){
                    $q->where('slug', $selectedsubcategory);
                });
            })
            ->when($genders, function ($query) use($genders){
                $query->whereIn('gender_id', array_values($genders));
            })

            ->when($brands, function ($query) use($brands){
                $query->whereIn('brand_id', array_values($brands));
            })
            ->when($colors, function ($query) use($colors){
                $query->whereHas('colors', function ($q) use($colors){
                    $q->whereIn('id', array_values($colors));
                });
            })
            ->when($styles, function ($query) use($styles){
                $query->whereIn('style_id', array_values($styles));
            })
        ;


        return $products->count();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productcolor($slug, $color)
    {
        $product = Product::where('slug', $slug)->where('admin_status', 'Accepted')->whereHas('productskus', function ($q) use ($color) {
            $q->where('color', $color);
        })->with('productsku')->first();


        $morecolors = Productsku::groupBy('color', 'main_image')
            ->select('color', DB::raw('count(*) as total'), 'main_image')
            ->where('product_id', $product->id)->where('status', 1)
            ->get();


        $similarproducts = Product::where('admin_status', 'Accepted')->where('id', '!=', $product->id)->take(10)->get();

        // add product in recently viewed list
        $this->recentlyviewed($product);


        return view('product')->with([
            'product' => $product,
            'morecolors' => $morecolors,
            'similarproducts' => $similarproducts
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productsin($slug, $sin)
    {
        $product = Product::where('slug', $slug)->where('id', $sin)->where('status', 1)->first();
        $morecolors = Product::where('product_group', $product->product_group)->where('id', '!=', $product->id)->where('status', 1)->get();
        $similarproducts = Product::where('status', 1)->take(10)->get();

        // add product in recently viewed list
        $this->recentlyviewed($product);


        return view('product')->with([
            'product' => $product,
            'morecolors' => $morecolors,
            'similarproducts' => $similarproducts
        ]);
    }


    function recentlyviewed($product)
    {
        $recentlyviewed = app('recentlyviewed');

        $recentlyviewed->add(
            $product->id,
            $product->name,
            $product->offer_price,
            '1'
        );

        return;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactus()
    {
        return view('contactus');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup()
    {
        return view('auth.signup');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function otpverification()
    {
        return view('auth.otp-verification');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailverification()
    {
        return view('auth.verify-email');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 'ACTIVE')->first();

        $previous = Page::where('id', '<', $page->id)
            ->orderBy('id', 'DESC')->first();

        $next = Page::where('id', '>', $page->id)
            ->orderBy('id')->first();

        return view('page')->with([
            'page' => $page,
            'previous' => $previous,
            'next' => $next
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slider($slug)
    {
        $slider = HomeSlider::where('id', $slug)->where('status', 1)->first();

        $previous = HomeSlider::where('status', 1)
            ->whereNull('url')
            ->where('id', '<', $slider->id)
            ->orderBy('id', 'DESC')->first();

        $next = HomeSlider::where('status', 1)
            ->whereNull('url')
            ->where('id', '>', $slider->id)
            ->orderBy('id')->first();


        /**
         * If URL is present then redirect to URL
         */
        if (!empty($slider->url)) {
            return redirect($slider->url);
        }

        return view('slider')->with([
            'slider' => $slider,
            'previous' => $previous,
            'next' => $next
        ]);
    }


    public function newslettersignup(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|email|unique:newsletters,email',
            ],
            [
                'email.unique' => 'You have already subscribed to our newsletters',
            ]
        );

        $newsletter = new Newsletter;
        $newsletter->email = $request->email;
        $newsletter->save();

        Session::put('signedupfornewsletter', true);
        Session::flash('success', 'Congratulations! You have successfully signedup for newsletters.');
        return redirect()->back();
    }
}
