<?php

namespace App\Http\Livewire\Catalog;

use App\Size;
use App\Type;
use App\Brand;
use App\Color;
use App\Mount;
use App\Style;
use App\Gender;
use App\Voltage;
use App\Occasion;
use App\Modellist;
use App\InterfaceList;
use App\Models\Product;
use Livewire\Component;
use App\ProductCategory;
use App\ProductSubcategory;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

class Products extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $noproducts = false;
    public $search;

    // public $categorys;
    // public $subcategorys;
    public $selectedcategory;
    public $selectedsubcategory;
    public $brands;
    public $brand_name;
    public $sizes;
    public $colors;

    public $producttypes;
    public $genders;
    public $prices;
    public $styles = [];
    public $occasions;

    public $types;
    public $mounts;
    public $models;
    public $voltages;
    public $interfaces;

    public $displaytypes;
    public $displaycolors;

    public $minprice;
    public $maxprice;

    public $page = 1;
    public $sort;
    public $paginate = '';
    public $totalProductsCount = 0;
    protected $queryString = [
        // 'categorys' => ['except' => '', 'as' => 'category'],
        // 'subcategorys' => ['except' => '', 'as' => 'subcategory'],
        'brands' => ['except' => '', 'as' => 'brands'],
        // 'brand_name' => ['brand_name' => '', 'as' => 'brand_name'],
        'sizes' => ['except' => '', 'as' => 'size'],
        'colors' => ['except' => '', 'as' => 'color'],

        'producttypes' => ['except' => '', 'as' => 'producttype'],
        'genders' => ['except' => '', 'as' => 'gender'],
        // 'prices' => ['except' => '', 'as' => 'price'],
        'minprice' => ['except' => '', 'as' => 'minprice'],
        'maxprice' => ['except' => '', 'as' => 'maxprice'],
        'styles' => ['except' => '', 'as' => 'style'],
        'occasions' => ['except' => '', 'as' => 'occasion'],

        'types' => ['except' => '', 'as' => 'type'],
        'mounts' => ['except' => '', 'as' => 'mount'],
        'models' => ['except' => '', 'as' => 'model'],
        'voltages' => ['except' => '', 'as' => 'voltage'],
        'interfaces' => ['except' => '', 'as' => 'interface'],
        'displaytypes' => ['except' => '', 'as' => 'displaytype'],
        'displaycolors' => ['except' => '', 'as' => 'displaycolor'],


        'search' => ['except' => '', 'as' => 'search'],
        'sort' => ['except' => '', 'as' => 'sort'],
        // 'page' => ['except' => ''],
    ];

    public function mount()
    {
        if (Session::get('paginate')) {
            $this->paginate = Session::get('paginate');
        } else {
            $this->paginate = Config::get('icrm.frontend.catalog.pagination_count');
        }

        if (!empty(request('category'))) {
            $this->selectedcategory = request('category');
        }
        if (!empty(request('brand_name'))) {
            $this->brand_name = request('brand_name');
        }

        if (!empty(request('subcategory'))) {
            $this->selectedsubcategory = request('subcategory');
        }
    }

    // public function updatedCategorys()
    // {

    //     if (!is_array($this->categorys)) return;

    //     $this->categorys = array_filter($this->categorys, function ($category) {
    //         return $category != false;
    //     });

    //     $this->emit('render');

    // }

    // public function updatedSubcategorys()
    // {
    //     if (!is_array($this->subcategorys)) return;

    //     $this->subcategorys = array_filter($this->subcategorys, function ($subcategory) {
    //         return $subcategory != false;
    //     });
    // }

    public function listmode()
    {
        Session::put('gridview', 'listmode');
        return redirect(request()->header('Referer'));
    }

    public function boxmode()
    {
        Session::put('gridview', 'boxmode');
        return redirect(request()->header('Referer'));
    }

    public function updatingPaginate()
    {
        $this->resetPage();
    }

    public function updatedPaginate()
    {
        Session::put('paginate', $this->paginate);
        $this->paginate = $this->paginate;

        return redirect(request()->header('Referer'));
    }


    public function updatedProducttype()
    {
        if (!is_array($this->producttypes))
            return;

        $this->producttypes = array_filter($this->producttypes, function ($producttype) {
            return $producttype != false;
        });
    }

    public function updatedGenders()
    {
        if (!is_array($this->genders))
            return;

        $this->genders = array_filter($this->genders, function ($gender) {
            return $gender != false;
        });
    }

    public function updatedMinprice()
    {
    }

    public function updatedMaxprice()
    {
    }

    // public function updatedPrices()
    // {
    //     if (!is_array($this->prices)) return;

    //     $this->prices = array_filter($this->prices, function ($price) {
    //         return $price != false;
    //     });
    // }

    public function updatedSizes()
    {
        if (!is_array($this->sizes))
            return;

        $this->sizes = array_filter($this->sizes, function ($size) {
            return $size != false;
        });
    }

    public function updatedStyles()
    {
        if (!is_array($this->styles))
            return;

        $this->styles = array_filter($this->styles, function ($style) {
            return $style != false;
        });
    }



    public function updatedOccasions()
    {
        if (!is_array($this->occasions))
            return;

        $this->occasions = array_filter($this->occasions, function ($occasion) {
            return $occasion != false;
        });
    }

    public function updatedBrands()
    {
        if (!is_array($this->brands))
            return;

        $this->brands = array_filter($this->brands, function ($brand) {
            return $brand != false;
        });
    }

    public function updatedColors()
    {
        if (!is_array($this->colors))
            return;

        $this->colors = array_filter($this->colors, function ($color) {
            return $color != false;
        });
    }

    public function updatedTypes()
    {
        if (!is_array($this->types))
            return;

        $this->types = array_filter($this->types, function ($type) {
            return $type != false;
        });
    }

    public function updatedMounts()
    {
        if (!is_array($this->mounts))
            return;

        $this->mounts = array_filter($this->mounts, function ($mount) {
            return $mount != false;
        });
    }


    public function updatedModels()
    {
        if (!is_array($this->models))
            return;

        $this->models = array_filter($this->models, function ($model) {
            return $model != false;
        });
    }

    public function updatedVoltages()
    {
        if (!is_array($this->voltages))
            return;

        $this->voltages = array_filter($this->voltages, function ($voltage) {
            return $voltage != false;
        });
    }

    public function updatedInterfaces()
    {
        if (!is_array($this->interfaces))
            return;

        $this->interfaces = array_filter($this->interfaces, function ($interface) {
            return $interface != false;
        });
    }

    protected $listeners = [
        'load-more' => 'loadMore'
    ];
    public function loadMore()
    {
        if($this->totalProductsCount > $this->paginate + 12){
            $this->paginate = $this->paginate + 12;
        }
        else{
            $this->dispatchBrowserEvent('reachedMaxLimit');
        }
    }


    public function render()
    {
        $products = Product::where('admin_status', 'Accepted')
            // ->whereLike('name', $this->search ?? '')
            ->whereHas('vendor', function ($query) {
                $query->where('status', 1);
            })
            // ->where('product_tags', 'LIKE', '%' . $this->search . '%')
            ->when($this->search, function ($query) {
                $query->where('product_tags', 'LIKE', '%' . $this->search . '%');
            })
            // ->when($this->search, function ($query) {

            //     $query
            //         // ->where('product_tags', 'LIKE', '%' . $this->search . '%')
            //         ->where(function ($query) {

            //             $splitwords = explode(" ", $this->search);

            //             foreach ($splitwords as $splitword) {

            //                 if (Str::contains($splitword, ['men', 'women', 'kid']) == false) {
            //                     $query
            //                         ->orWhereHas('productcategory', function ($query) use ($splitword) {
            //                             $query
            //                                 ->where('name', 'LIKE', '%' . $splitword . '%')
            //                                 ->where('name', 'LIKE', '%' . substr($splitword, 0, -1) . '%');
            //                         })
            //                         ->orWhereHas('productsubcategory', function ($query) use ($splitword) {
            //                             $query
            //                                 ->where('name', 'LIKE', '%' . $splitword . '%')
            //                                 ->where('name', 'LIKE', '%' . substr($splitword, 0, -1) . '%');
            //                         });
            //                 }
            //             }
            //         })
            //         ->where(function ($query) {
            //             // $query->orWhere('sku', 'LIKE', '%' . $this->search . '%');
            //             // $query->orWhere('name', 'LIKE', '%' . $this->search . '%');
            //             // $query->orWhere('description', 'LIKE', '%' . $this->search . '%');
            //         });
            // })
            ->when($this->search, function ($query) {
                // if gender is mentioned in the search
                $splitwords = explode(" ", $this->search);

                foreach ($splitwords as $splitwordgender) {
                    if ($splitwordgender == 'men' or $splitwordgender == 'mens') {
                        $query->whereIn('gender_id', ['Men']);
                    }

                    if ($splitwordgender == 'women' or $splitwordgender == 'womens') {
                        $query->whereIn('gender_id', ['Women']);
                    }

                    if ($splitwordgender == 'kid' or $splitwordgender == 'kids') {
                        $query->whereIn('gender_id', ['Kids']);
                    }
                }
            })
            ->when($this->selectedcategory, function ($query) {
                $query->whereHas('productcategory', function ($q) {
                    $q->where('slug', $this->selectedcategory);
                });
            })
            ->when($this->selectedsubcategory, function ($query) {
                $query->whereHas('productsubcategory', function ($q) {
                    $q->where('slug', $this->selectedsubcategory);
                });
            })
            ->when($this->minprice > 0, function ($query) {
                $query->where('offer_price', '>=', $this->minprice);
            })
            ->when($this->maxprice > 0, function ($query) {
                $query->where('offer_price', '<=', $this->maxprice);
            })
            ->when($this->sizes, function ($query) {
                $query->whereHas('sizes', function ($q) {
                    $q->whereIn('id', array_values($this->sizes));
                });
            })
            ->when($this->colors, function ($query) {
                $query->whereHas('colors', function ($q) {
                    $q->whereIn('id', array_values($this->colors));
                });
            })
            ->when($this->types, function ($query) {
                $query->whereIn('type_id', array_values($this->types));
            })
            ->when($this->mounts, function ($query) {
                $query->whereIn('mount_id', array_values($this->mounts));
            })
            ->when($this->models, function ($query) {
                $query->whereIn('modellist_id', array_values($this->models));
            })
            ->when($this->voltages, function ($query) {
                $query->whereIn('voltage_id', array_values($this->voltages));
            })
            ->when($this->interfaces, function ($query) {
                $query->whereIn('interface_id', array_values($this->interfaces));
            })
            ->when($this->brands, function ($query) {
                $query->whereIn('brand_id', array_values($this->brands));
            })
            ->when($this->brand_name, function ($query) {
                $query->where('brand_id', ($this->brand_name));
            })
            ->when($this->genders, function ($query) {
                // need to check
                $query->whereIn('gender_id', array_values($this->genders));
            })
            ->when($this->styles, function ($query) {
                // need to check
                $query->whereIn('style_id', array_values($this->styles));
            })
            ->when($this->sort, function ($query) {
                if ($this->sort == 'asc') {
                    $query->orderBy('created_at', 'asc');
                } elseif ($this->sort == 'desc') {
                    $query->orderBy('created_at', 'desc');
                } elseif ($this->sort == 'plth') {
                    $query->orderBy('offer_price', 'ASC');
                } elseif ($this->sort == 'phtl') {
                    $query->orderBy('offer_price', 'DESC');
                }
            })
            ->when($this->producttypes, function ($query) {
                foreach ($this->producttypes as $producttype) {
                    if ($producttype == 'all') {
                        $query;
                    }

                    if ($producttype == 'excludeoutofstock') {
                        $query->whereHas('productskus', function ($q) {
                            $q->where('available_stock', '>', 0);
                        });
                    }

                    if ($producttype == 'customization') {
                        $query->where('customize_images', '!=', null);
                    }

                    if ($producttype == 'showcaseathome') {
                        // need to check
                        $query->whereHas('vendor', function ($q) {
                            $q->where('status', 1)->where('showcase_at_home', 1);
                        });
                    }
                }
            })
            ->when(\Request::route()->getName() == 'products.vendor', function ($query) {
                /**
                 * If the catalog route is products.vendor
                 * then fetch products for selected vendor
                 * Need to check
                 */
                // dd(request('slug'));
                $query->whereHas('vendor', function ($q) {
                    $q->where('status', 1);
                })->where('seller_id', request('slug'));
            })
            ->when(!empty(Session::get('showcasecity')), function ($query) {
                /**
                 * If showcase at home activated then fetch only products for showcasepincode city
                 * Map city name
                 * Need to check
                 */

                $query->whereHas('vendor', function ($q) {
                    $q->where('status', 1)->where('showcase_at_home', 1)->where('city', Session::get('showcasecity'));
                });
            })
            ->when(\Request::route()->getName() == 'products.showcase', function ($query) {
                /**
                 * If the catalog route is products.showcase
                 * then fetch only products whose vendor is offering showcase at home.
                 * Need to check
                 */
                $query->whereHas('vendor', function ($q) {
                    $q->where('status', 1)->where('showcase_at_home', 1);
                });
            })
            ->when(\Request::route()->getName() == 'products.showcase.vendor', function ($query) {
                /**
                 * If the catalog route is products.showcase.vendor
                 * then fetch only products of the selected vendor who is offering showcase at home.
                 * Need to check
                 */
                $query->whereHas('vendor', function ($q) {
                    $q->where('status', 1)->where('showcase_at_home', 1)->where('id', request('vendor_id'));
                });
            })
        ;


        $this->totalProductsCount = $products->count();
        $products = $products->paginate($this->paginate);

        $categories = ProductCategory::where('status', 1)->orderBy('id', 'ASC')->get();

        $this->dispatchBrowserEvent('makeInactive');
        $this->dispatchBrowserEvent('scrollByCustom',['x' => 0, 'y' => 10]);
        return view('livewire.catalog.products', [
            'categories' => $categories,
            // 'subcategories' => $subcategories,
            'genderss' => Gender::where('status', 1)->where('name', '!=', 'NA')->orderBy('id', 'ASC')->get(),
            'sizess' => Size::where('name', '!=', 'NA')->where('status', 1)->has('products')->orderBy('id', 'ASC')->get(),
            'colorss' => Color::where('name', '!=', 'NA')->where('status', 1)->has('products')->orderBy('id', 'ASC')->get(),
            'brandss' => Brand::where('status', 1)->whereHas('products')->orderBy('name', 'ASC')->get(),

            'styless' => Style::where('status', 1)->orderBy('id', 'ASC')->get(),
            'occasionss' => Occasion::where('status', 1)->orderBy('id', 'ASC')->get(),

            'typess' => Type::where('name', '!=', 'NA')->where('status', 1)->orderBy('id', 'ASC')->get(),
            'mountss' => Mount::where('name', '!=', 'NA')->where('status', 1)->orderBy('id', 'ASC')->get(),
            'modelss' => Modellist::where('name', '!=', 'NA')->where('status', 1)->orderBy('id', 'ASC')->get(),
            'voltagess' => Voltage::where('name', '!=', 'NA')->where('status', 1)->orderBy('id', 'ASC')->get(),
            'interfacess' => InterfaceList::where('name', '!=', 'NA')->where('status', 1)->orderBy('id', 'ASC')->get(),

            'products' => $products,
        ]);
    }

    public function deactivateshowcaseathome()
    {
        Session::remove('showcasepincode');
        Session::remove('showcasecity');

        Session::flash('success', 'Showcase At Home deactivated');
        return redirect()->route('products');
    }
}