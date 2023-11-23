<style>
    .product-information {
        display: grid;
        grid-template-columns: 0.15fr 1fr;
        grid-gap: 5px;
    }

    .product-information .info {
        display: grid;
        grid-template-columns: 1fr;
        grid-gap: 0px;
    }

    .product-information .info .name {
        color: blue;
    }
</style>
@php
    $objs = $content->data ?? [];
//    if(isset($content->unserialize)){
//        if(is_array($content->unserialize)){
//            $objs = $content->unserialize;
//        }else{
//            $objs = json_decode($content->unserialize, true) ?? [];
//        }
//    }
//    foreach ($objs as $key => $obj) {
//        if(isset($obj) && isset($obj['attributes'])&& isset($obj['attributes']['product_id'])){
//            $objs[$key]['product'] = App\Models\Product::find($obj['attributes']['product_id']) ?? [];
//        }
//        else{
//            unset($objs[$key]);
//        }
//    }
@endphp

@if (count($objs) > 0)
    <div class="product-information">
        @foreach ($objs as $key => $value)
            @if (!empty($value['attributes']['color']))
                <a href="{{ route('product.slug', ['slug' => $value['product']['slug'], 'color' => $value['attributes']['color']]) }}"
                   class="name" target="_blank">
                    @else
                        <a href="{{ route('product.slug', ['slug' => $value['product']['slug']]) }}" class="name"
                           target="_blank">
                            @endif
                            @if (!empty($value['attributes']['color']))
                                @php
                                    $colorimage = App\Productcolor::where('color', $value['attributes']['color'])
                                        ->where('product_id', $value['attributes']['product_id'])
                                        ->first();
                                @endphp

                                @if (!empty($colorimage))
                                    @if (!empty($colorimage->main_image))
                                        <img style="width: 4rem; height:4rem;"
                                             src="{{ Voyager::image($colorimage->main_image) }}"
                                             alt="{{ $value['product']['name'] }}">
                                    @else
                                        <img style="width: 4rem; height:4rem;"
                                             src="{{ Voyager::image($value['product']['image']) }}"
                                             alt="{{ $value['product']['name'] }}">
                                    @endif
                                @else
                                    <img style="width: 4rem; height:4rem;"
                                         src="{{ Voyager::image($value['product']['image']) }}"
                                         alt="{{ $value['product']['name'] }}">
                                @endif
                            @else
                                <img style="width: 4rem; height:4rem;"
                                     src="{{ Voyager::image($value['product']['image']) }}"
                                     alt="{{ $value['product']['name'] }}">
                            @endif

                        </a>
                        <div class="info" style="color:black;">
                            @if (!empty($value['attributes']['color']))
                                <a href="{{ route('product.slug', ['slug' => $value['product']['slug'], 'color' => $value['attributes']['color']]) }}"
                                   class="name" target="_blank">
                                    @else
                                        <a href="{{ route('product.slug', ['slug' => $value['product']['slug']]) }}"
                                           class="name"
                                           target="_blank">
                                            @endif
                                            {{ Str::limit($value['product']['name'], 30) }}
                                        </a>
                                        <div>
                                            {{-- <div>
                                                    SKU: {{ $data->product_sku }}
                                                </div> --}}

                                            @if (!empty($value['attributes']['size']))
                                                <div>
                                                    Size: {{ $value['attributes']['size'] }}
                                                </div>
                                            @endif

                                            @if (!empty($value['attributes']['color']))
                                                <div>
                                                    Color: {{ $value['attributes']['color'] }}
                                                </div>
                                            @endif


                                            @if (!empty($value['attributes']['g_plus']))
                                                <div>
                                                    G+: {{ $value['attributes']['g_plus'] }}
                                                </div>
                                            @endif

                                            @if (!empty($value['attributes']['requirement_document']))
                                                <div>
                                                    Requirements: <a
                                                            href="{{ $value['attributes']['requirement_document'] }}"
                                                            style="color: blue;">Download</a>
                                                </div>
                                            @endif

                                            @if (!empty($value['attributes']['customized_image']))
                                                <div>
                                                    Customized Image:
                                                    <a href="{{ $value['attributes']['customized_image'] }}"
                                                       style="color: blue;">Download</a>
                                                </div>
                                            @endif

                                            @if (!empty($value['attributes']['original_file']))
                                                <div>
                                                    Original File:
                                                    @php
                                                        $originalfiles = collect(json_decode($value['attributes']['original_file']));
                                                    @endphp
                                                    @foreach ($originalfiles as $key => $originalfile)
                                                        <a href="{{ $originalfile }}" target="_blank"
                                                           style="color: blue;">Attachment
                                                            {{ $key + 1 }} @if ($loop->last)
                                                            @else
                                                                ,
                                                            @endif
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div>
                                                Brand: {{ $value['product']['brand_id'] }}
                                            </div>
                                            <div>
                                                Qty: {{ $value['quantity'] }}
                                            </div>
                                        </div>
                        </div>
                @endforeach
    </div>
@else
    <p>Cart is Empty!</p>
@endif


