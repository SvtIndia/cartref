@extends('layouts.website')

@section('meta-seo')
    <title>
        {{-- @if (request('category'))
            {{ ucwords(str_replace('-', ' ', request('category'))).' - ' }}
        @elseif(request('subcategory'))
        {{ ucwords(str_replace('-', ' ', request('subcategory'))).' - ' }}
        @endif

        {{ Config::get('seo.catalog.title') }} --}}
        Vendors
    </title>

    <meta name="keywords" content="{{ Config::get('seo.catalog.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.catalog.description') }}">
@endsection
@section('headerlinks')
    <style>
        .vendor-wrap {
            width: 100%;
            height: 100%;
            position: relative;
            background: white;
            margin-bottom: 2rem;
        }

        .vendor {
            width: 100%;
            height: auto;
            background: linear-gradient(180deg, rgb(141, 205, 239) 0%, rgba(4.23, 194.01, 253.94, 0) 100%);
        }

        .vendor .brand-img {
            width: 100% !important;
            height: 250px;
        }

        .vendor .content {
            width: 100% !important;
            text-align: center !important;
            color: black;
            word-wrap: break-word;

        }

        .vendor .content .brand {
            font-size: 30px;
            font-weight: 400;
            letter-spacing: 5px;
        }

        .vendor .content .description {
            font-size: 15px;
            font-weight: 400;
            letter-spacing: 3.60px;
        }

        .vendor .content-store {
            width: 100% !important;
            text-align: right !important;
            color: black;
            word-wrap: break-word;
        }

        .vendor .content-store .label {
            font-size: 15px;
            font-weight: 400;
            line-height: 18px;
            letter-spacing: 1.88px;
        }

        .vendor .content-store .rating {
            font-size: 32px;
            font-weight: 600;
            letter-spacing: 4px;
            text-align: right;
        }

        @media only screen and (max-width: 768px) {
            .vendor-wrap {
                margin-bottom: 2rem;
            }
            .vendor .brand-img {
                height: 180px;
            }

            .vendor .content .brand {
                font-size: 12px;
                font-weight: 500;
                letter-spacing: 3px;
                text-align: center;
            }

            .vendor .content .description {
                font-size: 12px;
                letter-spacing: 0px
            }

            .vendor .content-store .label {
                font-size: 12px;
                font-weight: 400;
                letter-spacing: 1.2px;
            }

            .vendor .content-store .rating {
                text-align: right;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: 4px;
            }
        }
    </style>
@endsection


@section('content')
    <div class="page-content">
        <div class="page-content mb-10 pb-3">
            <div class="container mt-10 mb-10">
                <div class="row main-content-wrap gutter-lg">
                    <div class="col-lg-12 main-content">
                        <div class="row cols-2 cols-sm-3 product-wrapper box-mode">
                            @foreach ($users as $user)
                                <div class="vendor-wrap">
                                    <div class="vendor" style="background: linear-gradient(180deg, {{ $user->brand_bg_color }} 0%, rgba(4.23, 194.01, 253.94, 0) 100%);">
                                        <img class="brand-img" src="{{ Voyager::image($user->brand_logo) }}"
                                            onerror="this.onerror=null;this.src='{{ config('app.url') }}/images/placeholer.png';" />
                                        <div class="content">
                                            <span class="brand">{{ $user->brands }}</span><br>
                                            <span class="description">{{ $user->brand_description }}</span>
                                        </div>

                                        @if((int)$user->brand_store_rating > 0)
                                            <div class="content-store">
                                                <span class="label">Store Rating:</span>
                                                <span class="rating">{{ $user->brand_store_rating }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Livewire Component wire-end:7siXOD3evKnwmcef4hyX -->
    </div>
@endsection
