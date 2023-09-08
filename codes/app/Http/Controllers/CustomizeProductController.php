<?php

namespace App\Http\Controllers;

use Image;
use App\Productcolor;
use App\Models\Product;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CustomizeProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function introduction()
    {
        // $page = Page::where('slug', 'customize-introduction')->where('status', 'ACTIVE')->first();

        // if(empty($page))
        // {
        //     return abort(404);
        // }

        return view('customize.introduction')->with([
            // 'page' => $page
        ]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customize()
    {
        $customizecart= app('customize')->get(request('customizeid'));

        if(empty($customizecart))
        {
            return abort('404');
        }


        $product = Product::where('id', $customizecart->attributes->product_id)->first();

        if(empty($product))
        {
            return abort('404');
        }

        /**
         * Check if product offers customization
         * Else redirect back with error
         * Destroy from cart session
         */

        if(empty($product->customize_images))
        {
            Session::flash('danger', 'Selected product does not offer customization');
            app('customize')->clear(request('customizeid'));
            return redirect()->back();
        }


        /**
         * Fetch cart product color customizable image
         * If not available then fetch product customizable image
         */
        $customizableimage = Productcolor::where('product_id', $customizecart->attributes->product_id)->where('color', $customizecart->attributes->color)->first();

        if(!empty($customizableimage->customizable_image))
        {
            $customizableimage = $customizableimage->customizable_image;
        }else{
            $customizableimage = $product->customize_images;
        }



        return view('customize.customize')->with([
            'product' => $product,
            'customizecart' => $customizecart,
            'customizableimage' => $customizableimage
        ]);
    }



    public function customized(Request $request)
    {
        $customizeid = $request->customizeid;

        $png_url = "customized-product-".$customizeid.".png";
        $path = public_path().'/images/customized_images/'.$png_url;

        // https://stackoverflow.com/questions/26785940/laravel-save-base64-png-file-to-public-folder-from-controller
        // https://stackoverflow.com/questions/55820359/how-to-upload-canvas-image-to-storage-on-laravel
        $image = Image::make(file_get_contents($request->imgBase64));

        $filename = 'customized-product-'.$customizeid.'.png';

        Storage::disk('public')->putFileAs(
            'images/customized_images/',
            $request->imgBase64,
            $filename
        );
    }



    public function sharefiles()
    {
        $customizecart= app('customize')->get(request('customizeid'));

        if(empty($customizecart))
        {
            return abort('404');
        }


        $product = Product::where('id', $customizecart->attributes->product_id)->first();

        if(empty($product))
        {
            return abort('404');
        }

        /**
         * Check if product offers customization
         * Else redirect back with error
         * Destroy from cart session
         */

        if(empty($product->customize_images))
        {
            Session::flash('danger', 'Selected product does not offer customization');
            app('customize')->clear(request('customizeid'));
            return redirect()->back();
        }


        $customizableimage = asset('/storage/images/customized_images/customized-product-'.request('customizeid').'.png');
        // dd($customizableimage);

        return view('customize.sharefiles')->with([
            'customizecart' => $customizecart,
            'product' => $product,
            'customizableimage' => $customizableimage
        ]);
    }


    public function movetobag(Request $request)
    {
        $request->validate([
            'customizeid' => 'required',
            'requireddocument' => 'nullable',
            'customizedimage' => 'required',
            'originalimage' => 'required'
        ]);


        $customizecart= app('customize')->get($request->customizeid);

        $product = Product::where('id', $customizecart->attributes->product_id)->first();

        // Generate random row id
        $cartrowid = mt_rand(1000000000, 9999999999);
        $cartweight = $product->weight * $customizecart->quantity;

        $customizedimage = $request->customizedimage;

        $attachedoriginalimages = $request->file('originalimage');

        // dd($attachedoriginalimages);

        if($request->hasFile('originalimage'))
         {

            $originalimages = [];

            foreach($attachedoriginalimages as $originalimage)
            {

                if($originalimage->extension() != 'bin' AND $originalimage->extension() != 'zip' AND $originalimage->extension() != 'cdr')
                {
                    Session::flash('danger', 'Upload only CDR files of the original images used while customizing product.');
                    return redirect()->back();
                }

            }


            foreach($attachedoriginalimages as $originalimage)
            {

                $filename = time().str_replace(' ', '', $originalimage->getClientOriginalName());
                // '.'.$originalimage->extension()

                Storage::disk('public')->putFileAs(
                    'images/original_images/',
                    $originalimage,
                    $filename
                );

                $originalimages[] = asset('/storage/images/original_images/'.$filename);
            }
         }



        if($customizecart->attributes->g_plus != null)
        {
            // calculate max g plus value
            $gpluscharges = $customizecart->attributes->g_plus * $product->cost_per_g;
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



        if(Config::get('icrm.tax.type') == 'subcategory')
        {
            /**
             * Add Tax according to product subcategory tax value
             */

            // or add multiple conditions from different condition instances
            $tax = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'tax',
                'type' => 'tax',
                'value' => $product->productsubcategory->gst.'%',
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


        $ordertype = 'Customized';

        // if required document is attached
        $requireddocument = $request->requireddocument;


        // add to cart with conditions
        $item = array(
            'id' => $cartrowid,
            'name' => $product->name,
            'price' => $product->offer_price,
            'quantity' => $customizecart->quantity,
            'attributes' => array(
                'size' => $customizecart->attributes->size,
                'product_id' => $customizecart->attributes->product_id,
                'customized_image' => $customizedimage,
                'original_file' => $originalimages,
                'color' => $customizecart->attributes->color,
                'g_plus' => $customizecart->attributes->g_plus,
                'cost_per_g' => $product->cost_per_g,
                'g_plus_charges' => $gpluscharges,
                'weight' => $cartweight,
                'hsn' => $product->productsubcategory->hsn,
                'gst' => $product->productsubcategory->gst,
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

        // delete customize from customize cart
        app('customize')->clear($request->customized);

        Session::remove('quickviewid');

        Session::flash('success', 'Customized product successfully added to cart');

        return redirect()->route('bag');
    }



    public function uploadmedia(Request $request)
    {
        if (Config::get('icrm.customize.your_media') == 1)
        {
            $customizeid = $request->customizeid;

            $image = Image::make(file_get_contents($request->imgBase64));

            $filename = "customized-product-media".$customizeid."-".time().".png";

            Storage::disk('public')->putFileAs(
                'images/customized_media/'.auth()->user()->id,
                $request->imgBase64,
                $filename
            );
        }
    }
}
