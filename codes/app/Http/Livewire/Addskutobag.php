<?php

namespace App\Http\Livewire;

use App\Showcase;
use App\Productsku;
use App\Productcolor;
use App\Models\Product;
use Livewire\Component;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


class Addskutobag extends Component
{
    use WithFileUploads;

    public $product;
    public $size;
    public $color;
    public $max_g_need;
    public $requireddocument;
    public $qty = 1;

    public $disablebtn = true;
    public $availablestock = 0;

    public $offer_price;
    public $mrp;

    // disabled 900 to 910 lines on main.js

    protected $listeners = ['addtobag' => 'addtobag'];


    public function mount($product)
    {

        Session::remove('qtynotavailable');

        $this->product = $product;

        $this->offer_price = $product->offer_price;
        $this->mrp = $product->mrp;

        if(request('color') != null)
        {
            $this->color = request('color');
        }


        if(Config::get('icrm.multi_color_products.feature') == 1)
        {
            if(Config::get('icrm.multi_color_products.select_first_color_by_default') == 1)
            {
                if(request('color') == null)
                {

                    $firstcolor = Productcolor::where('status', 1)->where('product_id', $this->product->id)->first();

                    if(isset($firstcolor))
                    {
                        if(!empty($firstcolor->color))
                        {
                            $this->color = $firstcolor->color;
                        }
                    }

                }
            }
        }

    }


    public function selectcolor($color)
    {
        $this->color = $color;

        if(Config::get('icrm.multi_color_products.feature') == 1)
        {
            $this->emit('getcolorimages', $color);
            // $this->emit('showcolorimage', $color);
        }

    }

    public function selectsize($size)
    {
        /**
         * If stock management is enabled then check if the size is available in sku
         * Else update size
         */
        if(Config::get('icrm.stock_management.feature') == 1)
        {
            if(Config::get('icrm.product_sku.color') == 1)
            {
                if($this->product->productskus->where('size', $size)->where('color', $this->color)->first()->available_stock > 0)
                {
                    $this->size = $size;
                }
            }else{
                if($this->product->productskus->where('size', $size)->first()->available_stock > 0)
                {
                    $this->size = $size;
                }
            }
        }else{
            $this->size = $size;
        }

    }

    public function updatedRequireddocument()
    {

        $this->validate([
            'requireddocument' => 'mimes:docx|max:5120', // 5MB Max
        ]);

    }

    public function updatedQty()
    {
        $this->qty = $this->qty;
    }

    public function plusqty()
    {
        if(Config::get('icrm.stock_management.feature') == 1)
        {
            if($this->availablestock > 0)
            {
                if($this->availablestock != $this->qty)
                {
                    $this->qty++;
                }else{
                    Session::flash('qtynotavailable', 'Only '.$this->availablestock.' item left');
                }
            }
        }else{
            $this->qty++;
        }

    }

    public function minusqty()
    {
        $this->qty--;
    }


    public function render()
    {

        if($this->qty < 1)
        {
            $this->qty = 1;
        }


        if(Config::get('icrm.stock_management.feature') == 1)
        {
            if(Config::get('icrm.product_sku.color') == 1)
            {
                if(!empty($this->size) AND !empty($this->color))
                {
                    if($this->product->productskus->where('size', $this->size)->where('color', $this->color)->first()->available_stock > 0)
                    {
                        $this->availablestock = $this->product->productskus->where('size', $this->size)->where('color', $this->color)->first()->available_stock;
                    }
                }

            }else{
                if(!empty($this->size))
                {
                    if($this->product->productskus->where('size', $this->size)->first()->available_stock > 0)
                    {
                        $this->availablestock = $this->product->productskus->where('size', $this->size)->first()->available_stock;
                    }
                }
            }
        }


        if(Config::get('icrm.product_sku.size') == 0 AND Config::get('icrm.product_sku.color') == 0)
        {
            if($this->product->productskus->first()->available_stock > 0)
            {
                $this->availablestock = $this->product->productskus->first()->available_stock;
            }
        }



        if(!empty($this->size))
        {
            if(!empty($this->product->productskus->where('size', $this->size)->first()->offer_price))
            {
                if(!empty($this->color))
                {
                    $this->offer_price = $this->product->productskus->where('size', $this->size)->where('color', $this->color)->first()->offer_price;
                    $this->mrp = $this->product->productskus->where('size', $this->size)->where('color', $this->color)->first()->mrp;
                }else{
                    $this->offer_price = $this->product->productskus->where('size', $this->size)->first()->offer_price;
                    $this->mrp = $this->product->productskus->where('size', $this->size)->first()->mrp;
                }
            }else{
                $this->offer_price = $this->product->offer_price;
                $this->mrp = $this->product->mrp;
            }
        }

        $this->validateskufields();


        return view('livewire.addskutobag');
    }


