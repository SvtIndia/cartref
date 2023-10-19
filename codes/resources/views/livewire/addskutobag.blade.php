<div>
    
    <div class="product-price">

        <ins class="new-price">{{ Config::get('icrm.currency.icon') }} {{ number_format($offer_price, 0) }}/-</ins>
        <del class="old-price">{{ Config::get('icrm.currency.icon') }} {{ number_format($mrp, 0) }}</del>
    </div>


    <div class="ratings-container">
        <div class="ratings-full">
            <span class="ratings" style="width:
            @if($product->productreviews)
            {{ $product->productreviews()->sum('rate') / ($product->productreviews()->count() * 5) * 100 }}%
            @else
            0%
            @endif"></span>
            <span class="tooltiptext tooltip-top"></span>
        </div>
        <a href="#product-tab-reviews" class="link-to-tab rating-reviews">
            ( @if($product->productreviews()) {{ $product->productreviews()->count() }} @else 0 @endif reviews )
        </a>
    </div>
    <p class="product-short-desc">
        {{ $product->getTranslatedAttribute('description', App::getLocale(), 'en') }}
    </p>

    @isset($product->productcolors)
        
        @if (count($product->productcolors->where('color', '!=', 'NA')) > 0)
            <div class="product-form product-color">
                <label>Color: <span class="outofstock">*</span></label>
                <div class="product-variations">
                    @foreach ($product->productcolors->where('color', '!=', 'NA') as $key => $color)
                        @if (empty($color->main_image))
                            {{-- Fetch default image --}}
                            <a class="color @if($this->color == $color->color) active @endif" 
                                data-src="{{ Voyager::image($product->image) }}" 
                                style="background-color: @if(!empty($color->colors->rgb)) {{ $color->colors->rgb }} @else {{ $color->colors->name }} @endif"
                                wire:key="selectcolor.{{ $color->color.$key }}"
                                wire:click="selectcolor('{{ $color->color }}')" 
                                value="{{ $color->color }}"
                                title="{{ $color->color }}"
                                >
                            </a>
                        @else
                            {{-- Fetch color image --}}
                            <a class="color @if($this->color == $color->color) active @endif" 
                                data-src="{{ Voyager::image($color->main_image) }}" 
                                style="background-color: @if(!empty($color->colors->rgb)) {{ $color->colors->rgb }} @else {{ $color->colors->name }} @endif"
                                wire:key="selectcolor.{{ $color->color.$key }}"
                                wire:click="selectcolor('{{ $color->color }}')" 
                                value="{{ $color->color }}"
                                title="{{ $color->color }}"
                                >
                            </a>
                        @endif
                    @endforeach

                </div>
            </div>
        @endif

    @endisset


    @if (Config::get('icrm.product_sku.color') == 1)
        @if (!empty($this->color))
            {{-- After selecting color --}}
            @php
                $productsizesforcolor = App\Productsku::where('product_id', $product->id)->where('color', $this->color)->where('status', 1)->get();
            @endphp
            @isset($productsizesforcolor)
                    
                @if (count($productsizesforcolor) > 0)
                    <div class="product-form product-size">
                        <label>Size: <span class="outofstock">*</span></label>
                        <div class="product-form-group">
                            <div class="product-size-variations">
                                @foreach ($productsizesforcolor as $key => $size)
                                    <a class="newsize @if($this->size == $size->size) active @endif @if ($size->available_stock <= 0) outofstock @endif" 
                                        {{-- data-src="{{ Voyager::image($size->main_image) }}"  --}}
                                        style="width: auto !important;"
                                        wire:key="selectsize.{{ $size->size.$key }}"
                                        wire:click="selectsize('{{ $size->size }}')" 
                                        value="{{ $size->size }}"

                                        @if ($size->available_stock <= 0) 
                                            disabled="disabled"
                                            title="{{ Config::get('icrm.frontend.outofstock.name') }}"
                                        @endif
                                        
                                        >
                                        {{ $size->size }}

                                        {{-- @if ($size->available_stock <= 0)
                                            <br><span class="outofstock">{{ Config::get('icrm.frontend.outofstock.name') }}</span>
                                        @endif --}}
                                    </a>
                                    
                                @endforeach
                            </div>

                            @if (!empty($product->size_guide))
                            <a href="#product-tab-size-guide" class="size-guide link-to-tab ml-4"><i class="d-icon-th-list"></i>Size
                                Guide</a>
                            @endif
                            {{-- <a href="#" class="product-variation-clean" style="display: none;">Clean All</a> --}}
                        </div>
                    </div>
                @endif
                <br>                
            @endisset
        @else
            {{-- Disabled - First select color --}}
            @php
                $productsizesforcolor = DB::table('productsku')
                 ->select('size')
                 ->where('product_id', $product->id)
                 ->where('status', 1)
                 ->groupBy('size')->get();

            @endphp
            @isset($productsizesforcolor)
                    
                @if (count($productsizesforcolor) > 0)
                    <div class="product-form product-size">
                        <label>Size: <span class="outofstock">*</span></label>
                        <div class="product-form-group">
                            <div class="product-size-variations">
                                @foreach ($productsizesforcolor as $key => $size)
                                <a class="newsize @if($this->size == $size->size) active @endif" 
                                    {{-- data-src="{{ Voyager::image($size->main_image) }}"  --}}
                                        style="width: auto !important;"

                                        wire:attr="disabled"
                                        
                                        >
                                        {{ $size->size }}

                                    </a>
                                    
                                @endforeach
                            </div>

                            @if (!empty($product->size_guide))
                                <a href="#product-tab-size-guide" class="size-guide link-to-tab ml-4"><i class="d-icon-th-list"></i>Size
                                    Guide</a>
                            @endif
                        </div>
                    </div>
                @endif
                <br>                
            @endisset
        @endif
    @else

        @isset($product->productskus)
            
        @if (count($product->productskus->where('size', '!=', 'NA')) > 0)
            <div class="product-form product-size">
                <label>Size: <span class="outofstock">*</span></label>
                <div class="product-form-group">
                    <div class="product-size-variations">
                        @php
                            if(Config::get('icrm.product_sku.color') == 1)
                            {
                                $productskus = $product->productskus;
                            }else{
                                $productskus = $product->productskus;
                            }
                        @endphp
                        @foreach ($productskus as $key => $size)
                            <a class="newsize @if($this->size == $size->size) active @endif @if ($size->available_stock <= 0) outofstock @endif" 
                                data-src="{{ Voyager::image($size->main_image) }}" 
                                style="width: auto !important;"
                                wire:key="selectsize.{{ $size->size.$key }}"
                                wire:click="selectsize('{{ $size->size }}')" 
                                value="{{ $size->size }}"

                                @if ($size->available_stock <= 0) 
                                    {{-- disabled="disabled" --}}
                                    title="{{ Config::get('icrm.frontend.outofstock.name') }}"
                                @endif
                                
                                >
                                {{ $size->size }}

                                {{-- @if ($size->available_stock <= 0)
                                    <br><span class="outofstock">Out of stock</span>
                                @endif --}}
                            </a>
                            
                        @endforeach
                    </div>

                    @if (!empty($product->size_guide))
                    <a href="#product-tab-size-guide" class="size-guide link-to-tab ml-4"><i class="d-icon-th-list"></i>Size
                        Guide</a>
                    @endif
                    {{-- <a href="#" class="product-variation-clean" style="display: none;">Clean All</a> --}}
                </div>
            </div>
        @endif
        <br>

    @endisset
    @endif


    
            
    @if ($product->productsubcategory->name == 'COP')
        <div class="product-form">
            <label>G+: <span class="outofstock">*</span></label>
            <div class="select-box product-variations">
                <select wire:model="max_g_need" class="form-control" @if(!empty($this->max_g_need)) style="box-shadow: inset 0 0 0 2px blue;" @endif>
                    <option value="">Select G+</option>
                    @foreach ([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15] as $item)
                        @if ($item <= $product->max_g)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="product-form" style="margin-top: -0.8em;">
            <label for=""></label>
            <small>Additional cost for each G+ is {{ Config::get('icrm.currency.icon') }} {{ $product->cost_per_g }}</small>
        </div>
    @endif

    @if (!empty(json_decode($product->requirement_document)))
        <div class="product-form">
            <label>Custom Requirements: <span class="outofstock">*</span></label>
            <div class="product-variations" @if(!empty($this->requireddocument)) style="box-shadow: inset 0 0 0 2px blue;" @endif>
                
                @if (!empty($product->requirement_document))
                    @foreach (json_decode($product->requirement_document) as $key => $document)
                    <br><small class="outofstock"><a href="{{ asset('storage/'.$document->download_link) }}" style="color: blue;">Click here</a> to download document format and reupload here with your custom requirements</small>
                    @endforeach
                @endif
                
                <input type="file" wire:model="requireddocument" class="required" required>
                                
                <br><div wire:loading wire:target="requireddocument">Uploading...</div>
                <br>@error('requireddocument') <span class="error">{{ $message }}</span> @enderror
            </div>
            
        </div>
    @endif

    

    {{-- <div class="product-variation-price">
        <span>{{ $this->size.'-'.$this->color.'-'.$this->max_g_need }}</span>
    </div> --}}

    <hr class="product-divider">
    @if ($this->disablebtn == true)
        <span class="outofstock">FIRST SELECT REQUIRED FIELDS:</span>
    @else
    <label for="">You're buying:         
    </label>
        @if (!empty($this->color) AND $this->color != 'NA')
            <span>Color: {{ $this->color }}</span>,
        @endif
        
        @if (!empty($this->size) AND $this->size != 'NA')
            <span>Size: {{ $this->size }}</span>, 
        @endif
        
        @if (!empty($this->max_g_need))
            <span>G+: {{ $this->max_g_need }}</span>,
        @endif

        @if (!empty($this->requireddocument))
            <span>Custom Requirement: Attached</span>    
        @endif
    @endif
    <br><br>

    <div class="product-form product-qty">
        <div class="product-form-group">
            <div class="input-group mr-2">
                <button class="quantity-minus d-icon-minus" wire:click="minusqty"></button>
                <input class="quantity form-control" type="number" min="1" max="1000000" wire:model="qty" readonly>
                <button class="quantity-plus d-icon-plus" wire:click="plusqty" @if($this->availablestock == 0) disabled="disabled" @endif></button>
            </div>            
      

            <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold"  
                @if ($this->disablebtn == true)
                    disabled="disabled" title="First select required fields!"
                @endif

                wire:click="addtobag"
            >
                <i class="d-icon-bag"></i>
                Add to {{ ucwords(Config::get('icrm.cart.name')) }}
            </button>
            
            @if (Config::get('icrm.customize.feature') == 1)
                @if (!empty($this->product->customize_images))
                    <button class="btn-product btn-cart btn-warning text-normal ls-normal font-weight-semi-bold"
                        @if ($this->disablebtn == true)
                            disabled="disabled" title="First select required fields!"
                        @endif

                        wire:click="addtocustomize"
                    >
                        <i class="d-icon-abacus"></i>
                        Customize
                    </button>
                    <a href="{{ route('customize.introduction') }}"><span class="fas fa-info-circle" title="What is customization?"></span></a>
                @endif
            @endif

            {{-- @php
                dd($this->product->vendor());
            @endphp --}}
            
            @if (Config::get('icrm.showcase_at_home.feature') == 1)
                @if (empty(Session::get('showcasecity')))
                    {{-- activate showcase --}}
                    @if ($this->product->vendor->showcase_at_home == 1)
                        <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold" 
                            @if ($this->disablebtn == true)
                                disabled="disabled" title="First select required fields!"
                            @endif
                            

                            wire:click="addtoshowcaseathome"
                        >
                            <i class="d-icon-home"></i>
                            Showroom At Homes
                        </button>
                        <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle" title="What is showroom at home?"></span></a>
                    @endif
                @else
                    {{-- @php
                        dd($this->product->vendor->where('city' == Session::get('showcasecity')->where('showcase_at_home', 1)));
                    @endphp --}}

                    {{-- check if the showcase at home is available for selected city --}}
                    @if ($this->product->vendor->showcase_at_home == 1)
                        @if ($this->product->vendor->city == Session::get('showcasecity'))
                            <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold" 
                                @if ($this->disablebtn == true)
                                    disabled="disabled" title="First select required fields!"
                                @endif

                                wire:click="addtoshowcaseathome"
                            >
                                <i class="d-icon-home"></i>
                                Shoroom At Home
                            </button>
                            <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle" title="What is showroom at home?"></span></a>
                        @else
                            <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold" 
                                disabled="disabled" title="Showroom at home not available for this product at {{ Session::get('showcasecity') }} area."
                            >
                                <i class="d-icon-home"></i>
                                Shoroom At Home
                            </button>
                            <a href="{{ route('showcase.introduction') }}"><span class="fas fa-info-circle" title="What is showroom at home?"></span></a>
                        @endif
                    @endif
                @endif
                
            @endif

                {{-- disabled="disabled" --}}
        </div>
    </div>

    @if (Session::has('qtynotavailable'))

        <span class="outofstock">{{ Session::get('qtynotavailable') }}</span>

    @endif

</div>