<?php

namespace App\Http\Livewire\Product;

use App\Productcolor;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Config;

class Productimages extends Component
{
    public $product;
    public $urlcolor;
    public $colorproductmainimage;
    public $colorproductmoreimages;

    protected $listeners = ['getcolorimages' => 'getcolorimages'];

    public function mount($product)
    {
        $this->product = $product;

        if(!empty(request('color')))
        {
            // fetch color info
            $colorproduct = Productcolor::where('status', 1)->where('product_id', $this->product->id)->where('color', request('color'))->first();


            // check if color main image is available or not
            if(isset($colorproduct))
            {
                if(!empty($colorproduct->main_image))
                {
                    $this->colorproductmainimage = $colorproduct->main_image;
                }

                if(!empty($colorproduct->more_images))
                {
                    $this->colorproductmoreimages = $colorproduct->more_images;
                }
            }
            
        }else{

            // fetch color info
            $colorproduct = Productcolor::where('status', 1)->where('product_id', $this->product->id)->first();
            
            // check if color main image is available or not
            if(isset($colorproduct))
            {
                if(!empty($colorproduct->main_image))
                {
                    $this->colorproductmainimage = $colorproduct->main_image;
                }

                if(!empty($colorproduct->more_images))
                {
                    $this->colorproductmoreimages = $colorproduct->more_images;
                }
            }

        }
        
    }

    public function render()
    {
        return view('livewire.product.productimages');
    }


    public function getcolorimages($color)
    {

        return redirect()->route('product.slug', ['slug' => $this->product->slug, 'color' => $color]);        
        
    }


}