    public function addtobag()
    {
        $this->validateskufields();

        $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }
        /**
         * Generate random row id
         * If the product is already in the cart then fetch that product cart row id and assign
        */

        // check if same product is already in the cart
        $validatecartrowid = \Cart::session($userID)->getContent()
        ->where('attributes.product_id', $this->product->id)
        ->where('attributes.size', $this->size)
        ->where('attributes.color', $this->color)
        ->where('attributes.g_plus', $this->max_g_need)
        ->where('attributes.customized_image', null)
        ->first();



        // if product exists in the cart then fetch cart row id
        if(!empty($validatecartrowid))
        {
            // restrict user to add more than allowed qty of the each product
            if($validatecartrowid->quantity >= Config::get('icrm.order_options.max_qty_per_product'))
            {
                Session::flash('warning', 'You can only purchase maximum '.Config::get('icrm.order_options.max_qty_per_product').' quantity of each product per order!');
                return redirect()->route('product.slug', ['slug' => $this->product->slug]);
            }else{
                $cartrowid = $validatecartrowid->id;

                // if size is a part of sku field then fetch weight from sku row
                if(Config::get('icrm.product_sku.size') == 1)
                {
                    // check if color is a part of sku fields then fetch weight from sku row for size + color
                    if(Config::get('icrm.product_sku.color') == 1)
                    {
                        // get sku weight for size + color
                        $skuweight = Productsku::where('product_id', $this->product->id)->where('status', 1)->where('size', $this->size)->where('color', $this->color)->first();
                    }else{
                        // get sku weight for size
                        $skuweight = Productsku::where('product_id', $this->product->id)->where('status', 1)->where('size', $this->size)->first();
                    }

                    if(empty($skuweight))
                    {
                        // sku is empty so fetch default product dimensions
                        $cartweight = $this->product->weight * ($validatecartrowid->quantity + 1);
                    }else{
                        // sku weight
                        $cartweight = $skuweight->weight * ($validatecartrowid->quantity + 1);
                    }


                }else{
                    $cartweight = $this->product->weight * ($validatecartrowid->quantity + 1);
                }

            }


        }else{

            // Generate random row id
            $cartrowid = mt_rand(1000000000, 9999999999);

        }

        /**
         * Check if stock management is enabled
         * If same sku with other varient is already added then fetch its quantity
         * Check if stock exceeded
         */

        if(Config::get('icrm.stock_management.feature') == 1)
        {
            $sameproduct = \Cart::session($userID)->getContent()
                ->where('attributes.product_id', $this->product->id)
                ->where('attributes.size', $this->size)
                ->where('attributes.color', $this->color);

            if(count($sameproduct) > 0)
            {
                $alreadyincart = $sameproduct->sum('quantity');
            }else{
                $alreadyincart = 0;
            }

            // dd($this->availablestock);
            if($alreadyincart + $this->qty > $this->availablestock)
            {
                // dd('a');
                Session::flash('danger', 'Only '.$this->availablestock.' item available! and out of which you have already added '.$alreadyincart.' item in '.Config::get('icrm.cart.name').'.');
                return redirect()->route('product.slug', ['slug' => $this->product->slug]);
            }

        }


