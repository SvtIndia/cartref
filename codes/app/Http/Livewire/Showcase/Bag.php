<?php

namespace App\Http\Livewire\Showcase;

use App\Models\Product;
use App\Models\User;
use App\ProductSubcategory;
use Carbon\Carbon;
use Livewire\Component;
use Darryldecode\Cart\Cart;
use App\DeliveryServicableArea;
use Seshac\Shiprocket\Shiprocket;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class Bag extends Component
{
    public $deliveryavailability = false;
    public $deliverypincode;
    public $city;
    public $area;

    protected $listeners = ['showcasebag' => 'render'];

    public function mount()
    {
        if (Session::get('showcasepincode') != null) {
            Session::put('deliverypincode', Session::get('showcasepincode'));
        }

        $this->deliverypincode = Session::get('deliverypincode');

    }


    public function render()
    {
        // \Cart::clear();
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

        $showcasecarts = app('showcase')->session($userID)->getContent();

        if (count($showcasecarts) == 0) {
            Session::remove('deliverypincode');
            Session::remove('sdeliveryavailable');
            Session::remove('sdeliverynotavailable');
        }

        $subtotal = Config::get('icrm.showcase_at_home.delivery_charges');

        $total = Config::get('icrm.showcase_at_home.delivery_charges');


        if (!empty(Session::get('deliverypincode'))) {
            $this->deliveryavailability = true;
            // Session::flash('deliveryavailable', 'Delivery available in this area');
        }

        return view('livewire.showcase.bag')->with([
            'showcasecarts' => $showcasecarts,
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }


    public function removeShowcase($showcaseid)
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

        $showcase = app('showcase')->session($userID);
        $showcase->remove($showcaseid);

        $this->emit('showcasecount');
    }

    public function wishlist($wishlistproductid, $showcase_id)
    {


        if (Config::get('icrm.frontend.wishlist.auth') == true) {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
        }

        // dd($this->wishlistproductid);
        // $wishlistproductid;

        $product = Product::where('id', $wishlistproductid)->first();
        // dd($product);
        if (empty($product)) {
            Session::flash('danger', 'There is something wrong. Please refresh the page and try again!');
            return redirect()->back();
        }

        $wishlist = app('wishlist');

        // if($this->wishlistchecked == true)
        // {
        //     // remove
        //     $wishlist->remove($product->id);

        //     $this->wishlistchecked = false;

        //     // Session::flash('success', 'Product successfully removed from the wishlist!');
        // }else{
        try {

            $wishlist->add(
                $product->id,
                $product->name,
                $product->offer_price,
                '1'
            );
            $this->removeShowcase($showcase_id);
            $this->dispatchBrowserEvent('showToast', ['msg' => 'Product successfully moved to the wishlist!', 'status' => 'success']);
        } catch (Throwable $e) {
            $this->dispatchBrowserEvent('showToast', ['msg' => $e->getMessage(), 'status' => 'error']);

        }

        //     $this->wishlistchecked = true;
        //     // Session::flash('success', 'Product successfully added in the wishlist!');
        // }

        // dd($this->wishlistchecked);
        $this->emit('wishlistcount');

        // Session::remove('quickviewid');

        return;
        // return redirect(request()->header('Referer'));
    }

    public function checkserviceavailability()
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
        /**
         * Find city for entered delivery pincode
         * Check if the city is under servicable area for showcase at home
         */
        $this->mapcitystate($this->deliverypincode);

        if (!empty($this->city)) {
            // check status of service in this city
            $deliveryservicablearea = DeliveryServicableArea::where('status', 1)->where('city', $this->city)->first();
        } else {
            // notdeliverable
            Session::flash('sdeliverynotavailable', 'Showcase at home not available in your area');
            Session::remove('deliverypincode');
            return;
        }

        if (empty($deliveryservicablearea)) {
            // notdeliverable
            Session::flash('sdeliverynotavailable', 'Showcase at home not available in your area');
            Session::remove('deliverypincode');
            return;
        } else {

            $showcasecarts = app('showcase')->session($userID)->getContent();

            foreach ($showcasecarts as $showcase) {
                // check if there is any product whos vendor city is not matching with customer city, if exists then show error message.
                if ($showcase->attributes->vendor_city != $deliveryservicablearea->city) {
                    Session::flash('sdeliverynotavailable', 'Please select products from vendors within ' . $deliveryservicablearea->city . '.');
                    Session::remove('deliverypincode');
                    return;
                }
            }
            // deliverable
            Session::flash('sdeliveryavailable', 'Showroom at Home is available in your area ' . $this->area . ' till ' . Carbon::now()->addHours(3)->format('H:i A') . ' for today');
            Session::put('deliverypincode', $this->deliverypincode);
            return;
        }
    }

    public function continueShopping(){
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
        $carts = app('showcase')->session($userID)->getContent();

        //Main code
        if(count($carts) <= 0){
            return;
        }

        if(count($carts) == 1){
            $cart = $carts->first();
            $product = Product::where('id', $cart->attributes->product_id)->first();
            $subCategory = ProductSubcategory::find($product->subcategory_id);
            $vendor = User::find($product->seller_id);
            $link = route('products.subcategory', ['subcategory' => $subCategory->slug, 'brands[' . $vendor->brands . ']' => $vendor->brands]);
            return redirect($link);
        }
        else{

            $vendorId = $carts->first()->attributes->vendor_id;
            return redirect()->route('products-category', ['vendor_id' => $vendorId]);
        }
    }

    private function mapcitystate($pincode)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.postalpincode.in/pincode/{$pincode}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // "Authorization: Basic ZTA4MjE1MGE3YTQxNWVlZjdkMzE0NjhkMWRkNDY1Og==",
                // "Postman-Token: c096d7ba-830d-440a-9de4-10425e62e52f",
                // "api-key: eb6e38f684ef558a1d64fcf8a75967",
                "cache-control: no-cache",
                // "customerId: 259",
                // "organisation-id: 1",
                'Content-Type: 	application/json; charset=utf-8',
            ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // dd($response);

            $collection = json_encode(collect($response));
            $collection = json_decode(json_decode($collection)[0])[0];

            if (collect($collection)['Status'] == '404') {
                Session::flash('danger', 'Invalid Pincode');
                // return;
                exit;
                $refresh;
            }


            if (collect($collection)['Status'] != 'Error') {
                if (collect($collection)['PostOffice'][0]->Country == 'India') {
                    // dd($this->city = collect($collection)['PostOffice'][0]);
                    $this->city = collect($collection)['PostOffice'][0]->District;
                    // $this->state = collect($collection)['PostOffice'][0]->State;
                    // $this->country = collect($collection)['PostOffice'][0]->Country;
                }
            }
            $this->area = collect($collection)['PostOffice'][0]->Name;

            // $this->validate();

        }


    }


    public function proceedcheckout()
    {
        /**
         * First check if the shipping serviceavailibity is checked
         * If not then redirect back with error message
         */

        if ($this->deliveryavailability == false) {
            Session::flash('warning', 'Before proceesing please check service availability.');
            return redirect()->route('showcase.bag');
        }

        if (empty(Session::get('deliverypincode'))) {
            Session::flash('warning', 'Before proceesing please check service availability.');
            return redirect()->route('showcase.bag');
        }

        return redirect()->route('showcase.checkout');
    }
}
