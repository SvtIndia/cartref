@foreach ($items as $menu_item)

    {{-- check if the category is dynamic then show dynamic fields --}}
    @if (Config::get('icrm.frontend.menu.dynamic_category') == 1)

        {{-- Dynamic Category --}}
        @if ($menu_item->title == 'Category')
            {{-- Fetch dynamic category options --}}
            @php

                $categories = App\ProductCategory::where('status', 1)
                    ->whereHas('products')
                    ->with('subcategory')
                    ->orderBy('order_id', 'ASC')
                    ->get();

            @endphp

            @isset($categories)
                @if (count($categories) > 0)
                    @if (Config::get('icrm.frontend.header.genderwise') == 1)
                        @php
                            $genders = App\Gender::where('status', 1)
                                ->where('name', '!=', 'NA')
                                ->whereHas('products')
                                ->get();

                        @endphp

                        @if (count($genders) > 0)
                            @foreach ($genders as $gender)
                                @php
                                    $genderwisecategories = App\ProductCategory::where('status', 1)
                                        ->whereHas('products', function ($q) use ($gender) {
                                            $q->where('gender_id', $gender->name);
                                        })
                                        ->with(['subcategory'])
                                        ->orderBy('order_id', 'ASC')
                                        ->get();
                                @endphp

                                @if (count($genderwisecategories) > 0)
                                    <li
                                        class="submenu @if (
                                            $menu_item->link() ==
                                                Route::getFacadeRoot()->current()->uri()) active @endif
                                    ">
                                        <a href="{{ route('category.dynamic', $gender->name) }}">{{ $gender->name }}</a>

                                        <ul>

                                            @foreach ($genderwisecategories as $category)
                                                <li>
                                                    <a
                                                        href="{{ route('products.category', ['category' => $category->slug, 'gender[' . $gender->name . ']' => $gender->name]) }}">{{ $category->name }}</a>
                                                    @if (count($category->subcategory) > 0)
                                                        @php
                                                            $subcatgories = App\ProductSubcategory::where('status', 1)
                                                                ->whereIn('name', $category->subcategory->pluck('name'))
                                                                ->whereHas('products', function ($q) use ($gender) {
                                                                    $q->where('gender_id', $gender->name);
                                                                })
                                                                ->get();
                                                        @endphp

                                                        @if (count($subcatgories) > 0)
                                                            <ul>
                                                                @foreach ($subcatgories as $subcategory)
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('products.subcategory', ['subcategory' => $subcategory->slug, 'gender[' . $gender->name . ']' => $gender->name]) }}">{{ $subcategory->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @elseif(Config::get('icrm.frontend.header.categoryonrow') == 1)
                        @foreach ($categories as $category)
                            <li class="submenu @if (
                                $menu_item->link() ==
                                    Route::getFacadeRoot()->current()->uri()) active @endif">
                                <a
                                    href="{{ route('products.category', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                @if (count($category->subcategory) > 0)
                                    <ul>
                                        @foreach ($category->subcategory as $subcategory)
                                            <li>
                                                <a
                                                    href="{{ route('products.subcategory', ['subcategory' => $subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @else
                        <li
                            class="submenu @if (
                                $menu_item->link() ==
                                    Route::getFacadeRoot()->current()->uri()) active @endif
                                ">
                            <a>Category</a>

                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <a
                                            href="{{ route('products.category', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                        @if (count($category->subcategory) > 0)
                                            <ul>
                                                @foreach ($category->subcategory as $subcategory)
                                                    <li>
                                                        <a
                                                            href="{{ route('products.subcategory', ['subcategory' => $subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endisset
        @else
            {{-- Fetch other nav options --}}
            @if ($menu_item->title == 'Learn More' && checkMobile())
            @else
                <li
                    class="
                    @if (count($menu_item->children) > 0) submenu @endif

                    @if (
                        $menu_item->link() ==
                            Route::getFacadeRoot()->current()->uri()) active @endif
                    ">

                    @if (count($menu_item->children) > 0)
                        <a href="{{ route('category.dynamic', $menu_item->title) }}">{{ $menu_item->title }}</a>
                    @else
                        <a href="{{ $menu_item->link() }}">
                            @if($menu_item->title == "Products" && Session::get('showcasecity'))
                                Stores
                            @else
                                {{ $menu_item->title }}
                            @endif
                        </a>
                    @endif

                    @if (count($menu_item->children) > 0)
                        <ul>
                            @foreach ($menu_item->children as $children)
                                <li>
                                    <a href="{{ $children->link() }}">
{{--                                        {{ $children->title }}--}}
                                        @if($children->title == "Products" && Session::get('showcasecity'))
                                            Stores
                                        @else
                                            {{ $children->title }}
                                        @endif
                                    </a>

                                    @if (count($children->children) > 0)
                                        <ul>
                                            @foreach ($children->children as $children)
                                                <li>
                                                    <a href="{{ $children->link() }}">{{ $children->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endif
    @else
        {{-- Not Dynamic Category --}}
        <li
            class="
                @if (count($menu_item->children) > 0) submenu @endif

                @if (
                    $menu_item->link() ==
                        Route::getFacadeRoot()->current()->uri()) active @endif
                ">

            @if (count($menu_item->children) > 0)
                <a>{{ $menu_item->title }}</a>
            @else
                <a href="{{ $menu_item->link() }}">{{ $menu_item->title }}</a>
            @endif

            @if (count($menu_item->children) > 0)
                <ul>
                    @foreach ($menu_item->children as $children)
                        <li>
                            <a href="{{ $children->link() }}">{{ $children->title }}</a>

                            @if (count($children->children) > 0)
                                <ul>
                                    @foreach ($children->children as $children)
                                        <li>
                                            <a href="{{ $children->link() }}">{{ $children->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>

    @endif

@endforeach