        // if the product is customized
        if(isset($this->customized_image))
        {
            $CustomizeImageName = 'Customized - '.time().'.'.$this->customized_image->extension();

            $this->customized_image->move(public_path('images/customized/'), $CustomizeImageName);

        }else{
            $CustomizeImageName = '';
        }


        if(isset($this->original_file))
        {
            $OriginialImageName = 'Originial - '.time().'.'.$this->original_file->extension();

            $this->original_file->move(public_path('images/customized/'), $OriginialImageName);
        }else{
            $OriginialImageName = '';
        }

        if(!empty($this->max_g_need))
        {
            // calculate max g plus value
            $gpluscharges = $this->max_g_need * $this->product->cost_per_g;

            $maxgplus = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'maxgplus',
                'type' => 'maxgplus',
                'value' => '+'.$gpluscharges,
                'order' => 1,
            ));
        }else{
            $maxgplus = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'maxgplus',
                'type' => 'maxgplus',
                'value' => '+0',
                'order' => 1,
            ));
            $gpluscharges = '0';
        }

        if(isset($cartweight)){
            $cartweight = $cartweight;
        }else{
            // $cartweight = $this->product->weight;

            // if size is a part of sku field then fetch weight from sku row
            if(Config::get('icrm.product_sku.size') == 1)
            {
                // check if color is a part of sku fields then fetch weight from sku row for size + color
                if(Config::get('icrm.product_sku.color') == 1)
                {
                    // get sku weight for size + color
                    $skuweight = Productsku::where('product_id', $this->product->id)->where('status', 1)->where('size', $this->size)->where('color', $this->color)->first();
                }else{
                    // get sku weight for size
                    $skuweight = Productsku::where('product_id', $this->product->id)->where('status', 1)->where('size', $this->size)->first();
                }

                if(empty($skuweight))
                {
                    // sku is empty so fetch default product dimensions
                    $cartweight = $this->product->weight;
                }else{
                    // sku weight
                    $cartweight = $skuweight->weight;
                }


            }else{
                $cartweight = $this->product->weight;
            }
        }


        if(Config::get('icrm.tax.type') == 'subcategory')
        {
            /**
             * Add Tax according to product subcategory tax value
             */

            // or add multiple conditions from different condition instances
            $tax = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'tax',
                'type' => 'tax',
                'value' => $this->product->productsubcategory->gst.'%',
                'order' => 2
            ));
        }else{
            $tax = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'tax',
                'type' => 'tax',
                'value' => '+0',
                'order' => 2
            ));
        }


        if(!empty($CustomizeImageName) AND !empty($OriginialImageName))
        {
            $ordertype = 'Customized';
        }else{
            $ordertype = 'Regular';
        }

        // if required document is attached
        // then store and put filename in the cart
        if(!empty($this->requireddocument))
        {
            $storefile = $this->requireddocument->storeAs('requireddocument', $this->product->id.'-'.time().'.docx', 'public');
            $requireddocument = 'storage/'.$storefile;
        }else{
            $requireddocument = '';
        }


        // add to cart with conditions
        $item = array(
            'id' => $cartrowid,
            'name' => $this->product->name,
            'price' => $this->offer_price,
            'quantity' => $this->qty,
            'attributes' => array(
                'size' => $this->size,
                'product_id' => $this->product->id,
                'customized_image' => $CustomizeImageName,
                'original_file' => $OriginialImageName,
                'color' => $this->color,
                'g_plus' => $this->max_g_need,
                'cost_per_g' => $this->product->cost_per_g,
                'g_plus_charges' => $gpluscharges,
                'weight' => $cartweight,
                'hsn' => $this->product->productsubcategory->hsn,
                'gst' => $this->product->productsubcategory->gst,
                'type' => $ordertype,
                'requireddocument' => $requireddocument,

            ),
            'conditions' => [$maxgplus, $tax]
        );

        $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }
        \Cart::session($userID)->add($item);

        // if(Auth::check()){
        //     \App\Models\Cart::firstOrCreate(['cartrowid' => $cartrowid], [
        //         'cartrowid' => $cartrowid,
        //         'name' => $this->product->name,
        //         'price' => $this->offer_price,
        //         'quantity' => $this->qty,
        //         'attributes' => json_encode(array(
        //             'size' => $this->size,
        //             'product_id' => $this->product->id,
        //             'customized_image' => $CustomizeImageName,
        //             'original_file' => $OriginialImageName,
        //             'color' => $this->color,
        //             'g_plus' => $this->max_g_need,
        //             'cost_per_g' => $this->product->cost_per_g,
        //             'g_plus_charges' => $gpluscharges,
        //             'weight' => $cartweight,
        //             'hsn' => $this->product->productsubcategory->hsn,
        //             'gst' => $this->product->productsubcategory->gst,
        //             'type' => $ordertype,
        //             'requireddocument' => $requireddocument,

        //         )),
        //         'conditions' => json_encode([$maxgplus, $tax])
        //     ]);
        // }

        $this->added = true;

        Session::remove('quickviewid');

        Session::flash('success', 'Product successfully added to cart');

        return redirect()->route('bag');
        // return redirect()->route('product.slug', ['slug' => $this->product->slug, 'color' => $this->color]);
    }




    private function validateskufields()
    {
        if(count($this->product->productcolors->where('color', '!=', 'NA')) > 0)
        {
            if(empty($this->color))
            {
                // Session::flash('warning', 'Please select color');
                return $this->disablebtn = true;
            }
        }else{
            $this->color = 'NA';
        }

        if(count($this->product->productskus->where('size', '!=', 'NA')) > 0)
        {
            if(empty($this->size))
            {
                // Session::flash('warning', 'Please select size');
                return $this->disablebtn = true;
            }
        }else{
            $this->size = 'NA';
        }


        if($this->qty < 1)
        {
            // Session::flash('warning', 'Please add quantity');
            return $this->disablebtn = true;
        }

        // if max g is needed
        if($this->product->productsubcategory->name == 'COP')
        {
            if(!empty($this->product->max_g))
            {
                if(empty($this->max_g_need))
                {
                    return $this->disablebtn = true;
                }
            }
        }

        // if requirement document is needed
        if(isset($this->product->requirement_document))
        {
            if(count(json_decode($this->product->requirement_document)) > 0)
            {
                if(empty($this->requireddocument))
                {
                    return $this->disablebtn = true;
                }elseif(substr($this->requireddocument->getRealPath(), -5) != '.docx'){
                    return $this->disablebtn = true;
                }
            }
        }



        $this->disablebtn = false;

        if($this->disablebtn == true)
        {
            Session::flash('warning', 'Please select product variation');
            return redirect()->back();
        }

        if($this->product->admin_status != 'Accepted')
        {
            Session::flash('warning', 'Product is not for sale!');

            return redirect()->route('product.slug', ['slug' => $this->product->slug]);
        }

    }


    public function addtoshowcaseathome()
    {
        $this->validateskufields();

        if(!Auth::check())
        {
            if(!session()->has('url.intended'))

            {
                session(['url.intended' => url()->previous()]);
            }

            return redirect()->route('login');
        }

        $showcase = app('showcase');
        $showcasecontent = app('showcase')->getContent();


        /**
         * If showcase at home has products already
         * then check if the selected products is from same vendor else show error msg
         */
        if(count($showcasecontent) > 0)
        {
            $notsamevendor = $showcasecontent->where('attributes.vendor_id', '==', $this->product->seller_id)->first();

            if(empty($notsamevendor))
            {
                $msg = 'At a time you can request showcase at home only from one vendor. <a href="'.url('/products/vendor/'.$this->product->seller_id).'" style="text-decoration: underline; color: black; font-weight: 600;"> Click here </a> to browse products from '.ucwords($this->product->vendor->brand_name).' vendor';

                // dd('a');
                Session::flash('warning', $msg);
                return redirect()->route('product.slug', ['slug' => $this->product->slug]);
            }
        }


        /**
         * Validate how many active showcases one customer can have
         */

        $activeshowcases = Showcase::where('user_id', auth()->user()->id)->where('order_status', 'New Order')->select('order_id')->groupBy('order_id')->count();

        if($activeshowcases == Config::get('icrm.showcase_at_home.active_orders'))
        {
            Session::flash('warning', 'At a time you can place only '.Config::get('icrm.showcase_at_home.active_orders').' active showcase at home orders.');
            return redirect()->route('product.slug', ['slug' => $this->product->slug]);
        }

        /**
         * Check if the allowed showcase at home products count exceeds
         */
        if(count(app('showcase')->getContent()) == Config::get('icrm.showcase_at_home.order_limit'))
        {
            Session::flash('warning', 'You can showcase at home only '.Config::get('icrm.showcase_at_home.order_limit').' items in one order.');
            return redirect()->to(route('product.slug', ['slug' => $this->product->slug]))->with([
                'warning' => 'You can showcase at home only '.Config::get('icrm.showcase_at_home.order_limit').' items in one order.',
            ]);
        }

        /**
         * Check if same product is already is showcase
        */
        if(count($showcase->getContent()->where('attributes.product_id', $this->product->id)->where('attributes.size', $this->size)->where('attributes.color', $this->color)) > 0){
            Session::flash('warning', 'This product has already been added in the showcase at home');
            return redirect()->route('product.slug', ['slug' => $this->product->slug]);
        }

        /**
         * Get the color image of the selected product
         */
        $colorimage = Productcolor::where('product_id', $this->product->id)->where('color', $this->color)->first();


        if(empty($colorimage))
        {
            $colorimage = $this->product->image;
        }else{
            $colorimage = $colorimage->main_image;
        }


        // add
        $showcase->add([
            'id' => $this->color.$this->size.$this->product->id,
            'name' => $this->product->name,
            'price' => $this->offer_price,
            'quantity' => '1',
            'attributes' => array(
                'product_id' => $this->product->id,
                'slug' => $this->product->slug,
                'image' => $colorimage,
                'size' => $this->size,
                'color' => $this->color,
                'weight' => $this->product->weight,
                'hsn' => $this->product->productsubcategory->hsn,
                'gst' => $this->product->productsubcategory->gst,
                'vendor_id' => $this->product->seller_id,
                'vendor_city' => $this->product->vendor->city,
                'type' => 'Showcase At Home'
            )
        ]);

        Session::put('showcasevendor', $this->product->vendor->brand_name);
        Session::put('showcasevendorid', $this->product->seller_id);

        $this->added = true;

        Session::remove('quickviewid');

        Session::flash('success', 'Product successfully added to showcase at home');

        if(Session::get('showcasecity') == null)
        {
            return redirect()->route('showcase.getstarted');
        }


        return redirect()->route('showcase.bag');

    }


    public function addtocustomize()
    {
        $this->validateskufields();

        /**
         * Check if stock management is enabled
         * If same sku with other varient is already added then fetch its quantity
         * Check if stock exceeded
         */

        if(Config::get('icrm.stock_management.feature') == 1)
        {
            $userID = 0;
        if(Auth::check()){
            $userID = auth()->user()->id;
        }
        else{
            if(session('session_id')){
                $userID = session('session_id');
            }
            else{
                $userID = rand(1111111111,9999999999);
                session(['session_id' => $userID]);
            }
        }
            $sameproduct = \Cart::session($userID)->getContent()
                ->where('attributes.product_id', $this->product->id)
                ->where('attributes.size', $this->size)
                ->where('attributes.color', $this->color);

            if(count($sameproduct) > 0)
            {
                $alreadyincart = $sameproduct->sum('quantity');
            }else{
                $alreadyincart = 0;
            }

            // dd($this->availablestock);
            if($alreadyincart + $this->qty > $this->availablestock)
            {
                // dd('a');
                Session::flash('danger', 'Only '.$this->availablestock.' item available! and out of which you have already added '.$alreadyincart.' item in '.Config::get('icrm.cart.name').'.');
                return redirect()->route('product.slug', ['slug' => $this->product->slug]);
            }

        }

        $customize = app('customize');
        $customizecontent = app('customize')->getContent();

        /**
         * Generate random row id
         * If the product is already in the cart then fetch that product cart row id and assign
        */

        // check if same product is already in the cart
        $validatecartrowid = $customizecontent
        ->where('attributes.product_id', $this->product->id)
        ->where('attributes.size', $this->size)
        ->where('attributes.color', $this->color)
        ->where('attributes.g_plus', $this->max_g_need)
        ->first();



        // if product exists in the cart then fetch cart row id
        if(!empty($validatecartrowid))
        {
            // restrict user to add more than allowed qty of the each product
            if($validatecartrowid->quantity >= Config::get('icrm.order_options.max_qty_per_product'))
            {
                Session::flash('warning', 'You can only purchase maximum '.Config::get('icrm.order_options.max_qty_per_product').' quantity of each product per order!');
                return redirect()->route('product.slug', ['slug' => $this->product->slug]);
            }else{
                $cartrowid = $validatecartrowid->id;
                $cartweight = $this->product->weight * ($validatecartrowid->quantity + 1);
            }
        }else{

            // Generate random row id
            $cartrowid = mt_rand(1000000000, 9999999999);
        }


        if(!empty($this->max_g_need))
        {
            // calculate max g plus value
            $gpluscharges = $this->max_g_need * $this->product->cost_per_g;
            $maxgplus = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'maxgplus',
                'type' => 'maxgplus',
                'value' => '+'.$gpluscharges,
                'order' => 1,
            ));
        }else{
            $maxgplus = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'maxgplus',
                'type' => 'maxgplus',
                'value' => '+0',
                'order' => 1,
            ));
            $gpluscharges = '0';
        }

        if(isset($cartweight)){
            $cartweight = $cartweight;
        }else{
            $cartweight = $this->product->weight;
        }


        if(Config::get('icrm.tax.type') == 'subcategory')
        {
            /**
             * Add Tax according to product subcategory tax value
             */

            // or add multiple conditions from different condition instances
            $tax = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'tax',
                'type' => 'tax',
                'value' => $this->product->productsubcategory->gst.'%',
                'order' => 2
            ));
        }else{
            $tax = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'tax',
                'type' => 'tax',
                'value' => '+0',
                'order' => 2
            ));
        }


        // if required document is attached
        // then store and put filename in the cart
        if(!empty($this->requireddocument))
        {
            $storefile = $this->requireddocument->storeAs('requireddocument', $this->product->id.'-'.time().'.docx', 'public');
            $requireddocument = 'storage/'.$storefile;
        }else{
            $requireddocument = '';
        }


        // add to customize cart with conditions
        $customize->add([
            'id' => $cartrowid,
            'name' => $this->product->name,
            'price' => $this->product->offer_price,
            'quantity' => $this->qty,
            'attributes' => array(
                'size' => $this->size,
                'product_id' => $this->product->id,
                'customized_image' => '',
                'original_file' => '',
                'color' => $this->color,
                'g_plus' => $this->max_g_need,
                'cost_per_g' => $this->product->cost_per_g,
                'g_plus_charges' => $gpluscharges,
                'weight' => $cartweight,
                'hsn' => $this->product->productsubcategory->hsn,
                'gst' => $this->product->productsubcategory->gst,
                'type' => 'Customized',
                'requireddocument' => $requireddocument,
            ),
            'conditions' => [$maxgplus, $tax],
        ]);


        Session::remove('quickviewid');

        return redirect()->route('customize', ['customizeid' => $cartrowid]);
    }

}
