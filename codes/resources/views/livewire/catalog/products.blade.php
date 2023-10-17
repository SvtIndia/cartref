<div class="page-content mb-10 pb-3">
    <div class="container">
        <div class="row main-content-wrap gutter-lg">
            <aside class="col-lg-3 sidebar sidebar-fixed sidebar-toggle-remain shop-sidebar sticky-sidebar-wrapper">
                <div class="sidebar-overlay"></div>
                <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
                <div class="sidebar-content">
                    <div class="pin-wrapper" style="height: 1810.97px;">
                        <div class="sticky-sidebar" data-sticky-options="{'top': 10}"
                             style="border-bottom: 0px none rgb(102, 102, 102); width: 272.5px;">
                            <div class="filter-actions mb-4">
                                <a href="#"
                                   class="sidebar-toggle-btn toggle-remain btn btn-outline btn-primary btn-icon-right btn-rounded">Filter<i
                                            class="d-icon-arrow-left"></i></a>
                                @if (count(request()->route()->parameters()) >
                                        0 or
                                        request('search'))
                                    <a href="{{ route('products') }}" class="filter-cleans"
                                       style="color: #ef5b2e;">Reset Filter</a>
                                @else
                                    <a href="{{ route('products') }}" class="filter-cleans" style="color: white;">.</a>
                                @endif

                            </div>


                            <div class="allfilters">

                                <div class="widget widget-collapsible" wire:ignore>
                                    <h3 class="widget-title">Types<span class="toggle-btn"></span></h3>
                                    <ul class="widget-body filter-items">
                                        <li>
                                            <input type="checkbox" wire:key="producttypes.all.{{ time() + 1 }}"
                                                   wire:model="producttypes.all" value="all">
                                            All
                                        </li>

                                        <li>
                                            <input type="checkbox"
                                                   wire:key="producttypes.excludeoutofstock.{{ time() + 1 }}"
                                                   wire:model="producttypes.excludeoutofstock"
                                                   value="excludeoutofstock">
                                            Exclude Out Of Stock
                                        </li>


                                        @if (Config::get('icrm.customize.feature') == 1)
                                            <li>
                                                <input type="checkbox"
                                                       wire:key="producttypes.customization.{{ time() + 2 }}"
                                                       wire:model="producttypes.customization" value="customization">
                                                Customizable
                                            </li>
                                        @endif

                                        @if (Config::get('icrm.showcase_at_home.feature') == 1)
                                            <li>
                                                <input type="checkbox"
                                                       wire:key="producttypes.showcaseathome.{{ time() + 3 }}"
                                                       wire:model="producttypes.showcaseathome" value="showcaseathome">
                                                Showroom At Home
                                            </li>
                                        @endif
                                    </ul>
                                </div>


                                @if (Config::get('icrm.filters.subcategory') == 1)
                                    {{-- Categories Filter --}}
                                    @isset($categories)
                                        @if (count($categories) > 0)
                                            <div class="widget widget-collapsible">
                                                <h3 class="widget-title">All Categories<span class="toggle-btn"></span>
                                                </h3>
                                                <ul class="widget-body filter-items search-ul">
                                                    @foreach ($categories as $category)
                                                        <li class="@if (count($category->subcategory) > 0) with-ul @endif">
                                                            <a href="{{ route('products.category', ['category' => $category->slug]) }}">{{ $category->name }}
                                                                <i class="fas fa-chevron-down"></i>
                                                            </a>
                                                            @if (count($category->subcategory) > 0)
                                                                <ul style="display: block">
                                                                    @foreach ($category->subcategory as $subcategory)
                                                                        <li>
                                                                            <a href="{{ route('products.subcategory', ['subcategory' => $subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endisset
                                @endif




                                @if (Config::get('icrm.filters.gender') == 1)
                                    {{-- typess filter --}}
                                    @if (isset($genderss))

                                        @if (count($genderss) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3 class="widget-title">Gender<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items">
                                                    @foreach ($genderss as $key => $gender)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="genders.{{ $gender->name . $key }}"
                                                                   wire:model="genders.{{ $gender->name }}"
                                                                   value="{{ $gender->name }}">
                                                            {{ $gender->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    @endif
                                @endif


                                @if (Config::get('icrm.filters.price') == 1)
                                    {{-- <div class="widget widget-collapsible">
                                <h3 class="widget-title">Price Filter<span class="toggle-btn"></span></h3>
                                <ul class="widget-body filter-items">
                                    @foreach (array_keys(Config::get('icrm.price_range')) as $key => $price)
                                    <li>
                                        <input type="checkbox"
                                        wire:key="prices.{{ $price.$key }}"
                                        wire:model="prices.{{ $price }}" value="{{ $price }}">{{ $price }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div> --}}
                                    <div class="widget widget-collapsible" wire:ignore>
                                        <h3 class="widget-title">Filter by Price<span class="toggle-btn"></span></h3>
                                        <div class="widget-body mt-3">
                                            <div class="priceranges">
                                                <input type="number" class="form-control" wire:model="minprice"
                                                       placeholder="Min Price">
                                                <input type="number" class="form-control" wire:model="maxprice"
                                                       placeholder="Max Price">
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                @if (Config::get('icrm.filters.size') == 1)
                                    {{-- size filter --}}
                                    @if (isset($sizess))
                                        @if (count($sizess) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3 class="widget-title">Size<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items">
                                                    @foreach ($sizess as $key => $size)
                                                        <li>
                                                            <input type="checkbox"
                                                                   {{-- wire:key="sizes.{{ $size->id }}" --}}
                                                                   wire:model="sizes.{{ $size->id . $key }}" wire:ignore
                                                                   value="{{ $size->id }}">
                                                            {{ $size->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @endif


                                @if (Config::get('icrm.filters.color') == 1)
                                    {{-- colorss filter --}}
                                    @if (isset($colorss))
                                        @if (count($colorss) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3
                                                        class="widget-title @if (!$this->colors) collapsed @endif">
                                                    Color<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items"
                                                    @if (!$this->colors) style="display: none"
                                                    @else style="display: block" @endif>
                                                    @foreach ($colorss as $key => $color)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="colors.{{ $color->id . $key }}"
                                                                   wire:model="colors.{{ $color->id }}"
                                                                   value="{{ $color->id }}">
                                                            {{ $color->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    @endif
                                @endif




                                @if (Config::get('icrm.filters.type') == 1)
                                    {{-- typess filter --}}
                                    @if (isset($typess))
                                        @if (count($typess) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3
                                                        class="widget-title @if (!$this->types) collapsed @endif">
                                                    Type<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items"
                                                    @if (!$this->types) style="display: none" @endif>
                                                    @foreach ($typess as $key => $type)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="types.{{ $type->name . $key }}"
                                                                   wire:model="types.{{ $type->name }}"
                                                                   value="{{ $type->name }}">
                                                            {{ $type->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @endif


                                @if (Config::get('icrm.filters.mount') == 1)
                                    {{-- typess filter --}}
                                    @if (isset($mountss))
                                        @if (count($mountss) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3
                                                        class="widget-title @if (!$this->mounts) collapsed @endif">
                                                    Mount<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items"
                                                    @if (!$this->mounts) style="display: none" @endif>
                                                    @foreach ($mountss as $key => $mount)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="mounts.{{ $mount->name . $key }}"
                                                                   wire:model="mounts.{{ $mount->name }}"
                                                                   value="{{ $mount->name }}">
                                                            {{ $mount->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @endif


                                @if (Config::get('icrm.filters.model') == 1)
                                    {{-- typess filter --}}
                                    @if (isset($modelss))
                                        @if (count($modelss) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3
                                                        class="widget-title @if (!$this->models) collapsed @endif">
                                                    Model<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items"
                                                    @if (!$this->models) style="display: none" @endif>
                                                    @foreach ($modelss as $key => $model)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="models.{{ $model->name . $key }}"
                                                                   wire:model="models.{{ $model->name }}"
                                                                   value="{{ $model->name }}">
                                                            {{ $model->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @endif


                                @if (Config::get('icrm.filters.voltage') == 1)
                                    {{-- typess filter --}}
                                    @if (isset($voltagess))
                                        @if (count($voltagess) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3
                                                        class="widget-title @if (!$this->voltages) collapsed @endif">
                                                    Voltage<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items"
                                                    @if (!$this->voltages) style="display: none" @endif>
                                                    @foreach ($voltagess as $key => $voltage)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="voltages.{{ $voltage->name . $key }}"
                                                                   wire:model="voltages.{{ $voltage->name }}"
                                                                   value="{{ $voltage->name }}">
                                                            {{ $voltage->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @endif


                                @if (Config::get('icrm.filters.interface') == 1)
                                    {{-- typess filter --}}
                                    @if (isset($interfacess))
                                        @if (count($interfacess) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3
                                                        class="widget-title @if (!$this->interfaces) collapsed @endif">
                                                    Interface<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items"
                                                    @if (!$this->interfaces) style="display: none" @endif>
                                                    @foreach ($interfacess as $key => $interface)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="interfaces.{{ $interface->name . $key }}"
                                                                   wire:model="interfaces.{{ $interface->name }}"
                                                                   value="{{ $interface->name }}">
                                                            {{ $interface->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @endif





                                @if (Config::get('icrm.filters.style') == 1)
                                    {{-- typess filter --}}
                                    @if (isset($styless))
                                        @if (count($styless) > 0)
                                            <div class="widget widget-collapsible" wire:ignore>
                                                <h3
                                                        class="widget-title @if (!$this->styles) collapsed @endif">
                                                    Style<span class="toggle-btn"></span></h3>
                                                <ul class="widget-body filter-items"
                                                    @if (!$this->styles) style="display: none" @endif>
                                                    @foreach ($styless as $key => $style)
                                                        <li>
                                                            <input type="checkbox"
                                                                   wire:key="styles.{{ $style->name . $key }}"
                                                                   wire:model="styles.{{ $style->name }}"
                                                                   value="{{ $style->name }}">
                                                            {{ $style->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                @endif


                                {{-- brands filter --}}
                                @if (isset($brandss))
                                    @if (count($brandss) > 0)
                                        <div class="widget widget-collapsible" wire:ignore>
                                            <h3
                                                    class="widget-title @if (!$this->brands) collapsed @endif">
                                                Brand<span class="toggle-btn"></span></h3>
                                            <ul class="widget-body filter-items"
                                                @if (!$this->brands) style="display: none" @endif>
                                                @foreach ($brandss as $key => $brand)
                                                    <li>
                                                        <input type="checkbox"
                                                               wire:key="brands.{{ $brand->name . $key }}"
                                                               wire:model="brands.{{ $brand->name }}"
                                                               value="{{ $brand->name }}">
                                                        {{ $brand->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </div>


                        </div>
                    </div>
                </div>
            </aside>
            <div class="col-lg-9 main-content">
                <nav class="toolbox sticky-toolbox sticky-content fix-top" id="catalogtopfilter">
                    <div class="toolbox-left">
                        <a href="#"
                           class="toolbox-item left-sidebar-toggle btn btn-outline btn-primary btn-rounded btn-icon-right d-lg-none">
                            Filter<i class="d-icon-arrow-right"></i></a>

                        <div class="toolbox-item toolbox-sort select-box text-dark">
                            <label>Sort By :</label>
                            <select wire:model="sort" class="form-control">
                                <option value="">Random</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                                <option value="plth">Price low to high</option>
                                <option value="phtl">Price high to low</option>
                            </select>

                        </div>

                        @if (\Request::route()->getName() == 'products.vendor')
                            @php
                                $vendor = \App\Models\User::where('id', request('slug'))->first();
                            @endphp
                            @if (!empty($vendor))
                                <div class="toolbox-item toolbox-sort select-box text-dark">
                                    <label class="discount">Showing products from {{ $vendor->brand_name }}</label>
                                </div>
                            @endif

                        @endif


                        {{-- @if (!empty(Session::get('showcasecity')))
                            <div class="toolbox-item toolbox-sort select-boxs text-light">
                                <a wire:click="deactivateshowcaseathome" class="btn btn-rounded btn-ellipse btn-secondary btn-block" style="padding: 10px;" title="Showcase At Home Activated for delivery pincode {{ Session::get('showcasepincode') }}">
                                    Deactivate Showroom At Home
                                </a>
                            </div>
                        @endif --}}


                        {{-- <div class="col-5">
                            <a href="#" class="btn btn-primary btn-sm btn-shadow-sm btn-ellipse btn-block"><span>Showcase At Home Activated</span></a>
                        </div>
                        <div class="col-3">
                            <a href="#" class="btn btn-primary btn-sm btn-shadow-sm btn-ellipse btn-block"><span>Buying from ICRM</span></a>
                        </div> --}}
                    </div>
                    <div class="toolbox-right">
                        <div class="toolbox-item toolbox-show select-box text-dark">
                            <label>Show :</label>
                            <select wire:model="paginate" class="form-control">
                                <option value="12">12</option>
                                <option value="24">24</option>
                                <option value="36">36</option>
                            </select>
                        </div>
                        <div class="toolbox-item toolbox-layout">
                            <a wire:click="listmode"
                               class="d-icon-mode-list btn-layout @if (Session::get('gridview') == 'listmode') active @endif"></a>
                            <a wire:click="boxmode"
                               class="d-icon-mode-grid btn-layout @if (Session::get('gridview') != 'listmode') active @endif"></a>
                        </div>
                    </div>
                </nav>

                @section('bottomscripts')
                    <script>
                        var elementPosition = $('#catalogtopfilter').offset();

                        $(window).scroll(function () {
                            if ($(window).scrollTop() > elementPosition.top) {
                                $('#catalogtopfilter').addClass('scrolled');
                                $('#catalogtopfilter').removeClass('notscrolled');
                            } else {
                                $('#catalogtopfilter').addClass('notscrolled');
                                $('#catalogtopfilter').removeClass('scrolled');
                            }
                        });
                    </script>
                @endsection

                {{-- <div class="select-items" style="display: block;">
                    @if (request('price'))
                        @foreach (request('price') as $price)
                            <a wire:model.defer="brands.{{ $brand->name }}" class="select-item" style="">{{ $price }}
                                <i class="d-icon-times"></i>
                            </a>
                        @endforeach
                    @endif
                    <a href="{{ route('products') }}" class="filter-clean text-primary">Clean all</a>
                </div> --}}

                @if (Config::get('icrm.showcase_at_home.feature') == 1)
                    @if ($products->onFirstPage())
                        <div class="row">
                            <div class="showcase jumbotron">
                                <h1>Showroom At Home <a href="{{ route('showcase.introduction') }}"><span
                                                class="fas fa-info-circle" title="What is showroom at home?"></span></a>
                                </h1>
                                <p>Order <span>upto {{ Config::get('icrm.showcase_at_home.order_limit') }} products
                                        from any one vendor</span> and get the delivery done <span>within
                                        {{ Config::get('icrm.showcase_at_home.delivery_tat') }} working
                                        {{ Config::get('icrm.showcase_at_home.delivery_tat_name') }}</span> at your
                                    doorstep for just {{ Config::get('icrm.currency.icon') }}
                                    {{ Config::get('icrm.showcase_at_home.delivery_charges') }}/- service charges.</p>
                                <p>Service charges will be discounted if you purchase any product on delivery.</p>
                                <br>
                                <p class="lead">
                                @if (Session::get('showcasecity') != null)
                                    @if (Session::get('showcasevendorid') != null)
                                        <p><span>Showing showroom at home products from
                                                    <span>{{ Session::get('showcasevendor') }}</span> for
                                                    {{ Session::get('showcasecity') }} city
                                                    {{ Session::get('showcasepincode') }} area.</span></p>
                                    @else
                                        <p><span>Showing showroom at home products for
                                                    {{ Session::get('showcasecity') }} city
                                                    {{ Session::get('showcasepincode') }} area.</span></p>
                                    @endif

                                    <form action="{{ route('showcase.deactivate') }}" method="post"
                                          class="input-wrappers input-wrapper-rounds input-wrapper-inlines ml-lg-auto">
                                        @csrf
                                        <input type="hidden" class="form-control font-secondary form-solid"
                                               name="showcasepincode" id="showcasepincode"
                                               placeholder="Delivery pincode..." required="">
                                        <button class="btn btn-link" type="submit">Deactivate</button>
                                    </form>
                                @else
                                    <a href="{{ route('showcase.getstarted') }}"
                                       class="btn btn-primary btn-sm">Activate</a>
                                    @endif
                                    </p>
                            </div>
                        </div>
                    @endif
                @endif

                @if (Session::get('gridview') == 'listmode')
                    {{-- List mode --}}
                    <div class="product-lists product-wrapper">
                        @if (count($products) > 0)
                            @foreach ($products as $product)
                                <div class="product product-list">
                                    <figure class="product-media">
                                        <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">
                                            @php
                                                $firstcolorimage = App\Productcolor::where('status', 1)
                                                    ->where('product_id', $product->id)
                                                    ->first();

                                                if (isset($firstcolorimage)) {
                                                    if (!empty($firstcolorimage->main_image)) {
                                                        $firstcolorimage = $firstcolorimage->main_image;
                                                        // $firstcolorimage = $product->image;
                                                    } else {
                                                        $firstcolorimage = $product->image;
                                                    }
                                                } else {
                                                    $firstcolorimage = $product->image;
                                                }
                                            @endphp
                                            <img src="{{ Voyager::image($firstcolorimage) }}"
                                                 alt="{{ $product->name }}">
                                        </a>
                                        @include('product.badges')
                                    </figure>
                                    <div class="product-details">
                                        <div class="product-cat">
                                            <a
                                                    href="{{ route('products.subcategory', ['subcategory' => $product->productsubcategory->slug]) }}">{{ $product->productsubcategory->name }}</a>
                                        </div>
                                        <h3 class="product-name">
                                            <a
                                                    href="{{ route('product.slug', ['slug' => $product->slug]) }}">{{ $product->getTranslatedAttribute('name', App::getLocale(), 'en') }}</a>
                                        </h3>
                                        <div class="product-price">
                                            <ins
                                                    class="new-price">{{ Config::get('icrm.currency.icon') }}{{ $product->offer_price }}</ins>
                                            <del
                                                    class="old-price">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }}</del>
                                            @if (Config::get('icrm.site_package.multi_vendor_store'))
                                                <span class="product-name"> by
                                                    {{ $product->vendor->brand_name }}</span>
                                            @endif
                                        </div>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings"
                                                      style="width:
                                            @if ($product->productreviews) {{ ($product->productreviews()->where('status', 1)->sum('rate') /($product->productreviews()->where('status', 1)->count() *5)) *100 }}%
                                            @else
                                            0% @endif"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="{{ route('product.slug', ['slug' => $product->slug]) }}"
                                               class="link-to-tab rating-reviews">
                                                (@if ($product->productreviews())
                                                    {{ $product->productreviews()->where('status', 1)->count() }}
                                                @else
                                                    0
                                                @endif reviews)
                                            </a>
                                        </div>
                                        <p class="product-short-desc">
                                            {{ $product->description }}
                                        </p>
                                        <div class="product-action">
                                            {{-- <a href="#" class="btn-product btn-cart" data-toggle="modal" data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i><span>Add to cart</span></a> --}}
                                            {{-- <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a> --}}
                                            @livewire(
                                            'wishlist',
                                            [
                                            'wishlistproductid' => $product->id,
                                            'view' => 'product-card',
                                            ],
                                            key($product->id)
                                            )
                                            {{-- <a href="#" class="btn-product-icon btn-quickview" title="Quick View"><i class="d-icon-search"></i></a> --}}
                                            {{-- @livewire('quickview', [
                                                    'product' => $product
                                                ], key($product->id.time())) --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-20 mb-4 bg-light rounded-3 text-center">
                                <div class="container-fluid py-5">
                                    <img src="{{ asset('images/icrm/wishlist/empty_wishlist.svg') }}"
                                         class="img-responsive" alt="wishlist empty">
                                    <h1 class="display-5 fw-bold text-dark">
                                        We dont have any product avaialable for selected filters
                                        @if (!empty(Session::get('showcasecity')))
                                            at {{ Session::get('showcasecity') }}
                                            {{ Session::get('showcasepincode') }} area.
                                        @endif
                                    </h1>
                                    <p class="fs-4 text-center">Reset filter and browse amazing products listed on our
                                        website</p>
                                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg"
                                       type="button">Reset Filter</a>
                                    @if (!empty(Session::get('showcasecity')))
                                        <a href="{{ route('products') }}" class="btn btn-danger btn-lg"
                                           style="background: red; color: whitesmoke;" type="button">Deactivate
                                            Showroom At Home</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    {{-- Box Mode --}}

                    @if (count($products) > 0)
                        <div class="row cols-2 cols-sm-4 justify-content-center product-wrapper box-mode">
{{--                            @foreach ($products as $key => $product)--}}
{{--                                <div class="product-wrap">--}}
{{--                                        <div class="product">--}}
{{--                                            <figure class="product-media">--}}
{{--                                                <a href="{{ route('product.slug', ['slug' => $product->slug]) }}">--}}

{{--                                                    <img src="{{ Voyager::image($firstcolorimage) }}"--}}
{{--                                                        alt="{{ $product->name }}">--}}
{{--                                                </a>--}}
{{--                                                @include('product.badges')--}}
{{--                                                <div class="product-action-vertical">--}}
{{--                                                     <a href="#" class="btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>--}}
{{--                                                     <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a>--}}
{{--                                                    @livewire(--}}
{{--                                                        'wishlist',--}}
{{--                                                        [--}}
{{--                                                            'wishlistproductid' => $product->id,--}}
{{--                                                            'view' => 'product-card',--}}
{{--                                                        ],--}}
{{--                                                        key($product->id . time())--}}
{{--                                                    )--}}
{{--                                                </div>--}}
{{--                                                <div class="product-action">--}}
{{--                                                     <a href="#" class="btn-product btn-quickview" title="Quick View">Quick--}}
{{--                                                        View</a>--}}
{{--                                                    @livewire(--}}
{{--                                                        'quickview',--}}
{{--                                                        [--}}
{{--                                                            'product' => $product,--}}
{{--                                                        ],--}}
{{--                                                        key($product->id . time())--}}
{{--                                                    )--}}
{{--                                                </div>--}}
{{--                                            </figure>--}}
{{--                                            <div class="product-details">--}}
{{--                                                <div class="product-cat">--}}
{{--                                                    <a--}}
{{--                                                        href="{{ route('products.subcategory', ['subcategory' => $product->productsubcategory->slug]) }}">{{ $product->productsubcategory->name }}</a>--}}
{{--                                                </div>--}}
{{--                                                <h3 class="product-name">--}}
{{--                                                    <a--}}
{{--                                                        href="{{ route('product.slug', ['slug' => $product->slug]) }}">{{ Str::limit($product->getTranslatedAttribute('name', App::getLocale(), 'en'), 45) }}</a>--}}
{{--                                                </h3>--}}
{{--                                                <div class="product-price">--}}
{{--                                                    <ins--}}
{{--                                                        class="new-price">{{ Config::get('icrm.currency.icon') }}{{ $product->offer_price }}/-</ins><del--}}
{{--                                                        class="old-price">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }}--}}
{{--                                                    </del>--}}
{{--                                                    @if (Config::get('icrm.site_package.multi_vendor_store'))--}}
{{--                                                        <span class="product-name"> by--}}
{{--                                                            {{ $product->vendor->brand_name }}</span>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                                <div class="ratings-container">--}}
{{--                                                    <div class="ratings-full">--}}
{{--                                                        <span class="ratings"--}}
{{--                                                            style="width:--}}
{{--                                                        @if ($product->productreviews) {{ ($product->productreviews()->where('status', 1)->sum('rate') /($product->productreviews()->where('status', 1)->count() *5)) *100 }}%--}}
{{--                                                        @else--}}
{{--                                                        0% @endif"></span>--}}
{{--                                                        <span class="tooltiptext tooltip-top"></span>--}}
{{--                                                    </div>--}}
{{--                                                    <a href="{{ route('product.slug', ['slug' => $product->slug]) }}"--}}
{{--                                                        class="link-to-tab rating-reviews">( @if ($product->productreviews())--}}
{{--                                                            {{ $product->productreviews()->count() }}--}}
{{--                                                        @else--}}
{{--                                                            0--}}
{{--                                                        @endif reviews )</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                            @endforeach--}}

                            @foreach ($products as $key => $product)
                                @php
                                    $firstcolorimage = App\Productcolor::where('status', 1)
                                        ->where('product_id', $product->id)
                                        ->first();

                                    if (isset($firstcolorimage)) {
                                        if (!empty($firstcolorimage->main_image)) {
                                            $firstcolorimage = $firstcolorimage->main_image;
                                            // $firstcolorimage = $product->image;
                                        } else {
                                            $firstcolorimage = $product->image;
                                        }
                                    } else {
                                        $firstcolorimage = $product->image;
                                    }
                                @endphp
                                <div class="new-product-wrap">
                                    <div class="new-product">
                                        <div class="image">
                                            <img class="product-image" src="{{ Voyager::image($firstcolorimage) }}" alt="{{ $product->name }}"/>

                                            @if($product->productreviews && $product->productreviews()->count())
                                            <div class="product-rating-horizontal">
                                                <div class="star">
                                                    @if ($product->productreviews)
                                                        {{ ($product->productreviews()->where('status', 1)->sum('rate') /($product->productreviews()->where('status', 1)->count() *5)) * 5 }}
                                                    @else
                                                        0
                                                    @endif &nbsp;
                                                    <img src="{{ asset('/images/icons/star.svg') }}" alt="star">
                                                </div>
                                                <span class="dash">|</span>
                                                <div class="book">
                                                    {{ $product->productreviews()->count()  }} &nbsp;
                                                    <img src="{{ asset('/images/icons/book.svg') }}" alt="book">
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="content">
                                            <div class="brand-name">{{ $product->brand_id }}</div>
                                            <div class="product-name">{{ Str::limit($product->getTranslatedAttribute('name', App::getLocale(), 'en'), 45) }}</div>
                                            <div class="product-price">
                                                <span class="mrp">{{ Config::get('icrm.currency.icon') }}{{ $product->offer_price }}/- </span>
                                                <span class="sp">{{ Config::get('icrm.currency.icon') }}{{ $product->mrp }} <br/></span>
                                            </div>
                                            @if($product->mrp > $product->offer_price)
                                                @php
                                                    $discount = $product->mrp - $product->offer_price;
                                                    $discountPercent = ($discount / $product->mrp) * 100;
                                                @endphp
                                                <div class="off">({{ round($discountPercent)  }}% off)</div>
                                            @endif
                                        </div>

                                        <div class="product-action-vertical-new">
{{--                                            <a href="#" class="wishlist">--}}
{{--                                                <img src="{{ asset('/images/icons/wishlist.svg') }}" alt="wishlist">--}}
{{--                                            </a>--}}
{{--                                            <a class="cart">--}}
{{--                                                <img src="{{ asset('/images/icons/cart.svg') }}" alt="cart">--}}
{{--                                            </a>--}}
                                            <div>
                                                @livewire(
                                                    'quickview',
                                                    [
                                                    'product' => $product,
                                                    'view' => 'product-card',
                                                    ],
                                                    key($product->id . time())
                                                )
                                            </div>

                                            <div>
                                                @livewire(
                                                    'wishlist',
                                                    [
                                                    'wishlistproductid' => $product->id,
                                                    'view' => 'new-product-card',
                                                    ],
                                                    key($product->id . time())
                                                )
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row cols-1 product-wrapper">
                            <div class="p-20 mb-4 bg-light rounded-3 text-center">
                                <div class="container-fluid py-5">
                                    <img src="{{ asset('images/icrm/wishlist/empty_wishlist.svg') }}"
                                         class="img-responsive" alt="wishlist empty">
                                    <h1 class="display-5 fw-bold text-dark">
                                        We dont have any product avaialable for selected filters
                                        @if (!empty(Session::get('showcasecity')))
                                            at {{ Session::get('showcasecity') }}
                                            {{ Session::get('showcasepincode') }} area.
                                        @endif
                                    </h1>
                                    <p class="fs-4 text-center">Reset filter and browse amazing products listed on our
                                        website</p>
                                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg"
                                       type="button">Reset Filter</a>
                                    @if (Session::get('showcasecity') != null)
                                        <br><br>
                                        <form action="{{ route('showcase.deactivate') }}" method="post">
                                            @csrf
                                            <input type="hidden" class="form-control font-secondary form-solid"
                                                   name="showcasepincode" id="showcasepincode"
                                                   value="{{ Session::get('showcasepincode') }}"
                                                   placeholder="Delivery pincode..." required="">
                                            <button class="btn btn-secondary btn-lg" type="submit"
                                                    style="background: red; color: whitesmoke;">Deactivate Showroom At
                                                Home
                                            </button>
                                        </form>
                                        {{-- <a href="{{ route('products') }}" class="btn btn-danger btn-lg" style="background: red; color: whitesmoke;" type="button">Deactivate Showroom At Home</a> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                @endif

                <nav class="toolbox toolbox-pagination flot-right">
                    <div style="margin: auto;font-size: 28px;">
                        <i class="d-icon-refresh" id="loader"></i>
                    </div>
                    {{-- {{ $products->links() }} --}}
                    {{-- <p class="show-info">Showing <span>12 of 56</span> Products</p>
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                <i class="d-icon-arrow-left"></i>Prev
                            </a>
                        </li>
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item page-item-dots"><a class="page-link" href="#">6</a></li>
                        <li class="page-item">
                            <a class="page-link page-link-next" href="#" aria-label="Next">
                                Next<i class="d-icon-arrow-right"></i>
                            </a>
                        </li>
                    </ul> --}}
                    @push('scripts')
                        <script>
                            Livewire.restart();
                        </script>
                    @endpush
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- @push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endpush --}}
