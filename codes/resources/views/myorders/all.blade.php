@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.myorders.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.myorders.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.myorders.description') }}">
@endsection

@section('content')
<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                <li>My orders</li>
            </ul>
        </div>
    </nav>
    <div class="page-content pt-10 pb-10 mb-2">
        <div class="container">
            
            @if (count($myorders) == 0)
                <div class="p-20 mb-4 bg-light rounded-3 text-center">
                    <div class="container-fluid py-5">
                        <img src="{{ asset('images/icrm/wishlist/empty_wishlist.svg') }}" class="img-responsive" alt="wishlist empty">
                        <h1 class="display-5 fw-bold text-dark">Your my orders is empty</h1>
                        <p class="fs-4 text-center">Browse products and buy your favourite ones</p>
                        <a href="{{ route('products') }}" class="btn btn-primary btn-lg" type="button">Browse Products</a>
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
                                        $productimage = App\Productcolor::where('product_id', $order->product_id)->where('color', $order->color)->first();

                                        if(empty($productimage->main_image))
                                        {
                                            $productimage = $order->product->image;
                                        }else{
                                            $productimage = $productimage->main_image;
                                        }
                                    @endphp
                                    <a href="{{ route('ordercomplete.orderproduct', ['id' => $order->order_id, 'slug' => $order->product->slug, 'color' => $order->color]) }}">
                                        <figure>
                                            <img src="{{ Voyager::image($productimage) }}" alt="{{ $order->product->name.'-'.$order->color.'-'.$order->size }}">
                                        </figure>
                                    </a>
                                </td>
                                <td class="product-name">
                                    <strong><a href="{{ route('ordercomplete.orderproduct', ['id' => $order->order_id, 'slug' => $order->product->slug, 'color' => $order->color]) }}">{{ ucwords($order->product->name) }}</a></strong>
                                    <br><span>Quantity: {{ $order->qty }}</span>
                                    
                                    @if (!empty($order->color) AND $order->color != 'NA')
                                        <br><span>Color: {{ $order->color }}</span>    
                                    @endif
                                    
                                    @if (!empty($order->size) AND $order->size != 'NA')
                                    <br><span>Size: {{ $order->size }}</span>    
                                    @endif
                                    
                                    
                                    @if (!empty($order->g_plus))
                                        <br><span>G+: {{ $order->g_plus }}</span>    
                                    @endif

                                    @if (!empty($order->cost_per_g))
                                        <br><span>Cost per G+: {{ Config::get('icrm.currency.icon') }}{{ $order->cost_per_g }}/-</span>    
                                    @endif
                                    
                                    
                                    <br><span>Order type: {{ $order->type }}</span>

                                    @if (!empty($order->requirement_document))
                                        <br><span>Custom Requirement: <a href="{{ asset($order->requirement_document) }}" style="color: blue">Download</a></span>
                                    @endif

                                    @if (!empty($order->customized_image))
                                        <br><span>Customized image: <a href="{{ asset($order->customized_image) }}" target="_blank" style="color: blue">Download</a></span>
                                    @endif
                                    
                                    @if (!empty($order->original_file))
                                        <br><span>Original file: 
                                            @foreach (collect(json_decode($order->original_file)) as $key => $item)
                                                <a href="{{ $item }}" target="_blank" style="color: blue">Attachment {{ $key+1 }} @if($loop->last) @else , @endif</a>
                                            @endforeach
                                        </span>
                                    @endif
                                    
                                    <br><span>Hsn: {{ $order->product->productsubcategory->hsn }}</span>
                                </td>
                                <td class="product-price">
                                    <span class="amount" style="color: blue;">
                                        <a href="{{ route('ordercomplete', ['id' => $order->order_id]) }}">
                                            {{ $order->order_id }}
                                        </a>
                                    </span>
                                </td>
                                <td class="product-price">
                                    <span class="amount">{{ $order->product->weight }}</span>
                                </td>

                                <td class="product-price">
                                    <span class="amount">{{ Config::get('icrm.currency.icon') }}{{ $order->product_offerprice }}</span>
                                </td>

                                <td class="product-price">
                                    <span class="amount">{{ $order->order_status }}</span>
                                </td>
                                
                                <td class="product-add-to-cart">
                                    <a href="{{ route('ordercomplete', ['id' => $order->order_id]) }}" class="btn btn-sm btn-light" title="View complete order info"><span>View Complete Order</span></a>
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
@endsection