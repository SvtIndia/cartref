<style>
    .product-information {
        display: block;
    }
</style>
@php

    $objs = json_decode($content);

@endphp

@if (count($objs) > 0)
    <div class="product-information">
        @foreach ($objs as $key => $data)
            <div>
                OrderNum :-
                <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?order_id={{ $data->order_id }}">
                    {{ $data->order_id }}
                </a>
                <div class="product-information" style="margin-bottom: 5px">
                    @if (!empty($data->color))
                        <a href="{{ route('product.slug', ['slug' => $data->product->slug, 'color' => $data->color]) }}"
                            class="name" target="_blank">
                        @else
                            <a href="{{ route('product.slug', ['slug' => $data->product->slug]) }}"
                                class="name" target="_blank">
                    @endif
                    @if (!empty($data->color))
                        @php
                            $colorimage = App\Productcolor::where('color', $data->color)
                                ->where('product_id', $data->product_id)
                                ->first();
                        @endphp

                        @if (!empty($colorimage))
                            @if (!empty($colorimage->main_image))
                                <img style="width: 2rem; height:2rem;"
                                    src="{{ Voyager::image($colorimage->main_image) }}"
                                    alt="{{ $data->product->name }}">
                            @else
                                <img style="width: 2rem; height:2rem;"
                                    src="{{ Voyager::image($data->product->image) }}"
                                    alt="{{ $data->product->name }}">
                            @endif
                        @else
                            <img style="width: 2rem; height:2rem;"
                                src="{{ Voyager::image($data->product->image) }}"
                                alt="{{ $data->product->name }}">
                        @endif
                    @else
                        <img style="width: 2rem; height:2rem;"
                            src="{{ Voyager::image($data->product->image) }}"
                            alt="{{ $data->product->name }}">
                    @endif

                    </a>
                    <div class="info">
                        @if (!empty($data->color))
                            <a href="{{ route('product.slug', ['slug' => $data->product->slug, 'color' => $data->color]) }}"
                                class="name" target="_blank">
                            @else
                                <a href="{{ route('product.slug', ['slug' => $data->product->slug]) }}"
                                    class="name" target="_blank">
                        @endif
                        {{ Str::limit($data->product->name, 30) }}
                        </a>
                        {{-- <div>
                            <div>
                                SKU: {{ $data->product_sku }}
                            </div>

                            @if (!empty($data->size))
                                <div>
                                    Size: {{ $data->size }}
                                </div>
                            @endif

                            @if (!empty($data->color))
                                <div>
                                    Color: {{ $data->color }}
                                </div>
                            @endif


                            @if (!empty($data->g_plus))
                                <div>
                                    G+: {{ $data->g_plus }}
                                </div>
                            @endif

                            @if (!empty($data->requirement_document))
                                <div>
                                    Requirements: <a
                                        href="{{ $data->requirement_document }}"
                                        style="color: blue;">Download</a>
                                </div>
                            @endif

                            @if (!empty($data->customized_image))
                                <div>
                                    Customized Image:
                                    <a href="{{ $data->customized_image }}"
                                        style="color: blue;">Download</a>
                                </div>
                            @endif

                            @if (!empty($data->original_file))
                                <div>
                                    Original File:
                                    @php
                                        $originalfiles = collect(json_decode($data->original_file));
                                    @endphp
                                    @foreach ($originalfiles as $key => $originalfile)
                                        <a href="{{ $originalfile }}" target="_blank"
                                            style="color: blue;">Attachment
                                            {{ $key + 1 }} @if ($loop->last)
                                            @else,
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <div>
                                Brand: {{ $data->product->brand_id }}
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No Orders Found</p>
@endif
