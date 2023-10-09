@php
    function isMobile()
    {
        return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));
    }

    function isTab()
    {
        return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'tablet'));
    }
@endphp

@if (isset($dynamiccollections))

    @if (count($dynamiccollections) > 0)

        @foreach ($dynamiccollections as $dynamiccollection)
            <style>
                .dynamic-hero{{ $dynamiccollection->id }} {
                    position: relative;
                    background-size: cover;
                    background-blend-mode: multiply;
                }

                .dynamic-hero{{ $dynamiccollection->id }}::after {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    opacity: 0;

                }
            </style>
            @if (!empty($dynamiccollection->background_color))
                <style>
                    .dynamic-hero{{ $dynamiccollection->id }}::before {
                        background: {{ $dynamiccollection->background_color }};
                    }
                </style>
            @endif
            @if (!empty($dynamiccollection->background_image))
                <style>
                    .dynamic-hero{{ $dynamiccollection->id }}::before {
                        background-image: url({{ config('app.url') . '/storage/' . str_replace('\\', '/', $dynamiccollection->background_image) }});
                    }
                </style>
            @endif
            @if ($dynamiccollection->background_opacity > 0)
                <style>
                    .dynamic-hero{{ $dynamiccollection->id }}::before {
                        opacity: {{ $dynamiccollection->background_opacity / 10 }};
                    }
                </style>
            @endif

            <section id="dynamiccollections{{ $dynamiccollection->id }}">
                <div class="containers pt-10 pb-6 pr-4 pl-4  dynamic-hero{{ $dynamiccollection->id }}">

                    <h2 class="title title-center mb-4">
                        {{ $dynamiccollection->group_name }}
                    </h2>


                    {{-- <div class="banner-desc-container">
                        <p>{{ setting('3-column-collection.description') }}</p>
                    </div> --}}

                    @php
                        // $take = floor($dynamiccollection->collections->count() / $dynamiccollection->desktop_columns) * $dynamiccollection->desktop_columns;
                        $collections = $dynamiccollection->collections()->get();
                    @endphp

                    <style>
                        @media (min-width: 901px) {
                            .dynamiccollections{{ $dynamiccollection->id }} {
                                display: grid;
                                grid-template-columns: repeat({{ $dynamiccollection->desktop_columns }}, 1fr);
                                /* grid-template-columns: repeat(8, 1fr); */
                                grid-gap: {{ $dynamiccollection->desktop_gap }}em;
                                z-index: 1;
                                position:relative;
                            }

                            #dynamiccollections{{ $dynamiccollection->id }} h2.title {
                                font-size: 2.3em;
                                font-family: 'Poppins', sans-serif;
                                margin-bottom: 1em !important;
                                font-weight: 500;
                            }

                        }

                        @media (max-width: 900px) {
                            .dynamiccollections{{ $dynamiccollection->id }} {
                                display: grid;
                                grid-template-columns: repeat({{ $dynamiccollection->tablet_columns }}, 1fr);
                                grid-gap: {{ $dynamiccollection->tablet_gap }}em;
                                z-index: 1;
                                position:relative;
                            }

                            #dynamiccollections{{ $dynamiccollection->id }} h2.title {
                                font-size: 2.3em;
                                font-family: 'Poppins', sans-serif;
                                margin-bottom: 1em !important;
                                font-weight: 500;
                            }


                        }

                        @media (max-width: 600px) {
                            .dynamiccollections{{ $dynamiccollection->id }} {
                                display: grid;
                                grid-template-columns: repeat({{ $dynamiccollection->mobile_columns }}, 1fr);
                                grid-gap: {{ $dynamiccollection->mobile_gap }}em;
                                z-index: 1;
                                position:relative;
                            }

                            #dynamiccollections{{ $dynamiccollection->id }} h2.title {
                                font-size: 1.5em;
                                font-family: 'Poppins', sans-serif;
                                margin-bottom: 1em !important;
                                font-weight: 600;
                            }
                        }
                    </style>



                    {{-- Visiblity --}}
                    @if ($dynamiccollection->desktop_visiblity == 0)
                        <style>
                            @media (min-width: 901px) {
                                #dynamiccollections{{ $dynamiccollection->id }} {
                                    display: none;
                                }
                            }
                        </style>
                    @endif


                    @if ($dynamiccollection->tablet_visiblity == 0)
                        <style>
                            @media (min-width: 601px) AND (max-width: 900px) {
                                #dynamiccollections{{ $dynamiccollection->id }} {
                                    display: none;
                                }
                            }
                        </style>
                    @endif

                    @if ($dynamiccollection->mobile_visiblity == 0)
                        <style>
                            @media (max-width: 600px) {
                                #dynamiccollections{{ $dynamiccollection->id }} {
                                    display: none;
                                }
                            }
                        </style>
                    @endif


                    {{-- Caousel --}}

                    @if ($dynamiccollection->desktop_carousel == 1 && !isMobile())
                        <style>
                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.carousel {
                                /* display: block !important; */
                            }

                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.nocarousel {
                                display: none !important;
                            }
                        </style>
                    @elseif($dynamiccollection->tablet_carousel == 1 && isTab())
                        <style>
                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.carousel {
                                /* display: block !important; */
                            }

                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.nocarousel {
                                display: none !important;
                            }
                        </style>
                    @elseif($dynamiccollection->mobile_carousel == 1 && isMobile())
                        <style>
                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.carousel {
                                /* display: block !important; */
                            }

                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.nocarousel {
                                display: none !important;
                            }
                        </style>
                    @else
                        <style>
                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.carousel {
                                display: none !important;
                            }

                            #dynamiccollections{{ $dynamiccollection->id }} .dynamiccollections{{ $dynamiccollection->id }}.nocarousel {
                                /* display: block !important; */
                            }
                        </style>
                    @endif




                    <div class="dynamiccollections{{ $dynamiccollection->id }} owl-carousel owl-theme owl-nav-bg owl-nav-arrow carousel" data-owl-options="{
                        'items': {{ $dynamiccollection->desktop_columns }},
                        'autoplay': 10,
                        'slideSpeed': 300,
                        'loop': true,
                        'nav': true,
                        'dots': true,
                        'autoplayTimeout': 3000,
                        'animateIn': 'fadeIn',
                        'animateOut': 'fadeOut'
                        }">
                        @foreach ($collections as $collection)
                            <div class="dynamiccollection">
                                <a href="{{ $collection->url }}">
                                    <div class="image">
                                        <figure>
                                            @if (isMobile() && Storage::disk('public')->exists($collection->mb_image))
                                                <img src="{{ Voyager::image($collection->mb_image) }}"
                                                    alt="{{ $dynamiccollection->group_name }}"
                                                    style="background-color: #ccc;">
                                            @else
                                                <img src="{{ Voyager::image($collection->image) }}"
                                                    alt="{{ $dynamiccollection->group_name }}"
                                                    style="background-color: #ccc;">
                                            @endif
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="dynamiccollections{{ $dynamiccollection->id }} nocarousel" style="z-index: 1; position:relative;">
                        @foreach ($collections as $collection)
                            <div class="dynamiccollection">
                                <a href="{{ $collection->url }}">
                                    <div class="image">
                                        <figure>
                                            @if (isMobile() && Storage::disk('public')->exists($collection->mb_image))
                                                <img src="{{ Voyager::image($collection->mb_image) }}"
                                                    alt="{{ $dynamiccollection->group_name }}"
                                                    style="background-color: #ccc;">
                                            @else
                                                <img src="{{ Voyager::image($collection->image) }}"
                                                    alt="{{ $dynamiccollection->group_name }}"
                                                    style="background-color: #ccc;">
                                            @endif
                                        </figure>
                                    </div>
                                </a>
                            </div>
                            {{-- {{ public_path('storage'.'/'.$collection->mb_image) }}
                            Is file exists = {{  Storage::disk('public')->exists($collection->mb_image) }} --}}
                        @endforeach
                    </div>

                </div>
            </section>
        @endforeach
    @endif

@endif
