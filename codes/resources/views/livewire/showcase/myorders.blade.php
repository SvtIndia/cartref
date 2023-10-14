<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                <li><a href="{{ route('showcase.introduction') }}">Showroom At Home</a></li>
                <li>My Orders</li>
            </ul>
        </div>
    </nav>
    <div class="page-content pt-10 pb-10 mb-2">
        <div class="container">

            @if (count($myorders) == 0)
                <div class="p-20 mb-4 bg-light rounded-3 text-center">
                    <div class="container-fluid py-5">
                        <img src="{{ asset('images/icrm/wishlist/empty_wishlist.svg') }}" class="img-responsive" alt="wishlist empty">
                        <h1 class="display-5 fw-bold text-dark">Your showroom at home is empty</h1>
                        <p class="fs-4 text-center">Looks like you have not placed any showroom at home order</p>
                        <p class="fs-4 text-center">Browse products and add to your favourite ones in showroom bag</p>
                        <a href="{{ route('products.showcase') }}" class="btn btn-primary btn-lg" type="button">Browse Products</a>
                        <a href="{{ route('showcase.bag') }}" class="btn btn-secondary btn-lg" type="button">Showroom Bag</a>
                    </div>
                </div>
            @else

                <table class="shop-table wishlist-table mt-2 mb-4">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Date</th>
                            <th class="product-name"><span>Product</span></th>
                            <th></th>
                            <th class="product-price">Order ID</th>
                            <th class="product-price">Weight</th>
                            <th class="product-price"><span>Price</span></th>
                            <th class="product-price"><span>Status</span></th>

                            <th class="product-add-to-cart"></th>
                        </tr>
                    </thead>
                    <tbody class="wishlist-items-wrapper">
                        @php
                            $prev = 0;
                            $count = 0;
                            $is_show = false;
                        @endphp
                        @foreach ($myorders as $key => $order)
                            @php
                                if($prev !== $order->order_id){
                                    $count++;
                                    $is_show = true;
                                    $prev = $order->order_id;
                                }
                            @endphp
                            <tr @if($count !== 1 && $is_show) style="border-top: 4px solid black;"@endif>
                                <td style="width: 4em;">
                                    {{ $is_show ? $count : '' }}
                                        <?php $is_show = false; ?>
                                </td>
                                <td style="max-width: 9em;">
                                    <span>{{ $order->created_at->format('M d, Y \a\t H:i') }}</span>
                                </td>
                                <td class="product-thumbnail">
                                    @php

                                        if (Config::get('icrm.multi_color_products.feature') == 1) {
                                            $productcolorimage = App\Productcolor::where('product_id', $order->product_id)->where('color', $order->color)->first();
                                        }


                                        if(isset($productcolorimage))
                                        {

                                            if(!empty($productcolorimage->main_image))
                                            {
                                                $productimage = $productcolorimage->main_image;
                                            }else{
                                                $productimage = $order->product->image;
                                            }

                                        }else{
                                            $productimage = $order->product->image;
                                        }



                                    @endphp
                                    <a href="{{ route('product.slug', ['slug' => $order->product->slug, 'color' => $order->color]) }}">
                                        <figure>
                                            <img src="{{ Voyager::image($productimage) }}" alt="{{ $order->product->name.'-'.$order->color.'-'.$order->size }}">
                                        </figure>
                                    </a>
                                </td>
                                <td class="product-name">
                                    <strong><a href="{{ route('product.slug', ['slug' => $order->product->slug, 'color' => $order->color]) }}">{{ $order->product->name }}</a></strong>
                                    <br><span>Vendor: <a href="{{ route('products.vendor', ['slug' => $order->vendor_id]) }}" style="color: blue;">{{ $order->product->vendor->name }}</a></span>
                                    <br><span>Brand: {{ $order->product->brand_id }}</span>
                                    <br><span>Color: {{ $order->color }}</span>
                                    <br><span>Size: {{ $order->size }}</span>

                                    <br><span>Order type: {{ $order->type }}</span>

                                    <br><span>Hsn: {{ $order->product->productsubcategory->hsn }}</span>
                                </td>
                                <td class="product-price">
                                    <span class="amount" style="color: blue;">
                                        <a href="{{ route('showcase.ordercomplete', ['id' => $order->order_id]) }}">
                                            {{ $order->order_id }}
                                        </a>
                                    </span>
                                </td>
                                <td class="product-price">
                                    <span class="amount">{{ $order->product->weight }}kg</span>
                                </td>

                                <td class="product-price">
                                    <span class="amount">{{ Config::get('icrm.currency.icon') }}{{ $order->product_offerprice }}</span>
                                </td>

                                <td class="product-price">
                                    <span class="amount">{{ $order->order_status }}</span>
                                </td>

                                <td class="product-add-to-cart">
                                    <a href="{{ route('showcase.ordercomplete', ['id' => $order->order_id]) }}" class="btn btn-sm btn-light" title="View complete order info"><span>View Complete Order</span></a>
                                    {{-- <br>
                                    <a href="{{ route('ordercomplete', ['id' => $order->id]) }}" class="btn btn-sm btn-light mt-2"><span>Exchange</span></a>
                                    <br>
                                    <a href="{{ route('ordercomplete', ['id' => $order->id]) }}" class="btn btn-sm btn-light mt-2"><span>Return</span></a> --}}
                                </td>
                            </tr>
                            @endforeach

                    </tbody>
                </table>
            @endif


        </div>
    </div>

</main>
