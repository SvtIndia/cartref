<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Quickviewmodal extends Component
{
    protected $listeners = ['displaytrue' => 'displaytrue', 'showcolorimage' => 'showcolorimage'];

    public $display = false;
    public $qproduct;
    public $qproductimage;
    public $productid;

    public function mount()
    {
        
        
        
        
    }


    public function hydrate()
    {
        $this->productid = Session::get('quickviewid');
        $this->qproduct = Product::where('id', $this->productid)->where('admin_status', 'Accepted')->first();
        
        
        if(!empty($this->qproduct))
        {
            // get first color image
            if(Config::get('icrm.multi_color_products.select_first_color_by_default') == 1)
            {
                if($this->qproduct->productcolors->count() > 0)
                {
                    if(!empty($this->qproduct->productcolors->first()->main_image))
                    {
                        $this->qproductimage = $this->qproduct->productcolors->first()->main_image;
                    }else{
                        $this->qproductimage = $this->qproduct->image;
                    }
                    
                }else{
                    $this->qproductimage = $this->qproduct->image;    
                }
            }else{
                $this->qproductimage = $this->qproduct->image;
            }
        }
    }

    public function render()
    {        


        if(!empty($this->qproduct))
        {
            // social share links
            $shareComponent = \Share::page(
                route('product.slug', ['slug' => $this->qproduct->slug]),
                $this->qproduct->description,
            )
            ->facebook()
            ->linkedin()
            ->whatsapp();
        }else{
            $shareComponent = [];
        }

        return view('livewire.quickviewmodal')->with([
            // 'qproduct' => $qproduct,
            // 'qproductimage' => $qproductimage,
            'shareComponent' => $shareComponent
        ]);

    }

    public function displaytrue()
    {
        
        $this->display = true;
    }

    public function displayfalse()
    {
        $this->display = false;
        Session::remove('quickviewid');
    }

    public function showcolorimage($color)
    {
        if(!empty($this->qproduct))
        {
            // get first color image
            if(Config::get('icrm.multi_color_products.select_first_color_by_default') == 1)
            {
                if(!empty($this->qproduct->productcolors->where('color', $color)->first()))
                {
                    if(!empty($this->qproduct->productcolors->where('color', $color)->first()->main_image))
                    {
                        $this->qproductimage = $this->qproduct->productcolors->where('color', $color)->first()->main_image;
                    }else{
                        $this->qproductimage = $this->qproduct->image;
                    }
                    
                }else{
                    $this->qproductimage = $this->qproduct->image;    
                }
            }else{
                $this->qproductimage = $this->qproduct->image;
            }
        }
            

    }
}
