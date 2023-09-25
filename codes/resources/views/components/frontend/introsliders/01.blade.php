@if (isset($homesliders))
    @if (count($homesliders) > 0)
        <div class="big-slider animation-slider owl-carousel owl-theme owl-nav-bg owl-nav-arrow row cols-1 gutter-no"
            data-owl-options="{
                'items': 1,
                'autoplay': 200,
                'loop': true,
                'nav': true,
                'dots': true,
                'autoplayTimeout': 5000,
                'animateIn': 'fadeIn',
                'animateOut': 'fadeOut'
            }">
            @foreach ($homesliders as $slider)
                <a href="{{ route('slider.slug', ['slug' => $slider->id]) }}">

                    <div class="big-slide1 banner banner-fixed code-content" style="background-color: #fff">

                        {{-- Banner Image --}}

                        <figure>
                            {{-- <img src="{{ Voyager::image($slider->background_image) }}" alt="{{ env('APP_NAME').'-'.$slider->title_1 }}"> --}}
                            <picture>
                                <source media="(min-width:650px)"
                                    srcset="{{ Voyager::image($slider->background_image) }}">
                                @if (empty($slider->mb_background_image))
                                    <source media="(min-width:465px)"
                                        srcset="{{ Voyager::image($slider->background_image) }}">
                                    <img src="{{ Voyager::image($slider->background_image) }}"
                                        alt="{{ env('APP_NAME') }}-slider-{{ $slider->id }}" style="width:auto;">
                                @else
                                    <source media="(min-width:465px)"
                                        srcset="{{ Voyager::image($slider->mb_background_image) }}">
                                    <img src="{{ Voyager::image($slider->mb_background_image) }}"
                                        alt="{{ env('APP_NAME') }}-slider-{{ $slider->id }}" style="width:auto;">
                                @endif


                            </picture>
                        </figure>



                    </div>

                </a>
            @endforeach
        </div>

    @endif
@endif
